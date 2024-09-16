<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Staff;
use Illuminate\Http\JsonResponse;
use Exception;

class StaffController extends Controller
{
    private Staff $staff;

    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function payroll(): JsonResponse
    {
        try {
            $data = $this->staff->salary();

            return response()->json([
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve salary data',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
