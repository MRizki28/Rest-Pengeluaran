<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranModel extends Model
{
    use HasFactory;

    protected $table ='tb_pengeluaran';
    protected $fillable = [
        'id' ,'user_id','deskripsi','jumlah','created_at','updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
