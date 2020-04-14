<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_list  = User::all();
        return view('user.index', compact('user_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data   = $request->all();
        $validasi   = Validator::make($data, [
            'name'  => 'required|max:255',
            'email' => 'required|email|max:100|unique:users',
            'password'  => 'required|confirmed|min:6',
            'level' => 'required|in:admin,operator'
        ]);

        if ($validasi->fails()) {
            return redirect('user/create')
                ->withInput()
                ->withErrors($validasi);
        }

        // hash password
        $data['password']   = bcrypt($data['password']);

        User::create($data);
        Session::flash('flash_message', 'Data user '.$data['name'].' berhasil disimpan.');
        
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user   = User::findOrFail($id);
        $data   = $request->all();

        $validasi   = Validator::make($data, [
            'name'  => 'required|max:255',
            'email' => 'required|email|max:100|unique:users,email,'.$data['id'],
            'password'  => 'sometimes|nullable|confirmed|min:6',
            'level' => 'required|in:admin,operator'
        ]);

        if ($validasi->fails()) {
            return redirect('user/'.$id.'/edit')
                ->withInput()
                ->withErrors($validasi);
        }

        if ($request->filled('password')) {
            $data['password']   = bcrypt($data['password']);
        }
        else $data  = array_except($data, ['password']);

        $user->update($data);
        Session::flash('flash_message', 'Data user '.$data['name'].' berhasil diupdate.');

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Session::flash('flash_message', 'Data user '.$user->name.' telah berhasil dihapus.');
        Session::flash('penting', true);

        return redirect('user');
    }
}
