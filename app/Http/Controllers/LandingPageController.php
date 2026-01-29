<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

}