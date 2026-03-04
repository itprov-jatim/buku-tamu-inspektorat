@extends('peminjaman-mobil.layouts.app')
@section('content')
    <div class="container-form">
        <div class="content">
            <h1>Form Peminjaman Mobil</h1>
            <p>Silakan isi form berikut untuk melakukan peminjaman kendaraan dinas.</p>

            <form action="{{ route('bukutamu.store') }}" method="POST" class="form-pinjam">
                @csrf

                <div class="form-group">
                    <label>Nama Peminjam</label>
                    <input type="text" name="peminjam" placeholder="Contoh: Udin ITPROV" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Pilih Mobil Tersedia</label>
                    <select name="mobil" required>
                        <option value="">-- Pilih Mobil --</option>
                        <option value="Avanza">Toyota Avanza</option>
                        <option value="Innova">Toyota Innova</option>
                        <option value="Fortuner">Toyota Fortuner</option>
                        <option value="Xenia">Daihatsu Xenia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Opsi Driver (Wajib Pilih Salah 1)</label>

                    <div class="driver-options">
                        <label class="driver-option">
                            <input type="radio" name="opsi_driver" value="dengan_driver" required>
                            <span>Dengan Driver</span>
                        </label>

                        <label class="driver-option">
                            <input type="radio" name="opsi_driver" value="tanpa_driver" required>
                            <span>Tanpa Driver</span>
                        </label>
                    </div>
                </div>




                <div class="form-group">
                    <label>Tujuan Peminjaman</label>
                    <select name="tujuan" required>
                        <option value="">-- Pilih Tujuan --</option>
                        <option value="Dinas Luar Kota">Dinas Luar Kota</option>
                        <option value="Operasional Kantor">Operasional Kantor</option>
                        <option value="Operasional Kantor">Lain - Lain</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-submit">
                    Kirim Permintaan Peminjaman
                </button>

                <a href="" class="btn btn-outline">
                    Sudah Mengirim? Cek di halaman status
                </a>

            </form>
        </div>


    </div>
@endsection