<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Domain;
use App\Models\Location;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "Domains";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.domain.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit Domain" : "Add Domain";
            $button_title = $id > 0 ? "Update Domain" : "Add Domain";
            $this->breadcrumb->items[route('backend.domain.index')] = 'Domain';
            $domain = Domain::firstOrNew(['id' => $id]);
            $locations = Location::all();
            $brands = Brand::all();

            return view('backend.domain.edit', compact('domain', 'locations', 'brands', 'button_title', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'service_provider' => 'required',
            'ser_pro_email' => 'required',
            'ser_pro_no' => 'required',
            'registeration_date' => 'required',
            'expire_date' => 'required',
            'domain_link' => 'required',
            'username' => 'required',
            'password' => 'required',
            'remarks' => 'required',
        ]);

        try {
            $domain = Domain::updateOrCreate(['id' => $id], [
                'name' => $request->name,
                'service_provider' => $request->service_provider,
                'ser_pro_email' => $request->ser_pro_email,
                'ser_pro_no' => $request->ser_pro_no,
                'registeration_date' => $request->registeration_date,
                'expire_date' => $request->expire_date,
                'domain_link' => $request->domain_link,
                'username' => $request->username,
                'password' => $request->password,
                'remarks' => $request->remarks,
            ]);

            return redirect()->route('backend.domain.index')->with('success', 'Domain has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Domain::count();
            $data = Domain::when($request->start, fn($q)=>$q->offset($request->start))
                ->when($request->length, fn($q)=>$q->limit($request->length))
                ->orderByDesc('id')
                ->get();;

            return $this->ajaxDatatable($data, $totalRecords, $request);

        } catch (\Exception $e) {
            return $this->ajaxFail([], $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role = Domain::find($id);
            $role->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Domain has deleted.');
            }
            return redirect()->back()->with('success', 'Success! Domain has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
