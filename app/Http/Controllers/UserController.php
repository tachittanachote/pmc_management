<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\BankAccount;
use Illuminate\Support\Facades\Auth;
use App\Work;
use App\Product;
use Carbon\Carbon;
use App\Deduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    public function index()
    {

        if(!Auth::check()) {
            return view('login');
        }

        if(Auth::user()->role == "seamstress") {
            

            $oneHalf = true;
            if(Carbon::now() > Carbon::now()->startOfMonth()->addDays(16)) {
                $oneHalf = false;
            }

            if($oneHalf) {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->startOfMonth()->addDays(15);
            }
            else {
                $startDate = Carbon::now()->startOfMonth()->addDays(16);
                $endDate = Carbon::now()->endOfMonth();
            }

            $salary = 0;

            $countWork = Work::getSalaryByUserId(Auth::user()->id, $startDate, $endDate);
            if(count($countWork) > 0) {
                foreach ($countWork as $work) {
                    $price = Product::getSeamstressPriceByProductId($work->product_id);
                    $salary = $salary + ($price * $work->quantity);
                }
            }

            $works = Work::where('user_id', Auth::user()->id)->whereBetween('created_at', [$startDate->format('Y-m-d') . " 00:00:00", $endDate->format('Y-m-d') . " 23:59:59"])->orderBy('id', 'DESC')->paginate(35)->appends(request()->query());
            $countworks = Work::where('user_id', Auth::user()->id)->whereBetween('created_at', [$startDate->format('Y-m-d') . " 00:00:00", $endDate->format('Y-m-d') . " 23:59:59"])->get();

            return view('dashboard', compact('works', 'salary', 'countworks'));
        }
        if(Auth::user()->role == "tailor") {
            

            $oneHalf = true;
            if(Carbon::now() > Carbon::now()->startOfMonth()->addDays(16)) {
                $oneHalf = false;
            }

            if($oneHalf) {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->startOfMonth()->addDays(15);
            }
            else {
                $startDate = Carbon::now()->startOfMonth()->addDays(16);
                $endDate = Carbon::now()->endOfMonth();
            }

            $salary = 0;

            $countWork = Work::getSalaryByTailorId(Auth::user()->id, $startDate, $endDate);

            if(count($countWork) > 0) {
                foreach ($countWork as $work) {
                    $price = Product::getTailorPriceByProductId($work->product_id);
                    $salary = $salary + ($price * $work->quantity);
                }
            }

            $works = Work::where('tailor_id', Auth::user()->id)->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->orderBy('id', 'DESC')->paginate(35)->appends(request()->query());
            $countworks = Work::where('tailor_id', Auth::user()->id)->whereBetween('created_at', [$startDate->format('Y-m-d') . " 00:00:00", $endDate->format('Y-m-d') . " 23:59:59"])->get();

			return view('dashboard', compact('works', 'salary', 'countworks'));
        }
        if(Auth::user()->role == "admin") {



            $oneHalf = true;
            if (Carbon::now() > Carbon::now()->startOfMonth()->addDays(16)) {
                $oneHalf = false;
            }

            if ($oneHalf) {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->startOfMonth()->addDays(15);
            } else {
                $startDate = Carbon::now()->startOfMonth()->addDays(16);
                $endDate = Carbon::now()->endOfMonth();
            }
			
			$tailor_works = Work::whereNotNull('tailor_id')->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->get();
			$seamstress_works = Work::whereBetween('created_at', [$startDate->format('Y-m-d') . " 00:00:00", $endDate->format('Y-m-d') . " 23:59:59"])->get();

            $total_tailor_price = 0;
            $total_seamstress_price = 0;

            foreach($tailor_works as $w) {
                $price = Product::getTailorPriceByProductId($w->product_id);
                $total_tailor_price = $total_tailor_price + ($price * $w->quantity);
            }

            foreach($seamstress_works as $w) {
                $price = Product::getSeamstressPriceByProductId($w->product_id);
                $total_seamstress_price = $total_seamstress_price + ($price * $w->quantity);
            }

            $tworkCount = Work::whereNotNull('tailor_id')->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->sum('quantity');
            $sworkCount = Work::whereBetween('created_at', [$startDate->format('Y-m-d') . " 00:00:00", $endDate->format('Y-m-d') . " 23:59:59"])->sum('quantity');
            return view('dashboard', compact('total_tailor_price', 'total_seamstress_price', 'tworkCount', 'sworkCount'));
        }
    }

    public function profile() {
        $bankAccount = BankAccount::where('user_id', '=', Auth::user()->id)->first();
        return view('profile', compact('bankAccount'));
    }

    public function profileSave(Request $request) {

        $option = $request->option;
        $user = User::where('id', Auth::user()->id)->first();

        if($option == "password") {

            
            if(strlen($user->password) < 4) {
                return response()->json([
                        'status' => 'error',
                        'result' => 'โปรดระบุรหัสผ่านอย่างน้อย 4 ตัวอักษร',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }

            
            
            if($user->password != $request->old_password) {
                return response()->json([
                        'status' => 'error',
                        'result' => 'รหัสผ่านเดิมไม่ตรงกัน',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }

            $user->password = $request->password;
            $user->save();

            return response()->json([
                        'status' => 'success',
                        'result' => 'ดำเนินการสำเร็จ',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        if($option == "bank") {
            $bankAccount = BankAccount::where('user_id', Auth::user()->id)->first();
            if($bankAccount) {

                $bankAccount->bank_name = $request->bankname;
                $bankAccount->bank_no = $request->bankno;
                $bankAccount->account_name = $request->accountName;
                
                if($bankAccount->save()){
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


            } else {
                $createAccount = BankAccount::create([
                    'user_id' => Auth::user()->id,
                    'bank_name' => $request->bankname,
                    'bank_no' => $request->bankno,
                    'account_name' => $request->accountName,
                ]);

                if($createAccount){
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
        }

        if($option == "bank_admin_update") {
            if(Auth::user()->role != 'admin'){
                return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }
            $bankAccount = BankAccount::where('user_id', Auth::user()->id)->first();
            if($bankAccount) {

                $bankAccount->bank_name = $request->bankname;
                $bankAccount->bank_no = $request->bankno;
                $bankAccount->account_name = $request->accountName;
                
                if($bankAccount->save()){
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
        }

        if($option == "name") {
            $user->name = $request->name;
            
            if($user->save()){
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
                        'result' => 'ไม่สามารถทำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function userList() {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $users = User::paginate(35)->appends(request()->query());
        return view('users.index', compact('users'));
    }

    public function adminList() {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $users = User::where('role', '=', 'admin')->paginate(35)->appends(request()->query());
        return view('users.index', compact('users'));
    }

    public function tailorList() {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $users = User::where('role', '=','tailor')->paginate(35)->appends(request()->query());
        return view('users.index', compact('users'));
    }

    public function seamstressList() {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $users = User::where('role', '=','seamstress')->paginate(35)->appends(request()->query());
        return view('users.index', compact('users'));
    }

    public function userAddPage() {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        return view('users.add');
    }

    public function work() {
        if(Auth::user()->role != "seamstress") return redirect()->route('dashboard');
        return view('work');
    }

    public function userAdd(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $user = User::create([
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->position,
            'name' => $request->name,
        ]);



        if($user){
            if ($request->position == "admin") {
                $users = DB::connection('intrend_track')->insert('insert into users (id, name, username, password) values (?, ?, ?, ?)', [$user->id, $request->name, $request->username, $request->password]);
            }
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

    public function workUpload(Request $request) {

        if($request->file && $request->file != "undefined") {
            $imageFile = time().'.'.$request->file->getClientOriginalExtension();
            $createWork = Work::create([
                'user_id' => Auth::user()->id, 
                'name' => $request->product_name, 
                'product_code' => $request->product_code, 
                'product_id' => $request->product,
                'tailor_id' => $request->tailor != "null"  ? $request->tailor : null,
                'quantity' => $request->quantity,
                'image_url' => $imageFile,
                'detail' => isset($request->detail) ? $request->detail : "",
            ]);
            if($createWork) {
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
        else {
            $createWork = Work::create([
                'user_id' => Auth::user()->id, 
                'name' => $request->product_name, 
                'product_code' => $request->product_code, 
                'product_id' => $request->product,
                'tailor_id' => $request->tailor != "null"  ? $request->tailor : null,
                'quantity' => $request->quantity,
                'detail' => isset($request->detail) ? $request->detail : "",
            ]);
            if($createWork) {
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

        return $request->file;
    }

    public function adminWorkUpload(Request $request) {

        $steamstress_id = "null";
        $tailor_id = "null";

        $id = User::where("id", $request->employee)->first();

        if($id->role == "seamstress") {
            $steamstress_id = $request->employee;
        }

        if($id->role == "tailor") {
            $tailor_id = $request->employee;
        }

        if($request->file && $request->file != "undefined") {
            $imageFile = time().'.'.$request->file->getClientOriginalExtension();
            $createWork = Work::create([
                'user_id' => $steamstress_id == "null" ? null : $steamstress_id, 
                'name' => $request->product_name, 
                'product_code' => $request->product_code, 
                'product_id' => $request->product,
                'tailor_id' => $tailor_id == "null" ? null : $tailor_id,
                'quantity' => $request->quantity,
                'image_url' => $imageFile,
                'detail' => isset($request->detail) ? $request->detail : "",
            ]);
            if($createWork) {
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
        else {
            $createWork = Work::create([
                'user_id' => $steamstress_id == "null" ? null : $steamstress_id, 
                'name' => $request->product_name, 
                'product_code' => $request->product_code, 
                'product_id' => $request->product,
                'tailor_id' => $tailor_id == "null" ? null : $tailor_id,
                'quantity' => $request->quantity,
                'detail' => isset($request->detail) ? $request->detail : "",
            ]);
            if($createWork) {
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

        return $request->file;
    }

    public function workRemove(Request $request) {
        $work = Work::where('user_id', Auth::user()->id)->where("id", $request->product_id)->delete();
        if($work) {
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

    public function userRemove(Request $request) {
        if(Auth::user()->role != 'admin'){
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        
        $user = User::where("id", $request->user_id)->delete();

        Work::where('user_id', $request->user_id)->delete();
        Deduct::where('user_id', $request->user_id)->delete();
        BankAccount::where('user_id', $request->user_id)->delete();

        if($user) {
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

    public function report(Request $request) {
        if(Auth::user()->role != "admin") return redirect()->route('dashboard');

        
        if($request->startAt && $request->endAt) {
            
            $startDate = Carbon::parse($request->startAt);
            $endDate = Carbon::parse($request->endAt);
            
            $users = User::where('role', "!=", "admin")->get();

            $userListWithReport = [];

            foreach($users as $u) {
                if($u->role == "tailor") {

                    $salary = 0;
                    $workQuantity = 0;
                    $countWork = Work::getSalaryByTailorId($u->id, $startDate, $endDate);

                    if(count($countWork) > 0) {
                        foreach ($countWork as $work) {
                            $price = Product::getTailorPriceByProductId($work->product_id);
                            $salary = $salary + $price * $work->quantity;
                            $workQuantity = $workQuantity + $work->quantity;
                        }
                    }

                    array_push($userListWithReport, (object)[ 
                        "user_id" => $u->id,
                        "user_name" => $u->name,
                        "user_role" => $u->role,
                        "salary" => $salary,
                        "work_quantity" => $workQuantity
                    ]);

                }
                if($u->role == "seamstress") {

                    $salary = 0;
                    $workQuantity = 0;
                    $countWork = Work::getSalaryByUserId($u->id, $startDate, $endDate);

                    if(count($countWork) > 0) {
                        foreach ($countWork as $work) {
                            $price = Product::getSeamstressPriceByProductId($work->product_id);
                            $salary = $salary + $price * $work->quantity;
                            $workQuantity = $workQuantity + $work->quantity;
                        }
                    }

                    array_push($userListWithReport, (object)[ 
                        "user_id" => $u->id,
                        "user_name" => $u->name,
                        "user_role" => $u->role,
                        "salary" => $salary,
                        "work_quantity" => $workQuantity
                    ]);

                }

                
            }
        }
        else {
            $oneHalf = true;
            if(Carbon::now() > Carbon::now()->startOfMonth()->addDays(16)) {
                $oneHalf = false;
            }

            if($oneHalf) {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->startOfMonth()->addDays(15);
            }
            else {
                $startDate = Carbon::now()->startOfMonth()->addDays(16);
                $endDate = Carbon::now()->endOfMonth();
            }

            $users = User::where('role', "!=", "admin")->get();

            $userListWithReport = [];

            foreach($users as $u) {
                if($u->role == "tailor") {

                    $salary = 0;
                    $workQuantity = 0;
                    $countWork = Work::getSalaryByTailorId($u->id, $startDate, $endDate);

                    if(count($countWork) > 0) {
                        foreach ($countWork as $work) {
                            $price = Product::getTailorPriceByProductId($work->product_id);
                            $salary = $salary + $price * $work->quantity;
                            $workQuantity = $workQuantity + $work->quantity;
                        }
                    }

                    array_push($userListWithReport, (object)[ 
                        "user_id" => $u->id,
                        "user_name" => $u->name,
                        "user_role" => $u->role,
                        "salary" => $salary,
                        "work_quantity" => $workQuantity
                    ]);

                }
                if($u->role == "seamstress") {

                    $salary = 0;
                    $workQuantity = 0;
                    $countWork = Work::getSalaryByUserId($u->id, $startDate, $endDate);

                    if(count($countWork) > 0) {
                        foreach ($countWork as $work) {
                            $price = Product::getSeamstressPriceByProductId($work->product_id);
                            $salary = $salary + $price * $work->quantity;
                            $workQuantity = $workQuantity + $work->quantity;
                        }
                    }

                    array_push($userListWithReport, (object)[ 
                        "user_id" => $u->id,
                        "user_name" => $u->name,
                        "user_role" => $u->role,
                        "salary" => $salary,
                        "work_quantity" => $workQuantity
                    ]);

                }

                
            }
        }

        return view('report', compact('startDate', 'endDate', 'userListWithReport'));
    }

    public static function userUpdate(Request $request) {
        if(Auth::user()->role != "admin") return redirect()->route('dashboard');

        $is_user = User::where('username', $request->username)->first();

        if($is_user->id != intval($request->user_id)) {
            return response()->json([
                            'status' => 'warning',
                            'result' => 'ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        if(strlen($request->password) <= 4 ) {
            return response()->json([
                            'status' => 'warning',
                            'result' => 'รหัสผ่านต้องมากกว่า 4 ตัวอักษรขึ้นไป',
                        ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $user = User::where('id', $request->user_id)->update([
            'name' => $request->name, 
            'username' => $request->username, 
            'password' => $request->password, 
            'role' => $request->role, 
        ]);

                if($user) {
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


    public static function workUpdate(Request $request) {

        if($request->tailor) {
            if($request->file && $request->file != "undefined") {

                $imageFile = time().'.'.$request->file->getClientOriginalExtension();
                $updateWork = Work::where('id', $request->work_id)->update([
                    'name' => $request->name, 
                    'product_code' => $request->code, 
                    'product_id' => $request->product,
                    'tailor_id' => $request->tailor,
                    'image_url' => $imageFile,
                    'detail' => $request->detail,
                ]);

                if($updateWork) {
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
            else {
                $updateWork = Work::where('id', $request->work_id)->update([
                    'name' => $request->name, 
                    'product_code' => $request->code, 
                    'product_id' => $request->product,
                    'tailor_id' => $request->tailor,
                    'detail' => $request->detail,
                ]);
                if($updateWork) {
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
        }
        else {
                if($request->file && $request->file != "undefined") {

                $imageFile = time().'.'.$request->file->getClientOriginalExtension();
                $updateWork = Work::where('id', $request->work_id)->update([
                    'name' => $request->name, 
                    'product_code' => $request->code, 
                    'product_id' => $request->product,
                    'image_url' => $imageFile,
                    'detail' => $request->detail,
                ]);

                if($updateWork) {
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
            else {
                $updateWork = Work::where('id', $request->work_id)->update([
                    'name' => $request->name, 
                    'product_code' => $request->code, 
                    'product_id' => $request->product,
                    'detail' => $request->detail,
                ]);
                if($updateWork) {
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
        }
    }

    public function workview(Request $request) {
        $userId = $request->id;
        $user = User::where('id', $userId)->first();

        if(!$user) return redirect()->back();

        $oneHalf = true;
        if(Carbon::now() > Carbon::now()->startOfMonth()->addDays(16)) {
            $oneHalf = false;
        }

        if($oneHalf) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->startOfMonth()->addDays(15);
        }
        else {
            $startDate = Carbon::now()->startOfMonth()->addDays(16);
            $endDate = Carbon::now()->endOfMonth();
        }

        if($user->role == "seamstress") {
            if($request->startAt && $request->endAt) {
                $startDate = Carbon::parse($request->startAt);
                $endDate = Carbon::parse($request->endAt);
                $works = Work::where('user_id', $user->id)->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->orderBy('id', 'DESC')->paginate(35)->appends(request()->query());
            }
            else {
                $works = Work::where('user_id', $user->id)->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->orderBy('id', 'DESC')->paginate(35)->appends(request()->query());
            }
        }

        if($user->role == "tailor") {
            if($request->startAt && $request->endAt) {
                $startDate = Carbon::parse($request->startAt);
                $endDate = Carbon::parse($request->endAt);
                $works = Work::where('tailor_id', $user->id)->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->orderBy('id', 'DESC')->paginate(35)->appends(request()->query());
            }
            else {
                $works = Work::where('tailor_id', $user->id)->whereBetween('created_at', [$startDate->format('Y-m-d')." 00:00:00", $endDate->format('Y-m-d')." 23:59:59"])->orderBy('id', 'DESC')->paginate(35)->appends(request()->query());
            }
        }

        return view('worklist', compact('works', 'user', 'startDate', 'endDate'));
    }

    public function tailorCheck(Request $request) {
        $user = User::where('id', $request->tailor_id)->first();
        return $user;
    }

    public function summarySalary(Request $request) {
        $oneHalf = true;
        if (Carbon::now() > Carbon::now()->startOfMonth()->addDays(16)) {
            $oneHalf = false;
        }

        if ($oneHalf) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->startOfMonth()->addDays(15);
        } else {
            $startDate = Carbon::now()->startOfMonth()->addDays(16);
            $endDate = Carbon::now()->endOfMonth();
        }


        $workList = array();
        $totalIncome = 0;


        if(isset($request->startDate) && isset($request->endDate)) {
            $startDate = Carbon::parse($request->startDate);
            $endDate = Carbon::parse($request->endDate);
        }

        if (Auth::user()->role == "tailor") {


            $works = Work::where('tailor_id', Auth::user()->id)->whereBetween('created_at', [Carbon::parse($startDate)->format('Y-m-d') . " 00:00:00", Carbon::parse($endDate)->format('Y-m-d') . " 23:59:59"])->get();

            if (count($works) > 0) {
                foreach ($works as $work) {

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
        if (Auth::user()->role == "seamstress") {

            $works = Work::where('user_id', Auth::user()->id)->whereBetween('created_at', [Carbon::parse($startDate)->format('Y-m-d') . " 00:00:00", Carbon::parse($endDate)->format('Y-m-d') . " 23:59:59"])->get();

            if (count($works) > 0) {
                foreach ($works as $work) {

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

        $deducts = Deduct::where('user_id', Auth::user()->id);

        if (isset($request->startDate) && isset($request->endDate)) {
            $deducts->whereBetween('created_at', [Carbon::parse($startDate)->format('Y-m-d') . " 00:00:00", Carbon::parse($endDate)->format('Y-m-d') . " 23:59:59"]);
        }

        $deducts = $deducts->paginate(10);

        $totalDeduct = 0;
        foreach($deducts as $deduct) {
            $totalDeduct = $totalDeduct - $deduct->amount;
        }

        return view('salary', compact('startDate', 'endDate', 'workList', 'totalIncome', 'deducts', 'totalDeduct'));
    }

    public function workQuantityUpdate(Request $request) {

        $update = Work::where('id', $request->id)->update(['quantity' => $request->quantity]);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'result' => 'ดำเนินการสำเร็จ',
            ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'status' => 'error',
                'result' => 'โปรดระบุข้อมูลให้ถูกต้อง',
            ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

    }
	
	public function updateUserLineId(Request $request) {
        if(Auth::check()) {
            $update = User::where('id', Auth::user()->id)->update(['line_id' => $request->line_id]);

            if ($update) {
                return response()->json([
                    'status' => 'success',
                    'result' => 'ดำเนินการสำเร็จ',
                ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json([
                    'status' => 'error',
                    'result' => 'ไม่สามารถดำเนินการได้',
                ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'result' => 'ไม่สามารถดำเนินการได้',
            ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
    }

    public function addworkadmin(Request $request) {
        return view('workadmin');
    }    

    public function lineAuth(Request $request) {
        if(!Auth::check()) {
            session(['variableName' => "line-auth"]);
            return view('login');
        }
        

        return view('authline');
    }
}

