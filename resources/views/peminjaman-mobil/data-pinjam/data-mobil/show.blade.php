@extends('peminjaman-mobil.layouts.admin-app')

@section('title', 'Detail Data Tamu')

@section('content')
    <style>
        .table-detail {
            width: 100%;
            table-layout: fixed;
        }

        .table-detail td {
            padding: 5px;
            vertical-align: top;
        }

        .table-detail .label {
            width: 40%;
            font-weight: bold;
        }

        .table-detail .separator {
            width: 5%;
            text-align: center;
        }
    </style>

    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-car"></i> Detail Mobil</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Informasi Utama -->
                    <div class="col">
                        <h5 class="mb-3"><i class="fas fa-id-badge"></i> Informasi Utama</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">No Polisi</th>
                                    <th scope="col">Nama Mobil</th>
                                    <th scope="col">KM Terakhir</th>
                                    <th scope="col">BBM</th>
                                    <th scope="col">Peminjam Terakhir</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><span class="badge"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection