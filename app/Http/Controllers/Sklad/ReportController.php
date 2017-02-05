<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Product;
use App\Model\Sklad\Incoming;
use App\Model\Sklad\Outcoming;

class ReportController extends Controller
{

    public function index()
    {
        return view('sklad.reports.index');
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $from = $data['from'];
        $to = $data['to'].' 23:59:59';

        $products = Product::get();

        $report = array();

        foreach ($products as $product) {
            $in_end_sum = $product->incoming()->where('created_at', '<=' ,$to)->sum('sum');
            $in_start_sum = $product->incoming()->where('created_at', '<=' ,$from)->sum('sum');
            if ($in_end_sum == 0 OR $in_start_sum == 0) {

                $out_start_sum = $product->outcoming()->where('created_at', '<=' ,$from)->sum('sum');
                $out_end_sum = $product->outcoming()->where('created_at', '<=' ,$to)->sum('sum');

                $in  = $product->incoming()->whereBetween('created_at', [$from, $to]);
                $out = $product->outcoming()->whereBetween('created_at', [$from, $to]);

                $report[$product->title]['measure'] = $product->measure;
                $report[$product->title]['start_sum'] = $in_start_sum - $out_start_sum;

                $report[$product->title]['in_sum'] = $in->sum('sum');
                $report[$product->title]['in_count'] = $in->sum('count');
                $report[$product->title]['out_sum'] = $out->sum('sum');
                $report[$product->title]['out_count'] = $out->sum('count');

                $report[$product->title]['end_sum'] = $in_end_sum - $out_end_sum;
            }
        }

        return view('sklad.reports.create', [
            'data' => $data,
            'report' => $report,
            ]);
    }


}
