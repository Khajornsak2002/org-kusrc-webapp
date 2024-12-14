<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // สร้างตาราง users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique(); // คอลัมน์ username ที่ไม่ซ้ำ
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });


        // สร้างตาราง password_reset_tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // ใช้อีเมลเป็น Primary Key
            $table->string('token'); // โทเค็นสำหรับการรีเซ็ตรหัสผ่าน
            $table->timestamp('created_at')->nullable(); // เวลาในการสร้างโทเค็น
        });

        // สร้างตาราง sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID ของ session
            $table->foreignId('user_id')->nullable()->index(); // อ้างอิงถึงผู้ใช้ที่เข้าสู่ระบบ
            $table->string('ip_address', 45)->nullable(); // ที่อยู่ IP ของผู้ใช้
            $table->text('user_agent')->nullable(); // User agent ของผู้ใช้
            $table->longText('payload'); // ข้อมูลเกี่ยวกับ session
            $table->integer('last_activity')->index(); // เวลาสุดท้ายที่มีการทำงานใน session
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions'); // ลบตาราง sessions ก่อน
        Schema::dropIfExists('password_reset_tokens'); // ลบตาราง password_reset_tokens
        Schema::dropIfExists('users'); // ลบตาราง users
    }
};
