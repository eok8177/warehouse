<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Apteka\Product;
use App\Model\Apteka\Outcoming;
use App\Model\Apteka\Incoming;

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
        return view('apteka.dashboard.index', [
            // 'products' => Product::all(),
            'outcomings' => Outcoming::with('client', 'product')->orderBy('id', 'desc')->paginate(15),
            'incomings' => Incoming::with('invoice', 'product')->orderBy('id', 'desc')->paginate(15),
            ]);
    }

}
