<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Product;
use App\Model\Sklad\Outcoming;
use App\Model\Sklad\Incoming;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sklad.dashboard.index', [
            // 'products' => Product::all(),
            'outcomings' => Outcoming::with('client', 'product')->orderBy('id', 'desc')->paginate(15),
            'incomings' => Incoming::with('invoice', 'product')->orderBy('id', 'desc')->paginate(15),
            ]);
    }

}
