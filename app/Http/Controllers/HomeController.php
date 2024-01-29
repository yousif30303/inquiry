<?php

namespace App\Http\Controllers;

use App\Models\AssessmentReport;
use App\Models\Assessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $assessors = 0;
        return view('backend.index', compact('assessors'));
    }

    public function data()
    {
        try {
            $total_records = AssessmentReport::count();
            $pass_records = AssessmentReport::where('result', 'Pass')->count();
            $fail_records = AssessmentReport::where('result', 'Fail')->count();
            $absent_records = AssessmentReport::where('result', 'Absent')->count();

            $assessment = AssessmentReport::select('result', 'assessors.sb_id')->join('assessors', 'assessors.id', 'assessment_reports.assessor_id')->get();
            $assessment = $assessment->groupby('sb_id');
            $assesors = $assessment->keys()->toArray();
            $assessment_pass = array();
            $assessment_fail = array();
            $assessment_absent = array();
            $count = 0;
            foreach ($assessment->transform(function ($item, $k) {
                return $item->groupBy('result')->transform(fn($item2) => $item2->count());
            }) as $asses) {
                $assessment_absent[$count] = 0;
                $assessment_pass[$count] = 0;
                $assessment_fail[$count] = 0;
                foreach ($asses as $key => $as) {
                    if ($key == 'Pass') {
                        $assessment_pass[$count] = $as;
                    } elseif ($key == 'Fail') {
                        $assessment_fail[$count] = $as;
                    } elseif ($key == 'Absent') {
                        $assessment_absent[$count] = $as;
                    }
                }
                $count++;
            }
            $data = AssessmentReport::select(['*', DB::raw('DATEDIFF(SECOND, start_time , end_time) AS assessment_time')])->with('assessor')
                ->limit(10)
                ->latest()->get();
            return response()->json([
                'assesors' => $assesors,
                'assessment_pass' => $assessment_pass,
                'assessment_fail' => $assessment_fail,
                'assessment_absent' => $assessment_absent,
                'total_count' => $total_records,
                'pass_count' => $pass_records,
                'fail_count' => $fail_records,
                'absent_count' => $absent_records,
                'assessments' => $data,
            ]);
        } catch (\Exception $e) {
            return $this->ajaxFail([], $e->getMessage());
        }
    }
}
