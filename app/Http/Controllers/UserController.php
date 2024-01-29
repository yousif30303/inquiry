<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = 'User Management';
        $this->breadcrumb->items[route('backend.dashboard')] = 'Dashboard';
    }

    public function index()
    {
        return view('backend.user.index');
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = User::count();
            $data = User::with(['roles:name'])
                ->when($request->start, fn($q)=>$q->offset($request->start))
                ->when($request->length, fn($q)=>$q->limit($request->length))
                ->orderByDesc('id')
                ->get();

            return $this->ajaxDatatable($data, $totalRecords, $request);

        } catch (\Exception $e) {
            return $this->ajaxFail([], $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit User" : "Add User";
            $button_title = $id > 0 ? "Update User" : "Add User";
            $this->breadcrumb->items[route('backend.user.index')] = 'User Management';
            $user = User::with('roles')->firstOrNew(['id' => $id]);
            $roles = Role::all();
            return view('backend.user.edit', compact('user', 'roles', 'button_title', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $rules=[
            'name' => 'required',
            'roles'=> 'array',
            'email'=>'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
        ];
        if($id < 1){
            $rules=array_merge($rules,[
                'password' => 'required | confirmed',
                'password_confirmation' => 'required'
            ]);
        }
        $request->validate($rules);
        try {
            $data=[
                'name' => $request->name,
                'email' => $request->email,
            ];
            if(isset($request->password)){
                $data=array_merge($data,[
                    'password' => $request->password,
                ]);
            }
            $role = User::updateOrCreate(['id' => $id],$data);
            $role->roles()->sync($request->roles);
            return redirect()->route('backend.user.index')->with('success', 'User has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $userCheck = User::whereHas('roles', fn($q) => $q->where('id', 1))->where('id',$id)->first();
            if ($userCheck) {
                throw new \Exception("Super Admin can't be deleted!");
            }
            $user = User::find($id);
            $user->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! User has deleted.');
            }
            return redirect()->back()->with('success', 'Success! User has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
