<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // ตรวจสอบว่า admin ได้ล็อกอินหรือไม่
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        return view('admins.home-admin');
    }

    public function showLoginForm()
    {
        return view('admins.auth.login-admin'); // ปรับชื่อมุมมองให้ถูกต้อง
    }

    public function login(Request $request)
    {
        // ตรวจสอบข้อมูลการเข้าสู่ระบบ
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            // เข้าสู่ระบบสำเร็จ
            return redirect()->action([AdminController::class, 'index']);
        } else {
            // เข้าสู่ระบบล้มเหลว
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records or you are not an admin.',
            ]);
        }
    }
}
