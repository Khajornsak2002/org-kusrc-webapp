<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // กำหนด fillable attributes ถ้าจำเป็น
    protected $fillable = [
        'id',
        'title',
        'file_name',
        'org_return',
        'status',
        'remark',
        'created_at',
        'updated_at',
        'created_by',
    ];
}
