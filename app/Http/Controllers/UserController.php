<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user_show',['only' => ['index','show']]);
        $this->middleware('permission:user_create',['only' => ['create','store']]);
        $this->middleware('permission:user_update',['only' => ['edit','update']]);
        $this->middleware('permission:user_delete',['only' => 'destroy']);
    }

    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|min:3|max:30",
            "email" => "required",
            "password" => "required",
        ])->validate();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->assignRole($request->role);

        return redirect()->route('user.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit',[
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "name" => "required|min:3|max:30",
            "email" => "required",
        ])->validate();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->input('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->syncRoles($request->role);

        return redirect()->route('user.index')->with(['success' => 'Data berhasil diubah!']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        if ($user) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
