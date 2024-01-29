<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Location;
use App\Models\Switches;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SwitchesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "Routers & Switches";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.switches.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit Router or Switch" : "Add Router or Switch";
            $button_title = $id > 0 ? "Update Server" : "Add Router or Switch";
            $this->breadcrumb->items[route('backend.server.index')] = 'Routers & Switches';
            $switch = Switches::firstOrNew(['id' => $id]);
            $locations = Location::all();
            $brands = Brand::all();

            return view('backend.switches.edit', compact('switch', 'locations', 'brands', 'button_title', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'location' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'port' => 'required',
            'serial_no' => 'required',
            'warranty' => 'required',
            'warranty_expiry_date' => 'required',
            'ip_address' => 'required',
        ]);

        $expiry_date=Carbon::createFromFormat('d-m-Y',$request->warranty_expiry_date)->toDateString();

        try {
            $server = Switches::updateOrCreate(['id' => $id], [
                'location_id' => $request->location,
                'brand_id' => $request->brand,
                'model' => $request->model,
                'port' => $request->port,
                'serial_no' => $request->serial_no,
                'warranty' => $request->warranty,
                'warranty_expiry_date' => $expiry_date,
                'ip_address' => $request->ip_address,
                'type' => $request->type,
            ]);

            return redirect()->route('backend.switches.index')->with('success', 'Router or Switch has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Switches::count();
            $data = Switches::with('location', 'brand')
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
            $role = Switches::find($id);
            $role->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Router or Switch has deleted.');
            }
            return redirect()->back()->with('success', 'Success! Router or Switch has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
