<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'admin_id',
        'total_penjualan',
        'tanggal_laporan'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
