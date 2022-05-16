<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Announce;

class AnnounceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function index() {
        $announce = Announce::getAnnounce();
        return view('announce', compact('announce'));
    }

    public static function create(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        if($request->file && $request->file != "undefined") {
            $imageFile = time().'.'.$request->file->getClientOriginalExtension();
            $announce = Announce::create([
                'message' => $request->message,
                'image_url' => $imageFile
            ]);
            if($announce) {
                $request->file->move(base_path() . '/storage/app/public/upload', $imageFile);
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
        return response()->json([
                            'status' => 'error',
                            'result' => 'โปรดระบุข้อมูลให้ถูกต้อง',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);

        
    }

    public static function toggle(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $announce = Announce::where('id', $request->id)->update(['status' => $request->status]);

        if($announce) {
            return response()->json(['status' => 'success', 'result' => 'ดำเนินการสำเร็จ'], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['status' => 'error', 'result' => 'ไม่สามารถดำเนินการได้'], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
    }

    public static function remove(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $announce = Announce::where('id', $request->id)->delete();

        if($announce) {
            return response()->json(['status' => 'success', 'result' => 'ดำเนินการสำเร็จ'], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['status' => 'error', 'result' => 'ไม่สามารถดำเนินการได้'], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
    }

    public static function update(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        if($request->file && $request->file != "undefined") {
            $imageFile = time().'.'.$request->file->getClientOriginalExtension();
            $announce = Announce::where('id', $request->id)->update(
                [
                    'message' => $request->text, 
                    'image_url' => $imageFile
                ]
            );
            if($announce) {
                $request->file->move(base_path() . '/storage/app/public/upload', $imageFile);
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
        return response()->json([
                            'status' => 'error',
                            'result' => 'โปรดระบุข้อมูลให้ถูกต้อง',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        
    }
}
