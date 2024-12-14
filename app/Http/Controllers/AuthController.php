<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // แสดงฟอร์มล็อกอิน
    public function showLoginForm()
    {
        return view('auth.login');
    }


    // ประมวลผลข้อมูลล็อกอิน
   public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // ล็อกอินสำเร็จ เปลี่ยนเส้นทางไปที่หน้า /home
                return redirect()->route('home');
            }

            // ล็อกอินไม่สำเร็จ กลับไปยังหน้าล็อกอินพร้อมแสดงข้อความแจ้งเตือน
            return redirect()->route('login')->withErrors([
                'email' => 'Email or password is incorrect.',
            ]);

        } catch (\Exception $e) {
            // บันทึก error ใน log
            Log::error("Login error: " . $e->getMessage());
            return back()->withErrors([
                'error' => 'Something went wrong. Please try again later.',
            ]);
        }
    }

    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
}


    // แสดงฟอร์มสมัครสมาชิก
    public function showRegisterForm()
    {
        return view('auth.register');  // เรียก View 'auth.register'
    }

    // ประมวลผลข้อมูลสมัครสมาชิก
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username', // ต้องมีการตรวจสอบ username
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'), // ต้องมีการรับค่า username
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    public function getImage($id)
    {
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $user = User::find($id);

        if (!$user || !$user->images) {
            abort(404); // หากไม่พบข้อมูลหรือไม่มีรูปภาพ
        }

        // ส่งคืนข้อมูลรูปภาพเป็น response
        return response($user->images)->header('Content-Type', 'image/jpeg');
    }


}
