<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // เปลี่ยนชื่อของตารางในฐานข้อมูล
    protected $table = 'admins';

    // กำหนดฟิลด์ที่สามารถกรอกได้
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    // ถ้าต้องการให้ Laravel เข้ารหัสรหัสผ่านโดยอัตโนมัติ
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            $admin->password = bcrypt($admin->password);
        });
    }
}
