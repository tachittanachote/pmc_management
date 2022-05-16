<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Work;
use App\Product;
use Carbon\Carbon;

class PayslipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(Request $request) {
        if(Auth::user()->role != "admin") return redirect()->route('dashboard');

        if(!$request->startAt || !$request->endAt || !$request->id) {
            return redirect()->route('report');
        }

        $startAt = $request->startAt;
        $endAt = $request->endAt;

        $employee = User::where('id', $request->id)->first();
        if(!$employee) {
            return redirect()->route('report');
        }


        $workList = array();
        $totalIncome = 0;

        if($employee->role == "tailor") {

            $works = Work::where('tailor_id', $employee->id)->whereBetween('created_at', [Carbon::parse($request->startAt)->format('Y-m-d')." 00:00:00", Carbon::parse($request->endAt)->format('Y-m-d')." 23:59:59"])->get();

            if(count($works) > 0) {
                foreach($works as $work) {

                    $prouct_price = Product::getTailorPriceByProductId($work->product_id);

                    array_push($workList, (object)[ 
                        "product_name" => Product::getProductNameByProductId($work->product_id),
                        "product_quantity" => $work->quantity,
                        "product_price" => $prouct_price,
                    ]);

                    $totalIncome = $totalIncome + ($prouct_price * $work->quantity);
                }
            }
        }
        if($employee->role == "seamstress") {

            $works = Work::where('user_id', $employee->id)->whereBetween('created_at', [Carbon::parse($request->startAt)->format('Y-m-d')." 00:00:00", Carbon::parse($request->endAt)->format('Y-m-d')." 23:59:59"])->get();

            if(count($works) > 0) {
                foreach($works as $work) {

                    $prouct_price = Product::getSeamstressPriceByProductId($work->product_id);

                    array_push($workList, (object)[ 
                        "product_name" => Product::getProductNameByProductId($work->product_id),
                        "product_quantity" => $work->quantity,
                        "product_price" => $prouct_price,
                    ]);

                    $totalIncome = $totalIncome + ($prouct_price * $work->quantity);
                }
            }
        }

        return view('payslip', compact('employee', 'startAt', 'endAt', 'workList', 'totalIncome'));
    }
}
