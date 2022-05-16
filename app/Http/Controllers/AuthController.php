<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\BankAccount;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = User::where('username', $username)->first();

        $variableName = session('variableName');
        
        if($user && $user->password == $password) {
            Auth::login($user, $request->remember_me);
            return response()->json([
                        'status' => 'success',
                        'result' => 'เข้าสู่ระบบสำเร็จ',
                        'redirect' => isset($variableName) ? $variableName : null,
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                        'status' => 'error',
                        'result' => 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

    }

    public function logout()
    {
        Auth::logout();
        return view('login');
    }

    public function loginPage() {
        if(Auth::check()) return redirect()->route('dashboard');
        return view('login');
    }

    public function registerPage() {
        if(Auth::check()) return redirect()->route('dashboard');
        return view('register');
    }

    public function register(Request $request) {
        if(Auth::check()) return redirect()->route('dashboard');
        
        
        $username = $request->username;
        $password = $request->password;
        $confirmpassword = $request->confirmpassword;

        $accountName = $request->accountName;
        $bankname = $request->bankname;
        $bankno = $request->bankno;

        $role = $request->role;
        $name = $request->name;

        if(strlen($username) <= 3 || !$username || strlen($password) <= 3 || !$password || $password != $confirmpassword || !$accountName || !$bankname || !$bankno || !$role || !$name) {
            return response()->json([
                        'status' => 'success',
                        'result' => 'โปรดระบุข้อมูลให้ถูกต้อง',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }

        $user = User::create([
            'username' => $username,
            'password' => $password,
            'role' => $role,
            'name' => $name,
        ]);

        $bankAccount = BankAccount::create([
                    'user_id' => $user->id,
                    'bank_name' => $bankname,
                    'bank_no' => $bankno,
                    'account_name' => $accountName,
                ]);

        if($user && $bankAccount) {
            return response()->json([
                        'status' => 'success',
                        'result' => 'สมัครสมาชิกสำเร็จ',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                        'status' => 'error',
                        'result' => 'ไม่สามารถดำเนินการได้โปรดลองใหม้อีกครั้ง',
                    ], 200, array('Content-Type' => 'application\json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }


    }
}
