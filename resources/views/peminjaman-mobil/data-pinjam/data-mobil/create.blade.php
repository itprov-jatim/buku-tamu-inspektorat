@extends('peminjaman-mobil.layouts.admin-app')

@section('title', 'Tabel Peminjaman Mobil')

@section('content')


<div class="container">
       

        <div class="card shadow p-4">
            <form action="" method="POST">
                @csrf

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="bkd_identitas">No. Polisi</label>
                        <input type="text" name="bkd_identitas" id="bkd_identitas" class="form-control"
                            value="{{ old('bkd_identitas') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bkd_nama">Nama dan Warna Mobil</label>
                        <input type="text" name="bkd_nama" id="bkd_nama" class="form-control" value="{{ old('bkd_nama') }}"
                            required>
                    </div>
                </div>

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="bkd_jenis_kelamin">Kilometer</label>
                        <input type="file" for="kilometer" class="form-control"> 

                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bkd_telepon">BBM</label>
                        <input type="text" name="bkd_telepon" id="bkd_telepon" class="form-control">
                    </div>
                </div>

                <div class="flex-row-form">

                    <div class="form-group">
                        <label class="form-label" for="keperluan-search">Peminjam Terakhir</label>
                        <input type="text" id="keperluan-search" name="bkd_keperluan" class="form-control"
                            placeholder="Cari Keperluan..." required value="{{ old('bkd_keperluan') }}">
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