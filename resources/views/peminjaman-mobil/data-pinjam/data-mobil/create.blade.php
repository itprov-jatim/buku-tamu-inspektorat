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
                        <input type="text" name="nopol" id="nopol" class="form-control" value="{{ old('nopol') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama_mobil">Nama dan Warna Mobil</label>
                        <input type="text" name="nama_mobil" id="nama_mobil" class="form-control"
                            value="{{ old('nama_mobil') }}" required>
                    </div>
                </div>

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="kilometer">Kilometer</label>
                        <input type="file" for="kilometer" class="form-control-file " id="ImageInput1" accept="image/*">
                    </div>
                    <div class="form-group">
                        <img id="previewImage1" src="" alt="Preview"
                            style="display:none; max-width:200px; border-radius:10px; margin-top:10px;">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bbm">BBM</label>
                        <input type="file" name="bbm" id="bbm" class="form-control-file" id="ImageInput2" accept="image/*">
                    </div>
                    <div class="form-group">
                        <img id="previewImage1" src="" alt="Preview"
                            style="display:none; max-width:200px; border-radius:10px; margin-top:10px;">
                    </div>
                </div>

                <div class="flex-row-form">

                    <div class="form-group">
                        <label class="form-label" for="peminjam_terakhir">Peminjam Terakhir</label>
                        <input type="text" id="peminjam_terakhir" name="peminjam_terakhir" class="form-control" readonly>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function setupImagePreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);

                input.addEventListener('change', function () {
                    const file = this.files[0];

                    if (!file) {
                        preview.style.display = 'none';
                        return;
                    }

                    // validasi tipe
                    if (!file.type.startsWith('image/')) {
                        alert('File harus berupa gambar!');
                        input.value = '';
                        return;
                    }

                    // validasi ukuran
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran gambar maksimal 2MB');
                        input.value = '';
                        return;
                    }

                    // preview
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                });
            }

            // panggil untuk 2 input
            setupImagePreview('imageInput1', 'previewImage1');
            setupImagePreview('imageInput2', 'previewImage2');
        </script> 
    @endpush

@endsection