<?php

namespace App\Http\Controllers;

use App\Models\Internet;
use App\Models\Location;
use Illuminate\Http\Request;

class InternetController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "Internet";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.internet.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit Internet" : "Add Internet";
            $button_title = $id > 0 ? "Update Internet" : "Add Internet";
            $this->breadcrumb->items[route('backend.internet.index')] = 'Internet';
            $internet = Internet::firstOrNew(['id' => $id]);
            $locations = Location::all();


            return view('backend.internet.edit', compact('internet', 'locations',  'button_title', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'location' => 'required',
            'type' => 'required',
            'provider' => 'required',
            'account' => 'required',
            'username' => 'required',
            'monthly_rental' => 'required',
            'ip_address' => 'required',
            'password' => 'required',
            'router' => 'required',
            'speed' => 'required',
        ]);

        try {
            $server = Internet::updateOrCreate(['id' => $id], [
                'location_id' => $request->location,
                'type' => $request->type,
                'ip_address' => $request->ip_address,
                'provider' => $request->provider,
                'account' => $request->account,
                'username' => $request->username,
                'password' => $request->password,
                'speed' => $request->speed,
                'router' => $request->router,
                'monthly_rental' => $request->monthly_rental,
                'remarks' => $request->remarks,
            ]);

            return redirect()->route('backend.internet.index')->with('success', 'Internet has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Internet::count();
            $data = Internet::with('location')
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
            $role = Internet::find($id);
            $role->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Internet has deleted.');
            }
            return redirect()->back()->with('success', 'Success! Internet has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
