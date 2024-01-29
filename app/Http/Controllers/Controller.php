<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use stdClass;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $breadcrumb;

    public function __construct(){
        $this->breadcrumb= new stdClass();
        $this->breadcrumb->title='Dashboard';
        $this->breadcrumb->items=[];
        view()->share('breadcrumb',$this->breadcrumb);
    }

    protected function ajaxSuccess($data,$message='Success'){
        return response()->json(['status'=>true,'data'=>$data,'message'=>$message],200);
    }

    protected function ajaxFail($data=[],$message='Failed'){
        return response()->json(['status'=>false,'data'=>$data,'message'=>$message],400);
    }

    protected function ajaxDatatable($data, $totalRecords, $request){
        return response()->json([
            'draw' => intval($request->draw),
            'aaData' => $data,
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
        ]);
    }

}
