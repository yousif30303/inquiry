<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Outlet;
use App\Models\Location;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "Outlets";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.outlet.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit Outlet" : "Add Outlet";
            $button_title = $id > 0 ? "Update Outlet" : "Add Outlet";
            $this->breadcrumb->items[route('backend.outlet.index')] = 'Outlet';
            $outlet = Outlet::firstOrNew(['id' => $id]);
            $locations = Location::all();
            $brands = Brand::all();

            return view('backend.outlet.edit', compact('outlet', 'locations', 'brands', 'button_title', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'brand' => 'required',
            'ip_address' => 'required',
            'internet_type' => 'required',
            'provider' => 'required',
            'account_no' => 'required',
            'username' => 'required',
            'password' => 'required',
            'speed' => 'required',
            'monthly_rental' => 'required',
            'telephone' => 'required',
            'mobile' => 'required',
            'remarks' => 'required'
        ]);

        try {
            $outlet = Outlet::updateOrCreate(['id' => $id], [
                'name' => $request->name,
                'location_id' => $request->location,
                'brand_id' => $request->brand,
                'ip_address' => $request->ip_address,
                'internet_type' => $request->internet_type,
                'provider' => $request->provider,
                'account_no' => $request->account_no,
                'username' => $request->username,
                'password' => $request->password,
                'speed' => $request->speed,
                'monthly_rental' => $request->monthly_rental,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'remarks' => $request->remarks
            ]);

            return redirect()->route('backend.outlet.index')->with('success', 'Outlet has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Outlet::count();
            $data = Outlet::with('location', 'brand')
                ->when($request->start, fn($q)=>$q->offset($request->start))
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
            $role = Outlet::find($id);
            $role->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Outlet has deleted.');
            }
            return redirect()->back()->with('success', 'Success! Outlet has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
