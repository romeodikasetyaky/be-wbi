<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
                return response()->json(['status' => true, 'message' => 'Data saved successfully'], 200);
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

    public function getDetailsNarSatu($NarId) {
        try {
            $data = DB::table('Nar1')->where('id', '=', (int) $NarId)->first();
            if ($data) {
                return response()->json(['status' => true, 'message' => 'success ', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'error', 'data' => $data], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function store_rec1(Request $request) {
        $inputData = $request->all();
        $dataToInsert = array_merge($inputData, [
            'created_at' => Carbon::parse(date("Y-m-d H:i:s")),
            'updated_at' => Carbon::parse(date("Y-m-d H:i:s"))
        ]);
        try {
            $inserted = DB::table('rec1')->insert($dataToInsert);
            if ($inserted) {
                return response()->json(['status' => true, 'message' => 'Data saved successfully'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data insertion failed'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getRecSatu() {
        try {
            $recsatu = DB::table('rec1')->select('id', 'user_name', 'created_at')->get();
            $formattedData = $recsatu->map(function ($item) {
                $item->created_at = Carbon::parse($item->created_at)->format('d/m/Y');
                return $item;
            });
            return response()->json(['status' => true, 'message' => 'success ', 'data' => $formattedData->toArray()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getDetailsRecSatu($recId) {
        try {
            $data = DB::table('rec1')->where('id', '=', (int) $recId)->first();
            if ($data) {
                return response()->json(['status' => true, 'message' => 'success ', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'error', 'data' => $data], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function store_nar1a(Request $request) {
        $inputData = $request->all();
        $dataToInsert = array_merge($inputData, [
            'created_at' => Carbon::parse(date("Y-m-d H:i:s")),
            'updated_at' => Carbon::parse(date("Y-m-d H:i:s"))
        ]);
        try {
            $inserted = DB::table('nar1a')->insert($dataToInsert);
            if ($inserted) {
                return response()->json(['status' => true, 'message' => 'Data saved successfully'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data insertion failed'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getNarSatuA() {
        try {
            $narsatua = DB::table('nar1a')->select('id', 'user_name', 'created_at')->get();
            $formattedData = $narsatua->map(function ($item) {
                $item->created_at = Carbon::parse($item->created_at)->format('d/m/Y');
                return $item;
            });
            return response()->json(['status' => true, 'message' => 'success ', 'data' => $formattedData->toArray()], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getDetailsNarSatuA($NarAId) {
        try {
            $data = DB::table('nar1a')->where('id', '=', (int) $NarAId)->first();
            if ($data) {
                return response()->json(['status' => true, 'message' => 'success ', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'error', 'data' => $data], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function export_rec1(Request $request) {
        $id = $request->query('id') ?? 1;
        $data = DB::table('rec1')->where('id', '=', (int) $id)->first();

        $template_excel = app_path("Plugin/template_excel/template_rec_nar_1.xls");
        $filename = 'Reclaimer Nar 1 - '.$id.'.xlsx';

        $spreadsheet = IOFactory::load($template_excel);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle("Reclaimer NAR 1");

        $spreadsheet->getActiveSheet()->setCellValue('E3', $data->user_name);
        $spreadsheet->getActiveSheet()->setCellValue('E4', date('d F Y H:i', strtotime($data->created_at))); // Output Sample 5 October 2024 12:30

        $data_column = config('export.rec1'); // config/export.php see region rec1
        foreach ($data as $key => $value) {
            foreach ($data_column as $d) {
                if ($key == $d['value']) {
                    if ($d['type'] == 'boolean') {
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$d['key'], $value == 1 ? '1' : '0');
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$d['key'], $value == 1 ? 'Normal' : 'Tidak Normal');
                    } elseif ($d['type'] == 'number') {
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$d['key'], $value);
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$d['key'], $value <= (int) $d['min_value'] ? 'Normal' : 'Tidak Normal');
                    } elseif ($d['type'] == 'text') {
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$d['key'], $value);
                    }
                    break;
                }
            }
        }

        $spreadsheet->getProperties()->setCreator("WBI")
                                     ->setLastModifiedBy("WBI")
                                     ->setTitle("Report_Excel")
                                     ->setSubject("Report")
                                     ->setDescription("Report")
                                     ->setKeywords("Report")
                                     ->setCategory("Report");

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public'); 

        ob_end_clean();
        $writer->save('php://output');
    }

    public function export_nar1(Request $request) {
        $id = $request->query('id') ?? 1;
        $data = DB::table('nar1')->where('id', '=', (int) $id)->first();

        $template_excel = app_path("Plugin/template_excel/template_nar_1.xls");
        $filename = 'Nar 1 - '.$id.'.xlsx';

        $spreadsheet = IOFactory::load($template_excel);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle("NAR 1");

        $spreadsheet->getActiveSheet()->setCellValue('E3', $data->user_name);
        $spreadsheet->getActiveSheet()->setCellValue('E4', date('d F Y H:i', strtotime($data->created_at))); // Output Sample 5 October 2024 12:30

        $data_column = config('export.nar1'); // config/export.php see region nar1
        foreach ($data as $key => $value) {
            foreach ($data_column as $d) {
                if ($key == $d['value']) {
                    if ($d['type'] == 'boolean') {
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$d['key'], $value == 1 ? '1' : '0');
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$d['key'], $value == 1 ? 'Normal' : 'Tidak Normal');
                    } elseif ($d['type'] == 'number') {
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$d['key'], $value);
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$d['key'], $value <= (int) $d['min_value'] ? 'Normal' : 'Tidak Normal');
                    } elseif ($d['type'] == 'text') {
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$d['key'], $value);
                    }
                    break;
                }
            }
        }

        $spreadsheet->getProperties()->setCreator("WBI")
                                     ->setLastModifiedBy("WBI")
                                     ->setTitle("Report_Excel")
                                     ->setSubject("Report")
                                     ->setDescription("Report")
                                     ->setKeywords("Report")
                                     ->setCategory("Report");

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public'); 

        ob_end_clean();
        $writer->save('php://output');
    }

    public function export_nar1a(Request $request) {
        $id = $request->query('id') ?? 1;
        $data = DB::table('nar1a')->where('id', '=', (int) $id)->first();

        $template_excel = app_path("Plugin/template_excel/template_nar_1a.xls");
        $filename = 'Nar 1A - '.$id.'.xlsx';

        $spreadsheet = IOFactory::load($template_excel);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle("NAR 1A");

        $spreadsheet->getActiveSheet()->setCellValue('E3', $data->user_name);
        $spreadsheet->getActiveSheet()->setCellValue('E4', date('d F Y H:i', strtotime($data->created_at))); // Output Sample 5 October 2024 12:30

        $data_column = config('export.nar1a'); // config/export.php see region nar1a
        foreach ($data as $key => $value) {
            foreach ($data_column as $d) {
                if ($key == $d['value']) {
                    if ($d['type'] == 'boolean') {
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$d['key'], $value == 1 ? '1' : '0');
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$d['key'], $value == 1 ? 'Normal' : 'Tidak Normal');
                    } elseif ($d['type'] == 'number') {
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$d['key'], $value);
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$d['key'], $value <= (int) $d['min_value'] ? 'Normal' : 'Tidak Normal');
                    } elseif ($d['type'] == 'text') {
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$d['key'], $value);
                    }
                    break;
                }
            }
        }

        $spreadsheet->getProperties()->setCreator("WBI")
                                     ->setLastModifiedBy("WBI")
                                     ->setTitle("Report_Excel")
                                     ->setSubject("Report")
                                     ->setDescription("Report")
                                     ->setKeywords("Report")
                                     ->setCategory("Report");

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public'); 

        ob_end_clean();
        $writer->save('php://output');
    }
}
