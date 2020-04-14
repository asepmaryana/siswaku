<?php

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
Route::get('/', 'PagesController@homepage');
Route::get('about', 'PagesController@about');
Route::get('halaman-rahasia', 'RahasiaController@halamanRahasia')->name('secret');
Route::get('test-collection', 'SiswaController@testCollection');
Route::get('date-mutator', 'SiswaController@dateMutator');

Auth::routes(['register'=>false]);
Route::get('/home', 'HomeController@index')->name('home');

Route::get('siswa/cari', 'SiswaController@cari');
Route::resource('siswa', 'SiswaController');
Route::resource('kelas', 'KelasController')->parameters(['kelas'=>'kelas']);
Route::resource('hobi', 'HobiController');
Route::resource('user', 'UserController');

/*
Route::get('sampledata', function () {
    DB::table('kelas')->insert([
        [
            'nama_kelas'    => 'IX - IPA'            
        ],
        [
            'nama_kelas'    => 'IX - IPS'
        ],
        [
            'nama_kelas'    => 'IX - BHS'
        ]
    ]);
    
    DB::table('siswa')->insert([
        [
            'nisn'          => '1001',
            'nama_siswa'    => 'Agus Yulianto',
            'tanggal_lahir' => '1990-02-12',
            'jenis_kelamin' => 'L',
            'id_kelas'      => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
        [
            'nisn'          => '1002',
            'nama_siswa'    => 'Agustina Anggraeni',
            'tanggal_lahir' => '1990-03-01',
            'jenis_kelamin' => 'P',
            'id_kelas'      => 2,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
        [
            'nisn'          => '1003',
            'nama_siswa'    => 'Bayu Firmansah',
            'tanggal_lahir' => '1991-01-12',
            'jenis_kelamin' => 'L',
            'id_kelas'      => 3,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
        [
            'nisn'          => '1004',
            'nama_siswa'    => 'Citra Rahmawati',
            'tanggal_lahir' => '1992-10-12',
            'jenis_kelamin' => 'P',
            'id_kelas'      => 2,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
        [
            'nisn'          => '1005',
            'nama_siswa'    => 'Cindy Lisdiani',
            'tanggal_lahir' => '1993-04-05',
            'jenis_kelamin' => 'P',
            'id_kelas'      => 3,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
        [
            'nisn'          => '1006',
            'nama_siswa'    => 'Dirgantara Renaldi',
            'tanggal_lahir' => '1992-06-03',
            'jenis_kelamin' => 'L',
            'id_kelas'      => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
        [
            'nisn'          => '1007',
            'nama_siswa'    => 'Edwin Sanjaya',
            'tanggal_lahir' => '1991-05-06',
            'jenis_kelamin' => 'L',
            'id_kelas'      => 3,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
        [
            'nisn'          => '1008',
            'nama_siswa'    => 'Fitri Rahmani',
            'tanggal_lahir' => '1994-08-10',
            'jenis_kelamin' => 'P',
            'id_kelas'      => 2,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ],
    ]);
    
});

Route::get('siswa', 'SiswaController@index');
Route::get('siswa/create', 'SiswaController@create');
Route::get('siswa/{id}', 'SiswaController@show');
Route::get('siswa/{id}/edit', 'SiswaController@edit');
Route::post('siswa', 'SiswaController@store');
Route::patch('siswa/{id}/update', 'SiswaController@update');
Route::delete('siswa/{siswa}', 'SiswaController@destroy');

Route::get('showmesecret', function(){
    return redirect()->route('secret');
});

Route::get('halaman-rahasia', [
    'as'    => 'secret',
    'uses'  => 'RahasiaController@halamanRahasia'
]);
Route::get('/', function () {
    return view('pages.homepage');
	//return 'Halaman Hello.<br>Selamat Belajar Laravel';
});
Route::get('about', function () {
    return view('pages.about');
});
Route::get('siswa', function(){
    $siswa  = ['Rasmus Lerdorf', 'Taylor Otwel', 'Brendan Eich', 'John Resig'];
    return view('siswa.index', ['siswa' => $siswa]);
});
Route::get('halaman-rahasia', ['as'=>'secret', function(){
    return 'Anda sedang melihat <strong>Halaman Rahasia</strong>';
}]);
Route::get('halaman-rahasia', function(){
    return 'Anda sedang melihat <strong>Halaman Rahasia</strong>';
})->name('secret');
*/

