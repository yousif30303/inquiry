<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Inquiry;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InquiryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumb->title = "Inquiries";
        $this->breadcrumb->items = [
            route('backend.dashboard') => 'Dashboard'
        ];
    }

    public function index()
    {
        return view('backend.inquiry.index');
    }

    public function edit($id)
    {
        try {
            $this->breadcrumb->title = $id > 0 ? "Edit Inquiry" : "Add Inquiry";
            $button_title = $id > 0 ? "Update Inquiry" : "Add Inquiry";
            $this->breadcrumb->items[route('backend.inquiry.index')] = 'Inquiries';
            $inquiry = Inquiry::firstOrNew(['id' => $id]);
            $date = date("Y-m-d");
            $categories = Category::all();

            return view('backend.inquiry.edit', compact('inquiry', 'categories', 'date', 'button_title', 'id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function view($id)
    {
        try {
            $inquiry = Inquiry::firstOrNew(['id' => $id]);
            $remarks = Remark::where('inquiry_id',$id)->get();
           
            return view('backend.inquiry.new', compact('inquiry','remarks'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function update($id, Request $request)
    {
        /*$request->validate([
            'name' => 'required',
            'location' => 'required',
            'brand' => 'required',
        ]);*/

        try {
            $inquiry = Inquiry::updateOrCreate(['id' => $id], [
                'name' => $request->name,
                'user_id' => $request->user()->id,
                'category_id' => $request->category,
                'mobile' => $request->mobile,
                'date' => $request->date,
                'visit_time' => $request->visit_time,
                'entered_by' => $request->entered_by,
                'remarks' => $request->remarks,
                'status' => 0,
            ]);

            return redirect()->route('backend.inquiry.index')->with('success', 'Inquiry has been ' . ($id == 0 ? 'Created' : 'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        try {
            $inquiry = Inquiry::find($id);
         
            $data = Inquiry::with('category')
                ->where('id',$id)
                ->first();

            return $this->ajaxSuccess($data);

        } catch (\Exception $e) {
            return $this->ajaxFail([], $e->getMessage());
        }
    }

    public function datatable(Request $request)
    {
        try {
            $totalRecords = Inquiry::count();
            $data = Inquiry::with('category')
                ->when($request->start, fn($q)=>$q->offset($request->start))
                ->when($request->length, fn($q)=>$q->limit($request->length))
                ->where('user_id',auth()->user()->id)
                ->orderByDesc('id')
                ->get();

            return $this->ajaxDatatable($data, $totalRecords, $request);

        } catch (\Exception $e) {
            return $this->ajaxFail([], $e->getMessage());
        }
    }
    public function datatableAdmin(Request $request)
    {
        try {
            $totalRecords = Inquiry::count();
            $data = Inquiry::with('category')
                ->when($request->start, fn($q)=>$q->offset($request->start))
                ->when($request->length, fn($q)=>$q->limit($request->length))
                ->orderByDesc('id')
                ->get();

            return $this->ajaxDatatable($data, $totalRecords, $request);

        } catch (\Exception $e) {
            return $this->ajaxFail([], $e->getMessage());
        }
    }

    public function updateRequest($id,$status){
        try {
            Inquiry::where('id',$id)->update(['status'=>$status]);

            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Inquiry Status has Updated.');                 
            }
            return redirect()->back()->with('success', 'Success! Inquiry Status has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $inquiry = Inquiry::find($id);
            $inquiry->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Inquiry has deleted.');
            }
            
            return redirect()->back()->with('success', 'Success! Inquiry has deleted.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
