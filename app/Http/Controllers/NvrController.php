<?php

namespace App\Http\Controllers;

use App\Models\Nvr;
use App\Models\Brand;
use App\Models\Location;
use Illuminate\Http\Request;

class NvrController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "NVRS";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.nvr.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit NVR" : "Add NVR";
            $button_title = $id > 0 ? "Update NVR" : "Add NVR";
            $this->breadcrumb->items[route('backend.nvr.index')] = 'NVR';
            $nvr = Nvr::firstOrNew(['id' => $id]);
            $locations = Location::all();
            $brands = Brand::all();

            return view('backend.nvr.edit', compact('nvr', 'locations', 'brands', 'button_title', 'id'));
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
            'model' => 'required',
            'port' => 'required',
            'serial_no' => 'required',
            'dyn_dns' => 'required',
            'username' => 'required',
            'channel' => 'required',
            'storage' => 'required',
            'server_port' => 'required',
            'http_port' => 'required',
            'remark' => 'required',

        ]);

        try {
            $nvr = Nvr::updateOrCreate(['id' => $id], [
                'location_id' => $request->location,
                'brand_id' => $request->brand,
                'ip_address' => $request->ip_address,
                'model' => $request->model,
                'port' => $request->port,
                'serial_no' => $request->serial_no,
                'dyn_dns' => $request->dyn_dns,
                'username' => $request->username,
                'channel' => $request->channel,
                'storage' => $request->storage,
                'server_port' => $request->server_port,
                'http_port' => $request->http_port,
                'remark' => $request->remark,
            ]);

            return redirect()->route('backend.nvr.index')->with('success', 'NVR has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Nvr::count();
            $data = Nvr::with('location', 'brand')
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
            $role = Nvr::find($id);
            $role->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! NVR has deleted.');
            }
            return redirect()->back()->with('success', 'Success! NVR has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
