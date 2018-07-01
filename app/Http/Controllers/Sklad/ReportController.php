<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Model\Sklad\Product;
use App\Model\Sklad\Incoming;
use App\Model\Sklad\Outcoming;
use App\Model\Sklad\Client;

use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function index()
    {
        return view('sklad.reports.index');
    }

    public function simple(Request $request)
    {
        $from = ($request->input('from')) ? $request->input('from') : date('Y-m-d');
        $to = ($request->input('to')) ? $request->input('to') : date('Y-m-d');

        $result = $this->getFromDB($from, $to, false);
        $clients = $result['clients'];
        $report = $result['report'];

        return view('sklad.reports.simple', [
            'from' => $from,
            'to' => $to,
            'report' => $report,
            ]);
    }

    public function full(Request $request)
    {
        $from = ($request->input('from')) ? $request->input('from') : date('Y-m-d');
        $to = ($request->input('to')) ? $request->input('to') : date('Y-m-d');

        $result = $this->getFromDB($from, $to, 'full');
        $clients = $result['clients'];
        $report = $result['report'];


        return view('sklad.reports.full', [
            'from' => $from,
            'to' => $to,
            'clients' => $clients,
            'report' => $report,
            ]);
    }



    public function excel($from, $to, $type = 'full')
    {

        $result = $this->getFromDB($from, $to, $type);
        $clients = $result['clients'];
        $report = $result['report'];

        $titleArray0 = [];
        $titleArray1 = [];
        array_push($titleArray0, 'Рахунок', 'Найменування', 'од',"Залишок на $from","",'Надійшло', '','Відпущено', '');
        array_push($titleArray1, '', '', '',"Кіл-ть","Сумма",'Кіл-ть', 'Сумма','Кіл-ть', 'Сумма');

        if ($type == 'full') {
            foreach ($clients as $id => $title) {
                $count = 'c_count_'.$id;
                $sum = 'c_sum_'.$id;
                if ($report->sum($sum) == 0) continue;
                array_push($titleArray0, $title, '');
                array_push($titleArray1, 'Кіл-ть');
                array_push($titleArray1, 'Сумма');
            }
        }

        array_push($titleArray0, "Залишок на $to", "");
        array_push($titleArray1, "Кіл-ть", "Сумма");


        $excelArray[] = $titleArray0;
        $excelArray[] = $titleArray1;


        // Insert Formulas
        $bill = 0;
        $row = 3;
        $start = 3;
        $col = 'A';
        foreach ($report as $key => $item) {
            if (($item->start_in_count - $item->start_out_count) == 0 AND ($item->end_in_count - $item->end_out_count) == 0 AND $item->out_count == 0 AND $item->in_count == 0) continue;

            if ($bill != $item->bill AND $row >3) {
                $formulas = ['','','','=SUM(D'.$start.':D'.($row-1).')','=SUM(E'.$start.':E'.($row-1).')','=SUM(F'.$start.':F'.($row-1).')','=SUM(G'.$start.':G'.($row-1).')','=SUM(H'.$start.':H'.($row-1).')','=SUM(I'.$start.':I'.($row-1).')'];

                $col = 'J';

                if ($type == 'full') {
                    foreach ($clients as $id => $title) {
                        // $sum = 'c_sum_'.$id;
                        // if ($report->sum($sum) == 0) continue;
                        $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
                        $col++;
                    }
                }

                $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
                $formulas[] = '=SUM('.(++$col).$start.':'.$col.($row-1).')';

                $excelArray[] = $formulas;
                $excelArray[] = [];
                $excelArray[] = [];
                $row+=3;
                $start = $row;
            }


            $array = [];

            $array['A'] = $item->bill;
            $array['B'] = $item->title;
            $array['C'] = $item->measure;
            $array['D'] = $item->start_in_count - $item->start_out_count;
            $array['E'] = $item->start_in_sum - $item->start_out_sum;
            $array['F'] = (float) $item->in_count;
            $array['G'] = (float) $item->in_sum;
            $array['H'] = (float) $item->out_count;
            $array['I'] = (float) $item->out_sum;

            if ($type == 'full') {
                foreach ($clients as $id => $title) {
                    $count = 'c_count_'.$id;
                    $sum = 'c_sum_'.$id;
                    if ($report->sum($sum) == 0) continue;
                    $array[] = (float) $item->$count;
                    $array[] = (float) $item->$sum;
                }
            }

            $array[] = $item->end_in_count - $item->end_out_count;
            $array[] = $item->end_in_sum - $item->end_out_sum;



            $excelArray[] = $array;
            $bill = $item->bill;
            $row++;
        }

        //Formulas to end of the list
        $formulas = ['','','','=SUM(D'.$start.':D'.($row-1).')','=SUM(E'.$start.':E'.($row-1).')','=SUM(F'.$start.':F'.($row-1).')','=SUM(G'.$start.':G'.($row-1).')','=SUM(H'.$start.':H'.($row-1).')','=SUM(I'.$start.':I'.($row-1).')'];

        $col = 'J';
        if ($type == 'full') {
            foreach ($clients as $id => $title) {
                // $sum = 'c_sum_'.$id;
                // if ($report->sum($sum) == 0) continue;
                $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
                $col++;
            }
        }
        $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
        $formulas[] = '=SUM('.(++$col).$start.':'.$col.($row-1).')';
        $excelArray[] = $formulas;





        // Generate and return the spreadsheet
        Excel::create('sklad', function($excel) use ($excelArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Скллад');
            $excel->setCreator('Laravel')->setCompany('ЦПМСД');
            $excel->setDescription('остатки');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('Лист', function($sheet) use ($excelArray) {
                $sheet->fromArray($excelArray, null, 'A1', false, false);
                $sheet->mergeCells('D1:E1');
                $sheet->mergeCells('F1:G1');
                $sheet->mergeCells('H1:I1');
                $sheet->mergeCells('J1:K1');
                $sheet->mergeCells('L1:M1');
                $sheet->mergeCells('N1:O1');
                $sheet->mergeCells('P1:Q1');
                $sheet->mergeCells('R1:S1');
                $sheet->mergeCells('T1:U1');
                $sheet->mergeCells('V1:W1');
                $sheet->mergeCells('X1:Y1');
                $sheet->mergeCells('Z1:AA1');
                $sheet->mergeCells('AB1:AC1');
                $sheet->mergeCells('AD1:AE1');
                $sheet->mergeCells('AF1:AG1');
                $sheet->mergeCells('AH1:AI1');
                $sheet->mergeCells('AJ1:AK1');
                $sheet->mergeCells('AL1:AM1');
                $sheet->mergeCells('AN1:AO1');
                $sheet->mergeCells('AP1:AQ1');
                $sheet->mergeCells('AR1:AS1');
                $sheet->mergeCells('AT1:AU1');
                $sheet->mergeCells('AV1:AW1');
                $sheet->mergeCells('AX1:AY1');
                $sheet->setAutoSize(true);
            });

        })->export('xls');

        return redirect()->route('sklad.dashboard');
    }


    public function excelsheets($from, $to, $type = 'full')
    {

        $result = $this->getFromDB($from, $to, $type);
        $clients = $result['clients'];
        $report = $result['report'];

        $titleArray0 = [];
        $titleArray1 = [];
        array_push($titleArray0, 'Рахунок', 'Найменування', 'од',"Залишок на $from","",'Надійшло', '','Відпущено', '');
        array_push($titleArray1, '', '', '',"Кіл-ть","Сумма",'Кіл-ть', 'Сумма','Кіл-ть', 'Сумма');

        if ($type == 'full') {
            foreach ($clients as $id => $title) {
                $count = 'c_count_'.$id;
                $sum = 'c_sum_'.$id;
                if ($report->sum($sum) == 0) continue;
                array_push($titleArray0, $title, '');
                array_push($titleArray1, 'Кіл-ть');
                array_push($titleArray1, 'Сумма');
            }
        }

        array_push($titleArray0, "Залишок на $to", "");
        array_push($titleArray1, "Кіл-ть", "Сумма");


        $excelArray['title'][1] = $titleArray0;
        $excelArray['title'][2] = $titleArray1;


        // Insert Formulas
        $bills = [];
        $bill = 0;
        $row = 3;
        $start = 3;
        $col = 'A';
        foreach ($report as $key => $item) {
            if (($item->start_in_count - $item->start_out_count) == 0 AND ($item->end_in_count - $item->end_out_count) == 0 AND $item->out_count == 0 AND $item->in_count == 0) continue;

            if ($bill != $item->bill AND $row >3) {
                $formulas = ['','','','=SUM(D'.$start.':D'.($row-1).')','=SUM(E'.$start.':E'.($row-1).')','=SUM(F'.$start.':F'.($row-1).')','=SUM(G'.$start.':G'.($row-1).')','=SUM(H'.$start.':H'.($row-1).')','=SUM(I'.$start.':I'.($row-1).')'];

                $col = 'J';

                if ($type == 'full') {
                    foreach ($clients as $id => $title) {
                        // $sum = 'c_sum_'.$id;
                        // if ($report->sum($sum) == 0) continue;
                        $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
                        $col++;
                    }
                }

                $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
                $formulas[] = '=SUM('.(++$col).$start.':'.$col.($row-1).')';

                $excelArray[$bill][] = $formulas;
                $excelArray[$bill][] = [];
                $excelArray[$bill][] = [];
                $row = 3;
                $start = $row;
                $bills[] = $bill;
            }


            $array = [];

            $array['A'] = $item->bill;
            $array['B'] = $item->title;
            $array['C'] = $item->measure;
            $array['D'] = $item->start_in_count - $item->start_out_count;
            $array['E'] = $item->start_in_sum - $item->start_out_sum;
            $array['F'] = (float) $item->in_count;
            $array['G'] = (float) $item->in_sum;
            $array['H'] = (float) $item->out_count;
            $array['I'] = (float) $item->out_sum;

            if ($type == 'full') {
                foreach ($clients as $id => $title) {
                    $count = 'c_count_'.$id;
                    $sum = 'c_sum_'.$id;
                    if ($report->sum($sum) == 0) continue;
                    $array[] = (float) $item->$count;
                    $array[] = (float) $item->$sum;
                }
            }

            $array[] = $item->end_in_count - $item->end_out_count;
            $array[] = $item->end_in_sum - $item->end_out_sum;



            $excelArray[$item->bill][] = $array;
            $bill = $item->bill;
            $row++;
        }

        //Formulas to end of the list
        $formulas = ['','','','=SUM(D'.$start.':D'.($row-1).')','=SUM(E'.$start.':E'.($row-1).')','=SUM(F'.$start.':F'.($row-1).')','=SUM(G'.$start.':G'.($row-1).')','=SUM(H'.$start.':H'.($row-1).')','=SUM(I'.$start.':I'.($row-1).')'];

        $col = 'J';
        if ($type == 'full') {
            foreach ($clients as $id => $title) {
                // $sum = 'c_sum_'.$id;
                // if ($report->sum($sum) == 0) continue;
                $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
                $col++;
            }
        }
        $formulas[] = '=SUM('.$col.$start.':'.$col.($row-1).')';
        $formulas[] = '=SUM('.(++$col).$start.':'.$col.($row-1).')';
        $excelArray[$bill][] = $formulas;
        $bills[] = $bill;


        // Generate and return the spreadsheet
        Excel::create('sklad', function($excel) use ($excelArray, $bills) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Скллад');
            $excel->setCreator('Laravel')->setCompany('ЦПМСД');
            $excel->setDescription('остатки');



            foreach ($bills as $bill) {
                $array = array_merge($excelArray['title'], $excelArray[$bill]);

                $excel->sheet($bill, function($sheet) use ($array) {
                    $sheet->fromArray($array, null, 'A1', false, false);
                    $sheet->mergeCells('D1:E1');
                    $sheet->mergeCells('F1:G1');
                    $sheet->mergeCells('H1:I1');
                    $sheet->mergeCells('J1:K1');
                    $sheet->mergeCells('L1:M1');
                    $sheet->mergeCells('N1:O1');
                    $sheet->mergeCells('P1:Q1');
                    $sheet->mergeCells('R1:S1');
                    $sheet->mergeCells('T1:U1');
                    $sheet->mergeCells('V1:W1');
                    $sheet->mergeCells('X1:Y1');
                    $sheet->mergeCells('Z1:AA1');
                    $sheet->mergeCells('AB1:AC1');
                    $sheet->mergeCells('AD1:AE1');
                    $sheet->mergeCells('AF1:AG1');
                    $sheet->mergeCells('AH1:AI1');
                    $sheet->mergeCells('AJ1:AK1');
                    $sheet->mergeCells('AL1:AM1');
                    $sheet->mergeCells('AN1:AO1');
                    $sheet->mergeCells('AP1:AQ1');
                    $sheet->mergeCells('AR1:AS1');
                    $sheet->mergeCells('AT1:AU1');
                    $sheet->mergeCells('AV1:AW1');
                    $sheet->mergeCells('AX1:AY1');
                    $sheet->setAutoSize(true);
                });
            }

        })->export('xls');

        return redirect()->route('sklad.dashboard');
    }



    private function getFromDB($from, $to, $type = 'full')
    {
        $clients = Client::orderBy('title', 'asc')->pluck('title', 'id')->toArray();

        $condition = "";
        foreach ($clients as $client_id => $client_title) {
            $condition .= ", 
                (select sum(count) from s_outcoming as t where (t.product_id = sp.id and t.date >= '$from' and t.date <= '$to' and t.client_id = $client_id)) as c_count_".$client_id.",

                (select sum(sum) from s_outcoming as t where (t.product_id = sp.id and t.date >= '$from' and t.date <= '$to' and t.client_id = $client_id)) as c_sum_".$client_id."
            ";
        }

        $report = DB::table('s_products as sp')
            ->select(DB::raw("sp.title,sp.measure, s_bills.title as bill, 
            (select sum(count) from s_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date < '$from')) as start_in_count,
            (select sum(count) from s_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date < '$from')) as start_out_count,

            (select sum(sum) from s_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date < '$from')) as start_in_sum,
            (select sum(sum) from s_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date < '$from')) as start_out_sum,

            (select sum(count) from s_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date <= '$to')) as end_in_count,
            (select sum(count) from s_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date <= '$to')) as end_out_count,

            (select sum(sum) from s_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date <= '$to')) as end_in_sum,
            (select sum(sum) from s_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date <= '$to')) as end_out_sum,

            (select sum(count) from s_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date >= '$from' and t0_1.date <= '$to')) as in_count,
            (select sum(count) from s_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date >= '$from' and t0_2.date <= '$to')) as out_count,

            (select sum(sum) from s_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date >= '$from' and t1_1.date <= '$to')) as in_sum,
            (select sum(sum) from s_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date >= '$from' and t1_2.date <= '$to')) as out_sum"
            .$condition
                ))
            ->leftJoin('s_bills', 's_bills.id', '=', 'sp.bill_id')

            ->orderBy('sp.bill_id', 'asc')
            ->orderBy('sp.title', 'asc')

            ->get();

        return [
            'clients' => $clients,
            'report' => $report,
        ];
    }

}
