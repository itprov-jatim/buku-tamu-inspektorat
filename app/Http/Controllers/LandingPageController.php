<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Carbon\Carbon;

class LandingPageController
{
    public function index()
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

        return view('welcome', compact(
            'tamuHariIni', 'tamuBulanIni', 'tamuTahunIni',
            'rombonganHariIni', 'rombonganBulanIni', 'rombonganTahunIni',
        ));
    }

    public function indexPeminjaman()
    {
        return view('welcome_peminjaman');
    }

    public function formPeminjaman()
    {
        return view('peminjaman-mobil.form-pinjam.form-peminjaman');
    }

    public function statusPeminjaman()
    {

        // dummy data
        $data = collect([
            (object) [
                'nama_peminjam' => 'Andi Pratama',
                'mobil' => 'Toyota Avanza',
                'no_registrasi' => 'L 1234 AB',
                'tanggal_pinjam' => '2026-02-10 09:00:00',
                'tanggal_kembali' => '2026-02-10 17:00:00',
                'opsi_driver' => 'dengan_driver',
                'status' => 'pending',
            ],
            (object) [
                'nama_peminjam' => 'Siti Rahma',
                'mobil' => 'Toyota Innova',
                'no_registrasi' => 'L 9876 CD',
                'tanggal_pinjam' => '2026-02-11 08:30:00',
                'tanggal_kembali' => '2026-02-11 15:30:00',
                'opsi_driver' => 'tanpa_driver',
                'status' => 'disetujui',
            ],
        ]);

        return view('peminjaman-mobil.status-pinjam.status', compact('data'));
    }

    public function statusUser()
    {
        $data = [
            'nama_peminjam' => 'Andi Pratama',
            'mobil' => 'Toyota Avanza',
            'no_polisi' => 'L 1234 AB',
            'tgl_pinjam' => '2026-02-12 08:00',
            'tgl_kembali' => '2026-02-12 17:00',
            'driver' => 'Dengan Driver',
            'status' => 'Pending',
            'edit_token' => 'dummy-edit-token-123',
            'approval_token' => 'dummy-approval-token-456',
        ];

        return view('peminjaman-mobil.status-pinjam.status-user', compact('data'));
    }

    public function dataPeminjaman()
    {
        return view('peminjaman-mobil.data-pinjam.data-peminjaman');
    }


      public function dataUser()
    {
        return view('peminjaman-mobil.data-pinjam.data-user');
    }


}
