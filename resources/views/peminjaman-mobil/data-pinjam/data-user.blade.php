@extends('peminjaman-mobil.layouts.admin-app')

@section('title', 'Tabel Peminjaman Mobil')

@section('content')

<style>
.btn-filter {
    margin-right: 8px;
}
</style>

<div class="container-fluid">
    <h2 class="mb-4">Report Data Peminjaman </h2>

    <!-- Form filter berdasarkan rentang tanggal -->
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="bukuTamuTable" class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Peminjam</th>
                            <th>Mobil Yang Dipinjam</th>
                            <th>Tujuan Meminjam</th>
                            <th>Tanggal Meminjam</th>
                            <th>Tanggal Selesai Meminjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Script -->
@push('scripts')
<script>
// $(document).ready(function() {
//     $('#bukuTamuTable').DataTable({
//         "paging": true,
//         "searching": true,
//         "ordering": true,
//         "info": true,
//         "autoWidth": false
//     });

//     // Event listener ketika filter tanggal diubah
//     $('#tanggal_mulai, #tanggal_selesai').on('change', function() {
//         const tanggalMulai = $('#tanggal_mulai').val();
//         const tanggalSelesai = $('#tanggal_selesai').val();

//         const url = new URL(window.location.href);
//         const params = new URLSearchParams(url.search);

//         // Update parameter URL untuk tanggal mulai
//         if (tanggalMulai) params.set('tanggal_mulai', tanggalMulai);
//         else params.delete('tanggal_mulai');

//         // Update parameter URL untuk tanggal selesai
//         if (tanggalSelesai) params.set('tanggal_selesai', tanggalSelesai);
//         else params.delete('tanggal_selesai');

//         // Redirect ke URL baru dengan parameter filter
//         window.location.href = `${url.pathname}?${params.toString()}`;
//     });
// });
</script>
@endpush

@endsection