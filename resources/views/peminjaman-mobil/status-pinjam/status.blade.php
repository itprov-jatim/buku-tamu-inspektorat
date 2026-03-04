@extends('peminjaman-mobil.layouts.app')
@section('content')
    <div class="container-status">
        <div class="content">
            <h1>Status Peminjaman Mobil</h1>
            <p>Daftar pengajuan peminjaman kendaraan dinas</p>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th class="hide-mobile">Mobil</th>
                            <th class="hide-mobile">No. Polisi</th>
                            <th class="hide-mobile">Pinjam</th>
                            <th class="hide-mobile">Kembali</th>
                            <th class="hide-mobile">Driver</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->nama_peminjam }}</td>
                                <td class="hide-mobile">{{ $row->mobil }}</td>
                                <td class="hide-mobile">{{ $row->no_registrasi }}</td>
                                <td class="hide-mobile">
                                    {{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d M Y H:i') }}
                                </td>
                                <td class="hide-mobile">
                                    {{ \Carbon\Carbon::parse($row->tanggal_kembali)->format('d M Y H:i') }}
                                </td>
                                <td class="hide-mobile">
                                    {{ $row->opsi_driver == 'dengan_driver' ? 'Dengan Driver' : 'Tanpa Driver' }}
                                </td>
                                <td>
                                    <span class="badge 
                                                                {{ $row->status == 'pending' ? 'badge-pending' : '' }}
                                                                {{ $row->status == 'disetujui' ? 'badge-disetujui' : '' }}
                                                                {{ $row->status == 'ditolak' ? 'badge-ditolak' : '' }}
                                                            ">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;">Belum ada data peminjaman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection