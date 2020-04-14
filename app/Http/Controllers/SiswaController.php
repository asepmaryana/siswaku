<?php

namespace App\Http\Controllers;

use App\Hobi;
use App\Siswa;
use App\Telepon;
use App\Kelas;
use App\Http\Requests\SiswaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>[
            'index',
            'show',
            'cari'
        ]]);
    }
    
    //page default
    public function index() {
        $halaman    = 'siswa';
        #$siswa      = ['Rasmus Lerdorf', 'Taylor Otwell', 'Brendan Eich', 'John Resig'];
        #$siswa      = Siswa::all()->sortBy('nama_siswa');
        #$siswa      = Siswa::orderBy('nisn', 'asc')->simplePaginate(5);
        $siswa      = Siswa::orderBy('nisn', 'asc')->paginate(2);
        $jumlah     = Siswa::count();
        #$jumlah     = $siswa->count();

        #return $siswa;
        $list_kelas = Kelas::pluck('nama_kelas', 'id');
        return view('siswa.index', ['halaman'=>$halaman, 'siswa'=>$siswa, 'jumlah'=>$jumlah, 'list_kelas'=>$list_kelas]);
    }

    public function cari(Request $request) {
        $halaman        = 'siswa';
        $kata_kunci     = trim($request->input('kata_kunci'));
        $jenis_kelamin  = $request->input('jenis_kelamin');
        $id_kelas       = $request->input('id_kelas');

        #if (!empty($kata_kunci)) {
            // Query
            $query          = Siswa::where('nama_siswa', 'LIKE', '%'.$kata_kunci.'%');
            (! empty($jenis_kelamin) ? $query->where('jenis_kelamin', $jenis_kelamin) : '');
            (! empty($id_kelas) ? $query->where('id_kelas', $id_kelas) : '');

            $siswa          = $query->paginate(2);
            #$pagination     = $siswa->appends($request->except('page'));
            $pagination     = (! empty($jenis_kelamin) ? $siswa->appends(['jenis_kelamin'=>$jenis_kelamin]) : '');
            $pagination     = (! empty($id_kelas) ? $siswa->appends(['id_kelas'=>$id_kelas]) : '');
            $pagination     = $siswa->appends(['kata_kunci'=>$kata_kunci]);
            $jumlah         = $siswa->total();
        #}
        
        $list_kelas = Kelas::pluck('nama_kelas', 'id');
        return view('siswa.index', [
            'halaman'=>$halaman, 
            'siswa'=>$siswa, 
            'jumlah'=>$jumlah, 
            'kata_kunci'=>$kata_kunci,
            'jenis_kelamin'=>$jenis_kelamin,
            'id_kelas'=>$id_kelas, 
            'pagination'=>$pagination, 
            'list_kelas'=>$list_kelas
        ]);
    }

    public function create() {
        $list_kelas = Kelas::pluck('nama_kelas', 'id');
        $list_hobi  = Hobi::pluck('nama_hobi', 'id');

        return view('siswa.create', ['list_kelas'=>$list_kelas, 'list_hobi'=>$list_hobi]);
        #return view('siswa.create');
    }

    #public function store(Request $request)
    public function store(SiswaRequest $request) {
        $input = $request->all();

        // Upload foto
        if ($request->hasFile('foto')) {
            $input['foto']  = $this->uploadFoto($request);
        }

        // Insert siswa
        $siswa = Siswa::create($input);

        // Insert telepon
        if ($request->input('nomor_telepon')) {
            $this->insertTelepon($siswa, $request);
        }

        // Insert hobi
        $siswa->hobi()->attach($request->input('hobi_siswa'));

        Session::flash('flash_message', 'Data siswa berhasil disimpan.');

        return redirect('siswa');

        /*
        $validator = Validator::make($siswa, [
            'nisn'  => 'required|string|size:4|unique:siswa,nisn',
            'nama_siswa'    => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_telepon' => 'sometimes|nullable|numeric|digits_between:10,15|unique:telepon,nomor_telepon',
            'id_kelas'      => 'required'
        ]);
        
        if($validator->fails()) return redirect('siswa/create')->withInput()->withErrors($validator);
        
        #return $siswa;

        // Foto
        if($request->hasFile('foto')) {
            $foto   = $request->file('foto');
            $ext    = $foto->getClientOriginalExtension();
            if($request->file('foto')->isValid()) {
                $foto_name      = date('YmdHis').'.'.$ext;
                $upload_path    = 'fotoupload';
                $request->file('foto')->move($upload_path, $foto_name);
                $siswa['foto']  = $foto_name;
            }
        }

        
        if($request->filled('nomor_telepon')) {
            $telepon    = new Telepon();
            $telepon->nomor_telepon = $request->input('nomor_telepon');
            $siswa->telepon()->save($telepon);
        }

        

        /*
        $siswa                  = new Siswa();
        $siswa->nisn            = $request->nisn;
        $siswa->nama_siswa      = $request->nama_siswa;
        $siswa->tanggal_lahir   = $request->tanggal_lahir;
        $siswa->jenis_kelamin   = $request->jenis_kelamin;
        $siswa->save();
        */
    }

    public function show($id) {
        $halaman    = 'siswa';
        $siswa      = Siswa::findOrFail($id);
        return view('siswa.show', ['halaman'=>$halaman, 'siswa'=>$siswa]);
    }

    public function edit($id) {
        $siswa      = Siswa::findOrFail($id);
        $list_kelas = Kelas::pluck('nama_kelas', 'id');
        $list_hobi  = Hobi::pluck('nama_hobi', 'id');

        $siswa->nomor_telepon = !empty($siswa->telepon->nomor_telepon) ? $siswa->telepon->nomor_telepon : '';
        
        return view('siswa.edit', ['siswa'=>$siswa, 'list_kelas'=>$list_kelas, 'list_hobi'=>$list_hobi]);
    }

    public function update($id, SiswaRequest $request) {
        $input = $request->all();
        $siswa = Siswa::findOrFail($id);

        // Update foto
        if ($request->hasFile('foto')) {
            $input['foto']  = $this->updateFoto($siswa, $request);
        }
        
        // Update siswa
        $siswa->update($input);

        // Update telepon
        $this->updateTelepon($siswa, $request);

        // Update hobi
        $siswa->hobi()->sync($request->input('hobi_siswa'));

        Session::flash('flash_message', 'Data siswa berhasil diupdate.');

        return redirect('siswa');

        /*
        $validator = Validator::make($input, [
            'nisn'  => 'required|string|size:4|unique:siswa,nisn,'.$request->input('id'),
            'nama_siswa'    => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nomor_telepon' => 'sometimes|nullable|numeric|digits_between:10,15|unique:telepon,nomor_telepon,'.$request->input('id').',id_siswa',
            'id_kelas'      => 'required'
        ]);
        if($validator->fails()) return redirect('siswa/'.$id.'/edit')->withInput()->withErrors($validator);
        

        // Foto. Cek adakah foto ?
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada foto baru
            $exist = Storage::disk('foto')->exists($siswa->foto);
            if (isset($siswa->foto) && $exist) {
                $delete = Storage::disk('foto')->delete($siswa->foto);
            }

            // upload foto baru
            $foto   = $request->file('foto');
            $ext    = $foto->getClientOriginalExtension();
            if ($request->file('foto')->isValid()) {
                $foto_name  = date('YmdHis').'.'.$ext;
                $upload_path    = 'fotoupload';
                $request->file('foto')->move($upload_path, $foto_name);
                $input['foto']  = $foto_name;
            }
        }
        
        // Update nomor_telepon jika sebelumnya sudah ada nomor telp
        if($siswa->telepon) {
            // jika telp diisi, update
            if($request->filled('nomor_telepon')) {
                $telepon = $siswa->telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
            }
            // jika telp tidak diisi, hapus
            else {
                $siswa->telepon()->delete();
            }
        }
        // buat entry baru jika sebelumnya tidak ada nomor telp
        else {
            if($request->filled('nomor_telepon')) {
                $telepon = new Telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
            }
        }
        */
    }

    public function destroy($id) {
        $siswa = Siswa::findOrFail($id);

        // Hapus foto kalau ada
        $this->hapusFoto($siswa);

        $siswa->delete();

        Session::flash('flash_message', 'Data siswa berhasil dihapus.');
        Session::flash('penting', true);

        return redirect('siswa');
    }

    public function testCollection(){
        $orang  = ['rasmus lerdorf', 'taylor otwell', 'brendan eich', 'john resig'];

        #$collection = collect($orang)->map(function($nama){
        #    return ucwords($nama);
        #});

        #return $collection;
        #$collection = Siswa::all();
        #$collection = $collection->whereIn('nisn', ['1004','1006']);
        #$jumlah = $collection->count();
        #return 'Jumlah Data : '.$jumlah;
        $collection = Siswa::select('nisn','nama_siswa')->take(3)->get();
        return $collection;
    }

    public function dateMutator() {
        $siswa = Siswa::findOrFail(1);
        #dd($siswa->tanggal_lahir);
        return "Umur {$siswa->nama_siswa} adalah {$siswa->tanggal_lahir->age} tahun karena tgl lahir nya {$siswa->tanggal_lahir->format('d-m-Y')} akan berulang tahun tgl {$siswa->tanggal_lahir->addYears(30)->format('d-m-Y')}";
    }

    private function insertTelepon(Siswa $siswa, SiswaRequest $request) {
        $telepon = new Telepon();
        $telepon->nomor_telepon = $request->input('nomor_telepon');
        $siswa->telepon()->save($telepon);
    }

    private function updateTelepon(Siswa $siswa, SiswaRequest $request) {
        if ($siswa->telepon) {
            // Jika telp diisi, update
            if ($request->filled('nomor_telepon')) {
                $telepon = $siswa->telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
            }
            else {
                $siswa->telepon()->delete();
            }
        }
        else {
            if ($request->filled('nomor_telepon')) {
                $telepon = new Telepon();
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $siswa->telepon()->save($telepon);
            }
        }
    }

    private function uploadFoto(SiswaRequest $request) {
        $foto   = $request->file('foto');
        $ext    = $foto->getClientOriginalExtension();

        if ($request->file('foto')->isValid()) {
            $foto_name  = date('YmdHis').'.'.$ext;
            $request->file('foto')->move('fotoupload', $foto_name);
            return $foto_name;
        }
        return false;
    }

    private function updateFoto(Siswa $siswa, SiswaRequest $request) {
        // Jika user mengisi foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada foto baru
            $exist  = Storage::disk('foto')->exists($siswa->foto);
            if (isset($siswa->foto) && $exist) {
                $delete = Storage::disk('foto')->delete($siswa->foto);
            }

            // Upload foto baru
            $foto   = $request->file('foto');
            $ext    = $foto->getClientOriginalExtension();
            if ($request->file('foto')->isValid()) {
                $foto_name  = date('YmdHis').'.'.$ext;
                $upload_path    = 'fotoupload';
                $request->file('foto')->move($upload_path, $foto_name);
                return $foto_name;
            }
        }
    }

    private function hapusFoto(Siswa $siswa) {
        $is_foto_exist  = Storage::disk('foto')->exists($siswa->foto);

        if ($is_foto_exist) {
            Storage::disk('foto')->delete($siswa->foto);
        }
    }
}
