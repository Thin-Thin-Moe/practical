<?php

namespace App\Http\Controllers;

use App\Services\InternetServiceProvider\InternetServiceProviderInterface;
use Illuminate\Http\Request;

class InternetServiceProviderController extends Controller
{
    public function getInvoiceAmount(Request $request, InternetServiceProviderInterface $internetServiceProvider)
    {
        $month = $request->input('month', 1);
        $validatedMonth = $this->validateMonth($month);

        if (!$validatedMonth) {
            return response()->json(['error' => 'Invalid month provided'], 400);
        }

        $internetServiceProvider->setMonth($month);

        return response()->json([
            'data' => $internetServiceProvider->calculateTotalAmount(),
        ]);
    }

    private function validateMonth($month)
    {
        return is_numeric($month) && $month >= 1 && $month <= 12 ? (int)$month : false;
    }
}
