<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Deduct;
use Carbon\Carbon;

class DeductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $deduct = Deduct::create([
            'user_id' => $request->user_id,
            'detail' => $request->detail,
            'amount' => $request->amount,
            'date' => Carbon::parse($request->date)->format('Y-m-d')." 00:00:00"
        ]);

        if($deduct) {
                return response()->json([
                            'status' => 'success',
                            'result' => 'ดำเนินการสำเร็จ',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json([
                            'status' => 'error',
                            'result' => 'ไม่สามารถดำเนินการได้',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }
    }

    public function remove(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $deduct = Deduct::where('id', $request->id)->delete();

        if($deduct) {
                return response()->json([
                            'status' => 'success',
                            'result' => 'ดำเนินการสำเร็จ',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json([
                            'status' => 'error',
                            'result' => 'ไม่สามารถดำเนินการได้',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }
    }

    public function clear(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $deduct = Deduct::where('user_id', $request->user_id)->delete();

        if($deduct) {
                return response()->json([
                            'status' => 'success',
                            'result' => 'ดำเนินการสำเร็จ',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }else {
                return response()->json([
                            'status' => 'error',
                            'result' => 'ไม่สามารถดำเนินการได้',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }
    }
}
