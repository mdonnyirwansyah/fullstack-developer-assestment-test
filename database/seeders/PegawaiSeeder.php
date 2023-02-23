<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawai = collect(array(
            array(
                'nama' => 'Jane Doe',
                'kota' => 'Madrid',
                'pekerjaan' => 'Programmer'
            ),
            array(
                'nama' => 'Adam Smith',
                'kota' => 'London',
                'pekerjaan' => 'UI/UI Designer'
            ),
            array(
                'nama' => 'Steven Berk',
                'kota' => 'Madrid',
                'pekerjaan' => 'System Analyst'
            ),
            array(
                'nama' => 'John Drink Water',
                'kota' => 'Jakarta',
                'pekerjaan' => 'Programmer'
            ),
            array(
                'nama' => 'Alphonse Calman',
                'kota' => 'Paris',
                'pekerjaan' => 'UI/UI Designer'
            ),
            array(
                'nama' => 'Paulo Verbose',
                'kota' => 'Jakarta',
                'pekerjaan' => 'System Analyst'
            ),
            array(
                'nama' => 'Rebecca Bernando',
                'kota' => 'Paris',
                'pekerjaan' => 'Programmer'
            ),
            array(
                'nama' => 'Luis Patrucci',
                'kota' => 'London',
                'pekerjaan' => 'System Analyst'
            ),
            array(
                'nama' => 'Frank Bethoveen',
                'kota' => 'Madrid',
                'pekerjaan' => 'UI/UI Designer'
            ),
            array(
                'nama' => 'Calumn Sweet',
                'kota' => 'Jakarta',
                'pekerjaan' => 'UI/UI Designer'
            ),
            array(
                'nama' => 'Edward Campbell',
                'kota' => 'Lisbon',
                'pekerjaan' => 'Programmer'
            ),
            array(
                'nama' => 'Harry Potter',
                'kota' => 'Jakarta',
                'pekerjaan' => 'UI/UI Designer'
            ),
            array(
                'nama' => 'Gilberto',
                'kota' => 'Lisbon',
                'pekerjaan' => 'System Analyst'
            ),
            array(
                'nama' => 'Luka Smitic',
                'kota' => 'Madrid',
                'pekerjaan' => 'Programmer'
            )
        ));

        $pegawai->each(function ($pegawai) {
            DB::table('tbl_pegawai')->insert([
                'nama' => $pegawai['nama'],
                'kota' => $pegawai['kota'],
                'pekerjaan' => $pegawai['pekerjaan']
            ]);
        });
    }
}
