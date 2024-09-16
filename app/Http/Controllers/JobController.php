<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Applicant;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct(private readonly Applicant $applicant)
    {
    }
    
    public function apply(Request $request)
    {
        $data = $this->applicant->applyJob();
        
        return response()->json([
            'data' => $data
        ]);
    }
}
