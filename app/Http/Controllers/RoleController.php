<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role_show',['only' => ['index','show']]);
        $this->middleware('permission:role_create',['only' => ['create','store']]);
        $this->middleware('permission:role_edit',['only' => ['edit','update']]);
        $this->middleware('permission:role_delete',['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('role.index', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create', [
            'authorities' => config('permission.authorities')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required|string|max:50|unique:roles,name",
                'permissions' => "required"
            ],
            [],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $role = Role::create(['name' => $request->name]);
            $role->givePermissionTo($request->permissions);
            return redirect()->route('role.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput($request->all())->with(['error' => $th->getMessage()]);
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('role.detail', [
            'role' => $role,
            'authorities' => config('permission.authorities'),
            'rolePermissions' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('role.edit',[
            'role' => $role,
            'authorities' => config('permission.authorities'),
            'permissionChecked' => $role->permissions->pluck('name')->toArray()
        ]);
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

            $role = Role::findOrFail($id);
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => "required|string|max:50|unique:roles,name,".$role->id,
                    'permissions' => "required"
                ],
                [],
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }

            try {
                $role->name = $request->name;
                $role->syncPermissions($request->permissions);
                $role->save();
                return redirect()->route('role.index')->with(['success' => 'Data Berhasil Diubah!']);
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->withInput($request->all())->with(['error' => $th->getMessage()]);
            } finally {
                DB::commit();
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if (User::role($role->name)->count()) {
            return response()->json([
                'status' => 'error'
            ]);
        }
        $role->revokePermissionTo($role->permissions->pluck('name')->toArray());
        $role->delete();
        if($role){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
