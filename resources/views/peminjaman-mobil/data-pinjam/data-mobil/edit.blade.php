@extends('peminjaman-mobil.layouts.admin-app')

@section('title', 'Tabel Peminjaman Mobil')

@section('content')


<div class="container">
       
 
        <div class="card shadow p-4">
            <form action="" method="POST">
                @csrf

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="nopol">No. Polisi</label>
                        <input type="text" name="nopol_edit" id="nopol_edit" class="form-control"
                            value="{{ old('nopol_edit') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama_mobil_edit">Nama dan Warna Mobil</label>
                        <input type="text" name="nama_mobil_edit" id="nama_mobil_edit" class="form-control" value="{{ old('nama_mobil_edit') }}"
                            required>
                    </div>
                </div>

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="kilometer_edit">Kilometer</label>
                        <input type="file" for="kilometer_edit" class="form-control-file"> 

                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bbm_edit">BBM</label>
                        <input type="file" name="bbm_edit" id="bbm_edit" class="form-control-file">
                    </div>
                </div>

                <div class="flex-row-form">

                    <div class="form-group">
                        <label class="form-label" for="peminjam_terakhir_edit">Peminjam Terakhir</label>
                        <input type="text" id="peminjam_terakhir_edit" name="peminjam_terakhir_edit" class="form-control"
                           readonly>
                    </div>
                </div>

               

                <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
            </form>
        </div>
    </div>

@push('scripts')
<script>

</script>
@endpush

@endsection