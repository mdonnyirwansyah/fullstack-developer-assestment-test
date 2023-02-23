<?php

use App\Http\Requests\PesananStoreRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $pegawai = DB::table('tbl_pegawai')->selectRaw('nama, kota, pekerjaan')->get();
    $jmlPekerjaan = DB::table('tbl_pegawai')->selectRaw('pekerjaan, count(id) as jml_pekerjaan')->groupBy('pekerjaan')->get();
    $jmlKota = DB::table('tbl_pegawai')->selectRaw('kota, count(id) as jml_kota')->groupBy('kota')->get();

    $data = array(
        'pegawai' => $pegawai,
        'jmlPekerjaan' => $jmlPekerjaan,
        'jmlKota' => $jmlKota
    );

    return view('pegawai', compact('data'));
})->name('pegawai');
Route::get('/pesanan', function () {
    return view('pesanan');
})->name('pesanan');
Route::post('/pesanan', function (PesananStoreRequest $request) {
    $quotaStand = DB::table('tbl_quota_stand')->where('kd_stand', $request->kd_stand)->where('tanggal_pesanan', $request->tanggal_pesanan)->first();
    $antriStand = DB::table('tbl_antri_stand')->where('kd_stand', $request->kd_stand)->where('tanggal_pesanan', $request->tanggal_pesanan)->where('email', $request->email)->first();
    $antrian = DB::table('tbl_antri_stand')->where('kd_stand', $request->kd_stand)->where('tanggal_pesanan', $request->tanggal_pesanan)->get();

    $jmlAntrian = $antrian->count() > 9 ? '0' .strval($antrian->count() + 1) : $antrian->count() > 0 && $antrian->count() < 10 ? '00' .strval($antrian->count() + 1) : '001';
    $nomorAntri = $request->kd_stand.str_replace('-', '', $request->tanggal_pesanan).$jmlAntrian;
    
    if ($quotaStand && $quotaStand->kd_stand === 'LK') {
        if (!$antriStand) {
            if ($quotaStand->jumlah <= 30) {
                $pesanan = DB::table('tbl_antri_stand')->insertGetId([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'tanggal_pesanan' => $request->tanggal_pesanan,
                    'kd_stand' => $request->kd_stand,
                    'nomor_antri' => $nomorAntri
                ]);
    
                DB::table('tbl_quota_stand')->where('kd_stand', $request->kd_stand)->where('tanggal_pesanan', $request->tanggal_pesanan)->update([
                    'jumlah' => $quotaStand->jumlah + 1
                ]);
    
                return response()->json(['ok' => ['pesanan' => $pesanan, 'nomor_antri' => $nomorAntri]], 201);
            }
    
            return response()->json(['gagal' => 'Antrian sudah penuh!, silahkan pilih tanggal lain.'], 200);
        }

        return response()->json(['gagal' => 'Satu email hanya bisa digunakan untuk memesan 1 kali setiap harinya.'], 422);
    } else if ($quotaStand && $quotaStand->kd_stand === 'FT') {
        if (!$antriStand) {
            if ($quotaStand->jumlah <= 50) {
                $pesanan = DB::table('tbl_antri_stand')->insertGetId([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'tanggal_pesanan' => $request->tanggal_pesanan,
                    'kd_stand' => $request->kd_stand,
                    'nomor_antri' => $nomorAntri
                ]);

                DB::table('tbl_quota_stand')->where('kd_stand', $request->kd_stand)->where('tanggal_pesanan', $request->tanggal_pesanan)->update([
                    'jumlah' => $quotaStand->jumlah + 1
                ]);

                return response()->json(['ok' => ['pesanan' => $pesanan, 'nomor_antri' => $nomorAntri]], 201);
            }

            return response()->json(['gagal' => 'Antrian sudah penuh!, silahkan pilih tanggal lain.'], 200);
        }

        return response()->json(['gagal' => 'Satu email hanya bisa digunakan untuk memesan 1 kali setiap harinya.'], 422);
    } else {
        $pesanan = DB::table('tbl_antri_stand')->insertGetId([
            'nama' => $request->nama,
            'email' => $request->email,
            'tanggal_pesanan' => $request->tanggal_pesanan,
            'kd_stand' => $request->kd_stand,
            'nomor_antri' => $nomorAntri
        ]);

        DB::table('tbl_quota_stand')->insert([
            'kd_stand' => $request->kd_stand,
            'tanggal_pesanan' => $request->tanggal_pesanan,
            'jumlah' => 1
        ]);

        return response()->json(['ok' => ['pesanan' => $pesanan, 'nomor_antri' => $nomorAntri]], 201);
    }
})->name('pesanan.store');
Route::get('/pesanan/{id}/print', function ($id) {
    $pesanan = DB::table('tbl_antri_stand')->where('id', $id)->first();

    if ($pesanan) {
        $pdf = Pdf::loadView('print', compact('pesanan'))->setPaper('a8', 'landscape');

        return $pdf->stream('nomor-antri.pdf');
    } else {
        return abort(404);
    }
})->name('pesanan.print');
