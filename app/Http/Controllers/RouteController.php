<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function store_nar1(Request $request) {
        $inputData = $request->all();
        $dataToInsert = array_merge($inputData, [
            'created_at' => Carbon::parse(date("Y-m-d H:i:s")),
            'updated_at' => Carbon::parse(date("Y-m-d H:i:s"))
        ]);
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

    public function getNarSatu() {
        try {
            $narsatu = DB::table('nar1')->select('id', 'user_name', 'created_at')->get();
            $formattedData = $narsatu->map(function ($item) {
                $item->created_at = Carbon::parse($item->created_at)->format('d/m/Y');
                return $item;
            });
            return response()->json(['status' => true, 'message' => 'success ', 'data' => $formattedData->toArray()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getDetailsNarSatu($narId) {
        try {
            $data = DB::table('nar1')->where('id', '=', (int) $narId)->first();
            if ($data) {
                return response()->json(['status' => true, 'message' => 'success ', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'error', 'data' => $data], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
