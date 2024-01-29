<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Firewall;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FirewallController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "Firewall";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.firewall.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit Firewall" : "Add Firewall";
            $button_title = $id > 0 ? "Update Firewall" : "Add Firewall";
            $this->breadcrumb->items[route('backend.firewall.index')] = 'Firewall';
            $firewall = Firewall::firstOrNew(['id' => $id]);
            $locations = Location::all();
            $brands = Brand::all();

            return view('backend.firewall.edit', compact('firewall', 'locations', 'brands', 'button_title', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'location' => 'required',
            'brand' => 'required',
            'ip_address' => 'required',
        ]);

        $expiry_date= $request->warranty_expiry_date ? Carbon::createFromFormat('d-m-Y',$request->warranty_expiry_date)->toDateString() : null;

        try {
            $server = Firewall::updateOrCreate(['id' => $id], [
                'location_id' => $request->location,
                'brand_id' => $request->brand,
                'model' => $request->model,
                'port' => $request->port,
                'serial_no' => $request->serial_no,
                'warranty' => $request->warranty,
                'warranty_expiry_date' => $expiry_date,
                'ip_address' => $request->ip_address,
                'firmware' => $request->firmware,
                'remarks' => $request->remarks,
            ]);

            return redirect()->route('backend.firewall.index')->with('success', 'Firewall has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Firewall::count();
            $data = Firewall::with('location', 'brand')
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
            $role = Firewall::find($id);
            $role->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Firewall has deleted.');
            }
            return redirect()->back()->with('success', 'Success! Firewall has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
