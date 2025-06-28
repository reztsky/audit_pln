<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PegawaiHasUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all(['*']);
        $pegawais = Pegawai::all();
        $users = User::with('roles')->paginate(10);
        return view('admin.user.index', compact('roles', 'pegawais', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawais,id',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'role' => 'required|exists:roles,name'
        ]);
        $pegawai = Pegawai::findOrFail($request->id_pegawai);
        $user = User::create([
            'name' => $pegawai->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);
        $user->assignRole($request->role);

        $pegawai_has_user = PegawaiHasUser::create([
            'id_pegawai' => $pegawai->id,
            'id_user' => $user->id
        ]);

        if ($pegawai_has_user) {
            return redirect()->route('user.index')->with('notifikasi_sukses', 'Berhasil Menambahkan User');
        }

        return redirect()->route('user.index')->with('notifikasi_gagal', 'Gagal    Menambahkan User');
    }

    public function detail($id){
        $user=User::with(['hasPegawai.pegawai','roles'])->findOrFail($id);
        return response()->json([
            'data'=>$user
        ],200);
    }

    public function edit($id){
        $user=User::with(['hasPegawai.pegawai','roles'])->findOrFail($id);
        return response()->json([
            'data'=>$user
        ],200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'id_pegawai' => 'required|exists:pegawais,id',
            'username' => 'required|unique:users,username,'.$id,
            'password' => 'nullable',
            'role' => 'required|exists:roles,name'
        ]);
        $pegawai = Pegawai::findOrFail($request->id_pegawai);
        $user=User::findOrFail($id);
        
        $user->username=$request->username;
        $user->name=$pegawai->nama;

        if($request->filled('password')){
            $user->password=Hash::make($request->password);
        }
        $user->save();

        if($user->hasPegawai){
            $user->hasPegawai->update([
                'id_pegawai'=>$request->id_pegawai
            ]);
        }
        
        $user->syncRoles($request->role);

        return redirect()->route('user.index')->with('notifikasi_sukses', 'Berhasil Mengubah User');

    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->hasPegawai()->delete();
        $user->removeRole($user->roles->first()->name);
        $user->delete();

        if ($user) {
            return redirect()->route('user.index')->with('notifikasi_sukses', 'Berhasil Menghapus User');
        }
        return redirect()->route('user.index')->with('notifikasi_gagal', 'Gagal Menghapus User');
    }
}
