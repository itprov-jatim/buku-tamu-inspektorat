@extends('peminjaman-mobil.layouts.app')
@section('content')
    <div class="container-user">
        <div class="content">
            <h1>Status Peminjaman</h1>
            <p>Berikut detail status peminjaman kendaraan Anda.</p>

            <div class="status-card">
                <div class="row">
                    <span class="label">Nama Peminjam</span>
                    <span class="value">{{ $data['nama_peminjam'] ?? $data->nama_peminjam }}</span>
                </div>

                <div class="row">
                    <span class="label">Mobil</span>
                    <span class="value">{{ $data['mobil'] ?? $data->mobil }}</span>
                </div>

                <div class="row">
                    <span class="label">No. Polisi</span>
                    <span class="value">{{ $data['no_polisi'] ?? '-' }}</span>
                </div>

                <div class="row">
                    <span class="label">Tanggal Pinjam</span>
                    <span class="value">{{ $data['tgl_pinjam'] ?? $data->tgl_pinjam }}</span>
                </div>

                <div class="row">
                    <span class="label">Tanggal Kembali</span>
                    <span class="value">{{ $data['tgl_kembali'] ?? $data->tgl_kembali }}</span>
                </div>

                <div class="row">
                    <span class="label">Driver</span>
                    <span class="value">{{ $data['driver'] ?? $data->driver }}</span>
                </div>

                <div class="row">
                    <span class="label">Status</span>
                    <span class="badge 
                {{ ($data['status'] ?? $data->status) == 'Pending' ? 'badge-pending' : '' }}
                {{ ($data['status'] ?? $data->status) == 'Disetujui' ? 'badge-disetujui' : '' }}
                {{ ($data['status'] ?? $data->status) == 'Ditolak' ? 'badge-ditolak' : '' }}
                {{ ($data['status'] ?? $data->status) == 'Selesai' ? 'badge-selesai' : '' }}
            ">
                        {{ $data['status'] ?? $data->status }}
                    </span>
                </div>

                @if(($data['status'] ?? $data->status) === 'Pending')
                    <a href="{{ url('/peminjaman/edit/' . ($data['edit_token'] ?? $data->edit_token)) }}" class="btn btn-outline">
                        ✏️ Ubah Data Peminjaman
                    </a>
                @endif

                @if(($data['status'] ?? $data->status) === 'Disetujui')
                    <a href="{{ url('/pengembalian/' . ($data['approval_token'] ?? $data->approval_token)) }}"
                        class="btn-primary">
                        🚗 Isi Form Pengembalian
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection