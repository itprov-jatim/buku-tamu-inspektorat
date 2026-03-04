<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Lookups;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BukuTamuController
{
    // Menampilkan daftar data buku tamu yang bisa difilter berdasarkan rentang tanggal
    public function index(Request $request)
    {
        $query = BukuTamu::query();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('bkd_tanggal_kunjungan', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $bukuTamu = $query->orderBy('bkd_tanggal_kunjungan', 'desc')
                      ->orderBy('bkd_jam_kunjungan', 'desc')
                      ->get();

        return view('bukutamu.index', compact('bukuTamu'));
    }

    // Menampilkan form tambah data tamu sekaligus statistik jumlah tamu harian, bulanan, dan tahunan
    public function create()
    {
        // Mengambil tanggal hari ini, bulan, dan tahun saat ini
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // Menghitung jumlah tamu per hari, per bulan, dan per tahun
        $tamuHariIni = BukuTamu::whereDate('bkd_tanggal_kunjungan', $hariIni)->count();
        $tamuBulanIni = BukuTamu::whereMonth('bkd_tanggal_kunjungan', $bulanIni)
                                    ->whereYear('bkd_tanggal_kunjungan', $tahunIni)
                                    ->count();
        $tamuTahunIni = BukuTamu::whereYear('bkd_tanggal_kunjungan', $tahunIni)->count();

        // Menghitung jumlah rombongan tamu per hari, per bulan, dan per tahun
        $rombonganHariIni = BukuTamu::whereDate('bkd_tanggal_kunjungan', $hariIni)
            ->whereNotNull('bkd_rombongan')
            ->sum('bkd_rombongan');
        $rombonganBulanIni = BukuTamu::whereMonth('bkd_tanggal_kunjungan', $bulanIni)
            ->whereYear('bkd_tanggal_kunjungan', $tahunIni)
            ->whereNotNull('bkd_rombongan')
            ->sum('bkd_rombongan');
        $rombonganTahunIni = BukuTamu::whereYear('bkd_tanggal_kunjungan', $tahunIni)
            ->whereNotNull('bkd_rombongan')
            ->sum('bkd_rombongan');        

        return view('bukutamu.create', compact(
            'tamuHariIni', 'tamuBulanIni', 'tamuTahunIni',
            'rombonganHariIni', 'rombonganBulanIni', 'rombonganTahunIni',  
        ));
    }

    // Menyimpan data tamu baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'bkd_instansi' => 'required|string|max:255',
            'bkd_nama' => 'required|string|max:255',
            'bkd_keperluan' => 'required|string',
            'bkd_jenis_kelamin' => 'required',
            'bkd_rombongan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menambahkan instansi baru ke tabel buku_tamu_lookups jika belum ada
        if (!Lookups::where('bkl_main', 'instansi')->where('bkl_nilai', $request->bkd_instansi)->exists()) {
            Lookups::create([
                'bkl_main' => 'instansi',
                'bkl_sub' => $request->bkl_sub,
                'bkl_kategori' => $request->bkl_kategori,
                'bkl_nilai' => $request->bkd_instansi,
                'bkl_catatan' => 'created by ' . Auth::id() . ' | ' . Auth::user()->nama_user,
                'bkl_status' => 'A',
                'created_by' => Auth::id() . ' | ' . Auth::user()->nama_user,
                'updated_by' => Auth::id() . ' | ' . Auth::user()->nama_user
            ]);
        }

        // Menambahkan keperluan baru ke tabel buku_tamu_lookups jika belum ada
        if (!Lookups::where('bkl_main', 'keperluan')->where('bkl_nilai', $request->bkd_keperluan)->exists()) {
            Lookups::create([
                'bkl_main' => 'keperluan',
                'bkl_sub' => 'keperluan',
                'bkl_kategori' => 'keperluan',
                'bkl_nilai' => $request->bkd_keperluan,
                'bkl_catatan' => 'created by ' . Auth::id() . ' | ' . Auth::user()->nama_user,
                'bkl_status' => 'A',
                'created_by' => Auth::id() . ' | ' . Auth::user()->nama_user,
                'updated_by' => Auth::id() . ' | ' . Auth::user()->nama_user
            ]);
        }

        // Jika tamu tidak menggunakan kartu akses
        $kartu_akses = null;
        if ($request->bkd_kartu_akses_nama === 'Tidak menggunakan kartu akses' || $request->bkd_kartu_akses_nama === null) {
            $request->merge([
                'bkd_kartu_akses_id' => 'Tidak menggunakan kartu akses',
                'bkd_kartu_akses_nama' => 'Tidak menggunakan kartu akses',
            ]);
            $kartu_akses = null;
        } else {
            // Jika tamu menggunakan kartu akses, ambil data kartu akses dari tabel buku_tamu_lookups
            $kartu_akses = Lookups::where('bkl_main', 'kartu_akses')
                ->where('bkl_nilai', $request->bkd_kartu_akses_nama)
                ->first();

            if (!$kartu_akses) {
                return redirect()->back()->with('error', 'Kartu akses tidak ditemukan!');
            }
        }

        // Membuat nomor tamu dnegan format BKYYMMXXX
        $tahunIni = Carbon::now()->format('y');
        $bulanIni = Carbon::now()->format('m');

        $entriTerakhir = BukuTamu::whereYear('bkd_tanggal_kunjungan', Carbon::now()->year)
                                ->whereMonth('bkd_tanggal_kunjungan', Carbon::now()->month)
                                ->orderBy('bkd_no', 'desc')
                                ->first();

        $nomorBaru = $entriTerakhir ? ((int) substr($entriTerakhir->bkd_no, -3) + 1) : 1;
        $nomorKunjunganTamu = 'BK' . $tahunIni . $bulanIni . str_pad($nomorBaru, 3, '0', STR_PAD_LEFT);

        // Menyimpan data tamu ke dalam database
        BukuTamu::create([
            'bkd_no' => $nomorKunjunganTamu,
            'bkd_tanggal_kunjungan' => Carbon::now()->format('Y-m-d'),
            'bkd_jam_kunjungan' => Carbon::now()->format('H:i:s'),
            'bkd_identitas' => $request->bkd_identitas,
            'bkd_nama' => $request->bkd_nama,
            'bkd_jenis_kelamin' => $request->bkd_jenis_kelamin,
            'bkd_telepon' => $request->bkd_telepon,
            'bkd_instansi' => $request->bkd_instansi,
            'bkd_keperluan' => $request->bkd_keperluan,
            'bkd_rombongan' => $request->bkd_rombongan,
            'bkd_kartu_akses_id' => $kartu_akses->bkl_kategori ?? 'Tidak menggunakan kartu akses',
            'bkd_kartu_akses_nama' => $request->bkd_kartu_akses_nama ?? 'Tidak menggunakan kartu akses',
            'bkd_status' => $request->bkd_kartu_akses_nama === 'Tidak menggunakan kartu akses' ? 'P' : 'O',
            'created_by' => Auth::id() . ' | ' . Auth::user()->nama_user,
            'updated_by' => Auth::id() . ' | ' . Auth::user()->nama_user,
        ]);

        return redirect()->back()->with('success', 'Tamu berhasil ditambahkan!');
    }

    // Menampilkan detail tamu berdasarkan ID data tamu yang dipilih
    public function show($id)
    {
        $bukuTamu = BukuTamu::findOrFail($id);
        
        return view('bukutamu.show', compact('bukuTamu'));
    }

    // Menampilkan form edit data tamu berdasarkan ID yang dipilih
    public function edit($id)
    {
        $bukuTamu = BukuTamu::findOrFail($id);

        return view('bukutamu.edit', compact('bukuTamu'));
    }

    // Memperbarui data tamu
    public function update(Request $request, $id)
    {
        $bukuTamu = BukuTamu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'bkd_instansi' => 'required|string|max:255',
            'bkd_nama' => 'required|string|max:255',
            'bkd_keperluan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek apakah sebelumnya sudah meminjam kartu akses atau sekarang baru meminjam kartu akses
        $sebelumnyaSudahMeminjamKartu = $bukuTamu->bkd_kartu_akses_nama && $bukuTamu->bkd_kartu_akses_nama !== 'Tidak menggunakan kartu akses';
        $baruMeminjamKartu = $request->filled('bkd_kartu_akses_nama') && $request->bkd_kartu_akses_nama !== 'Tidak menggunakan kartu akses';

        // Menentukan status tamu (P: Posted, O: Outstanding)
        if ($request->bkd_kartu_akses_nama === 'Tidak menggunakan kartu akses') {
            $request->merge(['bkd_status' => 'P']); // ketika tidak meminjam kartu akses
        } elseif (!$sebelumnyaSudahMeminjamKartu && $baruMeminjamKartu) {
            $request->merge(['bkd_status' => 'O']); // dari tidak pinjam jadi pinjam
        } elseif ($sebelumnyaSudahMeminjamKartu && !$baruMeminjamKartu) {
            $request->merge(['bkd_status' => 'P']); // dari pinjam jadi tidak pinjam
        } elseif ($request->filled('bkd_status')) {
            $request->merge(['bkd_status' => $request->bkd_status]);
        } else {
            $request->merge(['bkd_status' => $bukuTamu->bkd_status]);
        }

        // Update kartu akses ID berdasarkan nama kartu akses yang dipilih
        if ($request->bkd_kartu_akses_nama === 'Tidak menggunakan kartu akses') {
                $request->merge([
                    'bkd_kartu_akses_id' => 'Tidak menggunakan kartu akses',
                    'bkd_kartu_akses_nama' => 'Tidak menggunakan kartu akses',
                ]);
                $kartu_akses = null;
        } else {
            $kartu_akses = Lookups::where('bkl_main', 'kartu_akses')
                                    ->where('bkl_nilai', $request->bkd_kartu_akses_nama)
                                    ->first();
            if ($kartu_akses) {
                $request->merge([
                    'bkd_kartu_akses_id' => $kartu_akses->bkl_kategori,
                    'bkd_kartu_akses_nama' => $kartu_akses->bkl_nilai,
                ]);
            } else {
                return redirect()->back()->with('error', 'Kartu akses tidak ditemukan!');
            }
        }

        // Memperbaru data tamu
        $bukuTamu->update([
            'bkd_identitas' => $request->bkd_identitas,
            'bkd_nama' => $request->bkd_nama,
            'bkd_jenis_kelamin' => $request->bkd_jenis_kelamin,
            'bkd_telepon' => $request->bkd_telepon,
            'bkd_instansi' => $request->bkd_instansi,
            'bkd_keperluan' => $request->bkd_keperluan,
            'bkd_rombongan' => $request->bkd_rombongan,
            'bkd_kartu_akses_id' => $request->bkd_kartu_akses_id ?? 'Tidak menggunakan kartu akses',
            'bkd_kartu_akses_nama' => $request->bkd_kartu_akses_nama ?? 'Tidak menggunakan kartu akses',
            'bkd_status' => $request->bkd_status,
            'updated_by' => Auth::id() . ' | ' . Auth::user()->nama_user,
        ]);

        return redirect()->route('bukutamu.index')->with('success', 'Data tamu berhasil diperbarui!');
    }

    // Menghapus data tamu berdasarkan ID tamu yang dipilih
    public function destroy($id)
    {
        $bukuTamu = BukuTamu::findOrFail($id);
        $bukuTamu->delete();

        return redirect()->route('bukutamu.index')->with('success', 'Data tamu berhasil dihapus!');
    }

    // Mencari daftar instansi berdasarkan input teks dari pengguna
    public function cariInstansi(Request $request)
    {
        $search = $request->input('instansi');
        $instansi = Lookups::where('bkl_main', 'instansi')
                           ->where('bkl_nilai', 'LIKE', "%{$search}%")
                           ->pluck('bkl_nilai');

        return response()->json($instansi);
    }

    // Mencari daftar keperluan berdasarkan input teks pengguna
    public function cariKeperluan(Request $request)
    {
        $search = $request->input('keperluan');
        $keperluan = Lookups::where('bkl_main', 'keperluan')
                           ->where('bkl_nilai', 'LIKE', "%{$search}%")
                           ->pluck('bkl_nilai');

        return response()->json($keperluan);
    }

    // Menampilkan daftar kartu akses yang sedang tidak dipakai
    public function cariKartuAkses(Request $request)
    {
        $search = $request->input('kartu_akses');

        $kartu_akses = DB::table('buku_tamu_lookups as bkl')->leftJoin('buku_tamu_datas as bkd', function ($join) {
                $join->on('bkl.bkl_nilai', '=', 'bkd.bkd_kartu_akses_nama')
                    ->where('bkd.bkd_status', '=', 'O');
            })
            ->where('bkl.bkl_main', 'kartu_akses')
            ->where('bkl.bkl_status', 'A')
            ->whereNull('bkd.bkd_kartu_akses_nama') 
            ->where('bkl.bkl_nilai', 'like', "%{$search}%")
            ->pluck('bkl.bkl_nilai')
            ->toArray();

        // Menambahkan opsi "Tidak menggunakan kartu akses"
        array_unshift($kartu_akses, 'Tidak menggunakan kartu akses'); 

        return response()->json($kartu_akses);
    }

    // Menampilkan daftar kartu akses yang belum dikembalikan atau sedang dipakai
    public function returnKartuAkses()
    {
        $kartuAksesDigunakan = DB::table('buku_tamu_datas as bkd')
            ->join('buku_tamu_lookups as bkl', 'bkd.bkd_kartu_akses_nama', '=', 'bkl.bkl_nilai')
            ->where('bkl.bkl_main', 'kartu_akses')
            ->where('bkd.bkd_status', 'O')
            ->pluck('bkl.bkl_nilai');

        return view('kartu_akses.return', compact('kartuAksesDigunakan'));
    }

    // Mengembalikan kartu akses dan mengubah bkd_status menjadi "P"
    public function submitKartuAkses(Request $request)
    {
        $kartuNama = $request->input('kartu_akses_nama');
        $kartuId = $request->input('kartu_akses_id');

        if (empty($kartuNama) && empty($kartuId)) {
            return redirect()->back()->with('error', 'Silakan isi nama atau ID kartu akses.');
        }

        $query = BukuTamu::where('bkd_status', 'O');

        if (!empty($kartuNama)) {
            $query->where('bkd_kartu_akses_nama', $kartuNama);
        } elseif (!empty($kartuId)) {
            $query->where('bkd_kartu_akses_id', $kartuId);
        }

        $tamu = $query->first();

        if (!$tamu) {
            return redirect()->back()->with('error', 'Kartu akses tidak ditemukan atau sudah dikembalikan.');
        }

        $tamu->update([
            'bkd_status' => 'P',
            'updated_by' => Auth::user()->nama_user,
            'updated_at' => now(),
        ]);

        return redirect()->route('kartu_akses.index')->with('success', 'Kartu akses berhasil dikembalikan.');
    }
    
    // Mencari data tamu dan melakukan autofill data tamu berdasarkan nomor identitas yang sudah ada di database
    public function cariNomorIdentitasTamu(Request $request)
    {
        $tamu = BukuTamu::where('bkd_identitas', $request->bkd_identitas)->latest()->first();

        if ($tamu) {
            return response()->json([
                'success' => true,
                'bkd_nama' => $tamu->bkd_nama,
                'bkd_jenis_kelamin' => $tamu->bkd_jenis_kelamin,
                'bkd_telepon' => $tamu->bkd_telepon,
                'bkd_instansi' => $tamu->bkd_instansi,
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}