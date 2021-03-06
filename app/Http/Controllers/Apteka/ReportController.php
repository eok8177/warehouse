<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Model\Apteka\Product;
use App\Model\Apteka\Incoming;
use App\Model\Apteka\Outcoming;
use App\Model\Apteka\Client;

use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function index()
    {
        return view('apteka.reports.index');
    }

    public function simple(Request $request)
    {
        $from = ($request->input('from')) ? $request->input('from') : date('Y-m-d');
        $to = ($request->input('to')) ? $request->input('to') : date('Y-m-d');

        // $products = Product::orderBy('bill_id', 'asc')->get();

        $report = DB::table('a_products as sp')
            ->select(DB::raw("sp.*, a_bills.title as bill, 
            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date < '$from')) as start_in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date < '$from')) as start_out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date < '$from')) as start_in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date < '$from')) as start_out_sum,

            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date <= '$to')) as end_in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date <= '$to')) as end_out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date <= '$to')) as end_in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date <= '$to')) as end_out_sum,

            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date >= '$from' and t0_1.date <= '$to')) as in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date >= '$from' and t0_2.date <= '$to')) as out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date >= '$from' and t1_1.date <= '$to')) as in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date >= '$from' and t1_2.date <= '$to')) as out_sum

                    "))
            ->leftJoin('a_bills', 'a_bills.id', '=', 'sp.bill_id')

            ->orderBy('sp.bill_id', 'asc')
            ->orderBy('sp.title', 'asc')

            ->get();

        return view('apteka.reports.simple', [
            'from' => $from,
            'to' => $to,
            'report' => $report,
            ]);
    }

    public function full(Request $request)
    {
        $from = ($request->input('from')) ? $request->input('from') : date('Y-m-d');
        $to = ($request->input('to')) ? $request->input('to') : date('Y-m-d');

        $clients = Client::orderBy('title', 'asc')->pluck('title', 'id')->toArray();

        $condition = "";
        foreach ($clients as $client_id => $client_title) {
            $condition .= ", 
                (select sum(count) from a_outcoming as t where (t.product_id = sp.id and t.date >= '$from' and t.date <= '$to' and t.client_id = $client_id)) as c_count_".$client_id.",

                (select sum(sum) from a_outcoming as t where (t.product_id = sp.id and t.date >= '$from' and t.date <= '$to' and t.client_id = $client_id)) as c_sum_".$client_id."
            ";
        }

        $report = DB::table('a_products as sp')
            ->select(DB::raw("sp.*, a_bills.title as bill, 
            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date < '$from')) as start_in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date < '$from')) as start_out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date < '$from')) as start_in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date < '$from')) as start_out_sum,

            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date <= '$to')) as end_in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date <= '$to')) as end_out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date <= '$to')) as end_in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date <= '$to')) as end_out_sum,

            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date >= '$from' and t0_1.date <= '$to')) as in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date >= '$from' and t0_2.date <= '$to')) as out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date >= '$from' and t1_1.date <= '$to')) as in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date >= '$from' and t1_2.date <= '$to')) as out_sum"
            .$condition
                ))
            ->leftJoin('a_bills', 'a_bills.id', '=', 'sp.bill_id')

            ->orderBy('sp.bill_id', 'asc')
            ->orderBy('sp.title', 'asc')

            ->get();


        return view('apteka.reports.full', [
            'from' => $from,
            'to' => $to,
            'clients' => $clients,
            'report' => $report,
            ]);
    }



    public function excel($from, $to, $type = 'full')
    {
        $clients = Client::orderBy('title', 'asc')->pluck('title', 'id')->toArray();

        $condition = "";
        foreach ($clients as $client_id => $client_title) {
            $condition .= ", 
                (select sum(count) from a_outcoming as t where (t.product_id = sp.id and t.date >= '$from' and t.date <= '$to' and t.client_id = $client_id)) as c_count_".$client_id.",

                (select sum(sum) from a_outcoming as t where (t.product_id = sp.id and t.date >= '$from' and t.date <= '$to' and t.client_id = $client_id)) as c_sum_".$client_id."
            ";
        }

        $report = DB::table('a_products as sp')
            ->select(DB::raw("sp.*, a_bills.title as bill, 
            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date < '$from')) as start_in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date < '$from')) as start_out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date < '$from')) as start_in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date < '$from')) as start_out_sum,

            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date <= '$to')) as end_in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date <= '$to')) as end_out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date <= '$to')) as end_in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date <= '$to')) as end_out_sum,

            (select sum(count) from a_incoming as t0_1 where (t0_1.product_id = sp.id and t0_1.date >= '$from' and t0_1.date <= '$to')) as in_count,
            (select sum(count) from a_outcoming as t0_2 where (t0_2.product_id = sp.id and t0_2.date >= '$from' and t0_2.date <= '$to')) as out_count,

            (select sum(sum) from a_incoming as t1_1 where (t1_1.product_id = sp.id and t1_1.date >= '$from' and t1_1.date <= '$to')) as in_sum,
            (select sum(sum) from a_outcoming as t1_2 where (t1_2.product_id = sp.id and t1_2.date >= '$from' and t1_2.date <= '$to')) as out_sum"
            .$condition
                ))
            ->leftJoin('a_bills', 'a_bills.id', '=', 'sp.bill_id')

            ->orderBy('sp.bill_id', 'asc')
            ->orderBy('sp.title', 'asc')

            ->get();


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

        foreach ($report as $key => $item) {
            if (($item->start_in_count - $item->start_out_count) == 0 AND ($item->end_in_count - $item->end_out_count) == 0 AND $item->out_count == 0 AND $item->in_count == 0) continue;
            $array = [];

            $array[] = $item->bill;
            $array[] = $item->title;
            $array[] = $item->measure;
            $array[] = $item->start_in_count - $item->start_out_count;
            $array[] = $item->start_in_sum - $item->start_out_sum;
            $array[] = (float) $item->in_count;
            $array[] = (float) $item->in_sum;
            $array[] = (float) $item->out_count;
            $array[] = (float) $item->out_sum;

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
        }



        // Generate and return the spreadsheet
        Excel::create('apteka', function($excel) use ($excelArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Скллад');
            $excel->setCreator('Laravel')->setCompany('ЦПМСД');
            $excel->setDescription('остатки');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('Лист', function($sheet) use ($excelArray) {
                $sheet->fromArray($excelArray, null, 'A1', false, false);
            });

        })->export('xls');

        return redirect()->route('apteka.dashboard');
    }

}
