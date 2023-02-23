@extends('layouts')

@section('main')
<main class="container py-5 d-flex flex-sm-row flex-column gap-3">
    <div class="col-12 col-sm-6 card">
        <div class="card-body">
            <h1 class="fs-5 mb-4">Data Pegawai</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['pegawai'] as $index => $pegawai)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $pegawai->nama }}</td>
                            <td>{{ $pegawai->kota }}</td>
                            <td>{{ $pegawai->pekerjaan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Data tidak ditemukan!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 col-sm-6 d-flex flex-column gap-3">
        <div class="col-12 card">
            <div class="card-body">
                <h1 class="fs-5 mb-4">Data Jumlah Pegawai Berdasarkan Pekerjaan</h1>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pekerjaan</th>
                        <th scope="col">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['jmlPekerjaan'] as $index => $jmlPekerjaan)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $jmlPekerjaan->pekerjaan }}</td>
                                <td>{{ $jmlPekerjaan->jml_pekerjaan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 card">
            <div class="card-body">
                <h1 class="fs-5 mb-4">Data Jumlah Pegawai Berdasarkan Kota</h1>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['jmlKota'] as $index => $jmlKota)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $jmlKota->kota }}</td>
                                <td>{{ $jmlKota->jml_kota }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Data tidak ditemukan!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
