@extends('layouts.app')

@section('title', 'Form Buku Tamu')

@section('content')

    <style>
        .ui-autocomplete {
            background-color: white;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1050;
            box-sizing: border-box;
            position: absolute;
        }

        .ui-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .ui-menu-item {
            padding: 8px 12px;
            cursor: pointer;
        }

        .ui-menu-item:hover {
            background-color: #f0f0f0;
        }

        .stats {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .stat-box {
            background: rgb(220, 227, 241);
            padding: 10px;
            border-radius: 12px;
            text-align: center;
            flex: 1;
            font-size: 14px;
            font-weight: bold;
            color: #002244;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            height: auto;
        }

        .stat-box h2 {
            font-size: 20px;
            margin: 2px 0;
            font-weight: 700;
        }

        .stat-box p {
            font-size: 16px;
            margin: 2px 0;
            font-weight: 500;
        }

        .stat-box .icon {
            font-size: 24px;
            margin-bottom: 2px;
        }

        .flex-row-form {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }

        .flex-row-form .form-group {
            flex: 1 1 48%;
        }

        @media (max-width: 768px) {
            .flex-row-form {
                gap: 0;
            }

            .flex-row-form .form-group {
                flex: 1 1 100%;
            }

            .stats {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .stat-box {
                flex: 1 1 48%;
                min-width: 48%;
                margin-bottom: 10px;
            }

            .stat-box:nth-child(3) {
                flex: 1 1 100%;
                order: 3;
            }
        }
    </style>

    <div class="container">
        <!-- Menampilkan pesan success -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Menampilkan pesan error -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow p-4">
            <form action="{{ route('bukutamu.store') }}" method="POST">
                @csrf

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="bkd_identitas">No. Identitas</label>
                        <input type="text" name="bkd_identitas" id="bkd_identitas" class="form-control"
                            value="{{ old('bkd_identitas') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bkd_nama">Nama</label>
                        <input type="text" name="bkd_nama" id="bkd_nama" class="form-control" value="{{ old('bkd_nama') }}"
                            required>
                    </div>
                </div>

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="bkd_jenis_kelamin">Jenis Kelamin</label>
                        <select name="bkd_jenis_kelamin" id="bkd_jenis_kelamin" class="form-control" required>
                            <option value="" disabled {{ old('bkd_jenis_kelamin') ? '' : 'selected' }}>
                                Pilih Jenis Kelamin
                            </option>
                            <option value="L" {{ old('bkd_jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="P" {{ old('bkd_jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="form-label" for="bkd_telepon">Telepon</label>
                        <input type="text" name="bkd_telepon" id="bkd_telepon" class="form-control">
                    </div>
                </div>

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="instansi-search">Instansi</label>
                        <input type="text" id="instansi-search" name="bkd_instansi" class="form-control"
                            placeholder="Cari Instansi..." required autocomplete="off" value="{{ old('bkd_instansi') }}">
                        <small id="instansi-not-found" class="text-danger" style="display: none;">Instansi tidak ditemukan.
                            Silakan isi provinsi/kota dan kategori instansi.</small>

                        <!-- Field tambah instansi baru jika instansi yang diinput belum ada di list instansi -->
                        <div id="new-instansi-fields" style="display: none; margin-top: 1rem;">
                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                <label class="form-label" for="bkl_sub">Provinsi/Kota Instansi</label>
                                <input type="text" id="bkl_sub" name="bkl_sub" class="form-control"
                                    placeholder="Wajib diisi jika menambahkan instansi baru">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="bkl_kategori">Kategori Instansi</label>
                                <input type="text" id="bkl_kategori" name="bkl_kategori" class="form-control"
                                    placeholder="Wajib diisi jika menambahkan instansi baru">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="keperluan-search">Keperluan</label>
                        <input type="text" id="keperluan-search" name="bkd_keperluan" class="form-control"
                            placeholder="Cari Keperluan..." required value="{{ old('bkd_keperluan') }}">
                    </div>
                </div>

                <div class="flex-row-form">
                    <div class="form-group">
                        <label class="form-label" for="bkd_rombongan">Jumlah Rombongan</label>
                        <input type="number" id="bkd_rombongan" name="bkd_rombongan" class="form-control" value="0" min="1"
                            required value="'{{ old('bkd_rombongan') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="kartuakses-search">Nama Kartu Akses</label>
                        <input type="text" id="kartuakses-search" name="bkd_kartu_akses_nama" class="form-control"
                            placeholder="Cari Kartu Akses..." value="{{ old('bkd_kartu_akses_nama') }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
            </form>
        </div>

        <!-- Statistik data kunjungan tamu per hari, per bulan, dan per tahun -->
        <div class="stats">
            <div class="stat-box">
                <h2>{{ now()->day }}</h2>
                <p>{{ $tamuHariIni }} ({{ $rombonganHariIni }}) Pengunjung</p>
            </div>
            <div class="stat-box">
                <h2>{{ now()->translatedFormat('F') }}</h2>
                <p>{{ $tamuBulanIni }} ({{ $rombonganBulanIni }}) Pengunjung</p>
            </div>
            <div class="stat-box">
                <h2>{{ now()->year }}</h2>
                <p>{{ $tamuTahunIni }} ({{ $rombonganTahunIni }}) Pengunjung</p>
            </div>
        </div>
    </div>

    @push('scripts')


        <script>
            $(document).ready(function () {
                // Pencarian Instansi
                $("#instansi-search").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "{{ route('bukutamu.searchInstansi') }}",
                            data: {
                                instansi: request.term,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 0,
                    select: function (event, ui) {
                        $("#instansi-search").val(ui.item.value);
                        return false;
                    },
                    focus: function (event, ui) {
                        $("#instansi-search").val(ui.item.value);
                        return false;
                    },
                    open: function () {
                        const inputWidth = $('#instansi-search').outerWidth();
                        $('.ui-autocomplete').css('width', inputWidth + 'px');
                    }
                });

                // Memeriksa apakah instansi yang diketik ada dalam list
                $("#instansi-search").on("blur change", function () {
                    let instansiInput = $(this).val().trim();
                    if (instansiInput) {
                        $.ajax({
                            url: "{{ route('bukutamu.searchInstansi') }}",
                            data: {
                                instansi: instansiInput,
                                exact: true,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                if (data.length === 0) {
                                    $("#instansi-not-found").show();
                                    $("#new-instansi-fields").show();
                                } else {
                                    $("#instansi-not-found").hide();
                                    $("#new-instansi-fields").hide();
                                }
                            }
                        });
                    } else {
                        $("#instansi-not-found").hide();
                        $("#new-instansi-fields").hide();
                    }
                });

                // Pencarian keperluan
                $("#keperluan-search").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "{{ route('bukutamu.searchKeperluan') }}",
                            data: {
                                keperluan: request.term,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 0,
                    select: function (event, ui) {
                        $("#keperluan-search").val(ui.item.value);
                        return false;
                    },
                    focus: function (event, ui) {
                        $("#keperluan-search").val(ui.item.value);
                        return false;
                    },
                    open: function () {
                        const inputWidth = $('#keperluan-search').outerWidth();
                        $('.ui-autocomplete').css('width', inputWidth + 'px');
                    }
                });

                // Pencarian kartu akses
                $('#kartuakses-search').autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "{{ route('bukutamu.searchKartuAkses') }}",
                            data: {
                                kartu_akses: request.term,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 0,
                    select: function (event, ui) {
                        $("#kartuakses-search").val(ui.item.value);
                        return false;
                    },
                    focus: function (event, ui) {
                        $("#kartuakses-search").val(ui.item.value);
                        return false;
                    },
                    open: function () {
                        const inputWidth = $('#kartuakses-search').outerWidth();
                        $('.ui-autocomplete').css('width', inputWidth + 'px');
                    }
                });

                // Trigger field instansi
                $("#instansi-search").on('click', function () {
                    $(this).autocomplete("search", "");
                });

                // Trigger field keperluan
                $("#keperluan-search").on('click', function () {
                    $(this).autocomplete("search", "");
                });

                // Trigger field kartu akses
                $("#kartuakses-search").on('click', function () {
                    $(this).autocomplete("search", "");
                });

                // Mengisi data tamu berdasarkan nomor identitas 
                $('#bkd_identitas').on('change', function () {
                    var identitas = $(this).val();

                    if (identitas !== '') {
                        $('#bkd_nama, #bkd_jenis_kelamin, #bkd_telepon, #instansi-search')
                            .prop('disabled', true);

                        $.ajax({
                            url: "{{ route('bukutamu.cari-tamu') }}",
                            type: "GET",
                            data: {
                                bkd_identitas: identitas
                            },
                            success: function (data) {
                                if (data.success) {
                                    $('#bkd_nama').val(data.bkd_nama);
                                    $('#bkd_jenis_kelamin').val(data.bkd_jenis_kelamin);
                                    $('#bkd_telepon').val(data.bkd_telepon);
                                    $('#instansi-search').val(data.bkd_instansi);
                                } else {
                                    $('#bkd_nama, #bkd_jenis_kelamin, #bkd_telepon, #instansi-search')
                                        .val('');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("AJAX Error:", status, error);
                                alert("Gagal mengambil data. Silakan coba lagi.");
                            },
                            complete: function () {
                                $('#bkd_nama, #bkd_jenis_kelamin, #bkd_telepon, #instansi-search')
                                    .prop('disabled', false);
                            }
                        });
                    }
                });

            });
        </script>
    @endpush

@endsection