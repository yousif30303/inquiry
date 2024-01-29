<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    public function update(Request $request) {
        try {
            $id =  $request->inquiry;
            $remark_id = $request->remark_id;
            //$inquiry = Inquiry::firstOrNew(['id' => $id]);

            $remark = Remark::updateOrCreate(['id' => $remark_id],[
                'description' => $request->description,
                'user_id'=> auth()->user()->id,
                'inquiry_id' => $id
            ]);

            //Inquiry::where('id',$id)->update(['status'=>1]);
            return redirect()->route('backend.inquiry.view', $id)->with('success', 'Remark has been '.($remark_id==0?'Created':'Updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable(Request $request, $id)
    {
        try {
            $totalRecords = Remark::count();
            $data = Remark::with('inquiry')
                ->when($request->start, fn($q)=>$q->offset($request->start))
                ->when($request->length, fn($q)=>$q->limit($request->length))
                ->where('inquiry_id',$id)
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
            $remark = Remark::find($id);
            $remark->delete();
            if (request()->ajax()) {
                return $this->ajaxSuccess([], 'Success! Remark has deleted.');
            }
            return redirect()->back()->with('success', 'Success! Remark has Deleted.');

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return $this->ajaxFail([], $e->getMessage());
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
