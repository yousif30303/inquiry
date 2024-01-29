<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "Role Management";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.role.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit Role" : "Add Role";
            $button_title = $id > 0 ? "Update Role" : "Add Role";
            $this->breadcrumb->items[route('backend.role.index')] = 'Role Management';
            $role = Role::with('permissions')->firstOrNew(['id' => $id]);
            $permissions = Permission::all();
            $heading = '';
            $all_permissions = [];
            foreach ($permissions as $permission) {
                $per = collect(explode('.', $permission->name));
                if ($heading != ucwords($per->get(0))) {
                    $heading = ucwords($per->get(0));
                }
                $all_permissions[$heading][] = collect(['title' => ucwords($per->get(1)), 'name' => $permission->name, 'id' => $permission->id]);
            }
            return view('backend.role.edit', compact('role', 'permissions', 'button_title', 'all_permissions', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'array'
        ]);
        try {
            $role = Role::updateOrCreate(['id' => $id], [
                'name' => $request->name,
            ]);
            $role->permissions()->sync($request->permissions);
            return redirect()->route('backend.role.index')->with('success', 'Role has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Role::count();
            $data = Role::when($request->start, fn($q)=>$q->offset($request->start))
                ->when($request->length, fn($q)=>$q->limit($request->length))
                ->orderByDesc('id')
                ->get();

            return $this->ajaxDatatable($data, $totalRecords, $request);

        } catch (\Exception $e) {
            return $this->ajaxFail([], $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if ($id == 1) {
                throw new \Exception("Super Admin can't be deleted!");
            }
            $role = Role::findById($id);
            $role->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Role has deleted.');
            }
            return redirect()->back()->with('success', 'Success! Role has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
