<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Work;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function products()
    {
        $products = Product::paginate(30);
        return view('products.index', compact('products'));
    }

    public function productAddPage() {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        return view('products.add');
    }

    public function productAdd(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $product = Product::create([
            'product_name' => $request->product_name,
            'price_tailor' => $request->price_tailor,
            'price_seamstress' => $request->price_seamstress,
            'is_fix' => $request->is_fix == "true" ? "yes" : "no"
        ]);

        if($product){
            return response()->json([
                'status' => 'success',
                'result' => 'ดำเนินการสำเร็จ',
            ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }else {
            return response()->json([
                'status' => 'error',
                'result' => 'โปรดระบุข้อมูลให้ถูกต้อง',
            ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

    }

    public function productRemove(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $works = Work::where('product_id', $request->product_id)->get();
        if(count($works) > 0) {
            return response()->json([
                            'status' => 'warning',
                            'result' => 'ไม่สามารถดำเนินการได้เนื่องจากมีงานที่ส่งอยู่',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $product = Product::where("id", $request->product_id)->delete();
        if($product) {
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

    public function productUpdate(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $is_product = Product::where('product_name', $request->name)->first();

        if($is_product->id != intval($request->product_id)) {
            return response()->json([
                            'status' => 'warning',
                            'result' => 'ชื่อประเภทชุดนี้มีอยู่ในระบบแล้ว',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $product = Product::where("id", $request->product_id)->update(['product_name' => $request->name, 'price_tailor' => $request->tprice, 'price_seamstress' => $request->sprice]);
        if($product) {
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
