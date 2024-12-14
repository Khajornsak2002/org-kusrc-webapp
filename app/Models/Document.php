<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_name',
        'file_path',
        'org_return',
        'org_return_id',
        'status',
        'remark',
        'created_by',
        'check_status',
    ];

    // If you want to define the primary key and its type
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor for created_at
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->locale('th')->translatedFormat('d F ') . (Carbon::parse($value)->year + 543);
    }

    // Accessor for updated_at
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->locale('th')->translatedFormat('d F ') . (Carbon::parse($value)->year + 543);
    }
}

