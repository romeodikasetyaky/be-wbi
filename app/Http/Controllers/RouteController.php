<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function store_nar1(Request $request) {
        $inputData = $request->all();
        $dataToInsert = array_merge($inputData);
        try {
            $inserted = DB::table('nar1')->insert($dataToInsert);
            if ($inserted) {
                return response()->json(['status' => true, 'message' => 'Data inserted successfully'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data insertion failed'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }

    }
}
