@extends('layouts')

@push('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('nomor-antrian'), {
            keyboard: false
        });
        const modalBody = document.getElementById('modal-body');
        const alert = document.getElementById('alert');

        document.getElementById('kd_stand').addEventListener('change', function () {
            document.getElementById('kd_stand').classList.remove('is-invalid');
        });
        document.getElementById('nama').addEventListener('change', function () {
            document.getElementById('nama').classList.remove('is-invalid');
        });
        document.getElementById('email').addEventListener('change', function () {
            document.getElementById('email').classList.remove('is-invalid');
        });
        document.getElementById('tanggal_pesanan').addEventListener('change', function () {
            document.getElementById('tanggal_pesanan').classList.remove('is-invalid');
        });

        document.getElementById('form-pesanan').addEventListener('submit', function (event) {
            var data = this;
            fetch(data.getAttribute('action'), {
                method: data.getAttribute('method'),
                body: new FormData(data)
            })
            .then((response) => response.json())
            .then(function (data) {
                if (data.ok) {
                    var route = '{{ route("pesanan.print", ":id") }}'
                    route = route.replace(':id', data.ok.pesanan);
                    alert.classList.add('d-none');
                    document.getElementById('print').setAttribute('href', route)
                    modal.show();
                    modalBody.innerHTML = data.ok.nomor_antri;
                }
                if (data.gagal) {
                    alert.classList.remove('d-none');
                    alert.innerHTML = data.gagal;
                }
                if (data.error) {
                    alert.classList.add('d-none');
                    printErrorMsg(data.error);
                }
            });
            event.preventDefault();
        });
    });

    function printErrorMsg(msg) {
        for (var key in msg) {
            msg[key].forEach(function (item) {
                document.getElementById(`${key}`).classList.add('is-invalid');
                document.getElementById(`${key}_err`).innerHTML = item;
            });
        }
    }
</script>
@endpush

@section('main')
<main class="container row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-body">
                <h1 class="fs-5 text-center mb-4">Form Pesanan Foto & Lukis</h1>
                <div class="alert alert-danger d-none" id="alert" role="alert">
                    
                </div>
                <form id="form-pesanan" action="{{ route('pesanan.store') }}" method="post">
                @csrf
                    <div class="mb-3">
                        <select class="form-control form-control-sm" name="kd_stand" id="kd_stand">
                            <option selected disabled>Pilih Stand</option>
                            <option value="FT">Foto</option>
                            <option value="LK">Lukis</option>
                        </select>
                        <small class="invalid-feedback" id="kd_stand_err"></small>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm" name="nama" id="nama" placeholder="Nama Pemesan">
                        <small class="invalid-feedback" id="nama_err"></small>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email">
                        <small class="invalid-feedback" id="email_err"></small>
                    </div>
                    <div class="mb-3">
                        <input type="date" class="form-control form-control-sm" name="tanggal_pesanan" id="tanggal_pesanan">
                        <small class="invalid-feedback" id="tanggal_pesanan_err"></small>
                    </div>
                    <div class="d-grid col-6 mx-auto">
                        <button type="submit" class="btn btn-sm btn-success">Buat Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="nomor-antrian" tabindex="-1" aria-labelledby="nomor-antrian-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="nomor-antrian-label">Nomor Antrian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="modal-body">
            ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <a id="print" target="_blank" class="btn btn-sm btn-primary">Cetak PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection
