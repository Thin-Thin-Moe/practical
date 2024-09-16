<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Staff;

class StaffController extends Controller
{
    public function __construct(private readonly Staff $staff)
    {
    }
    
    public function payroll()
    {
        $data = $this->staff->salary();
    
        return response()->json([
            'data' => $data
        ]);
    }
}
