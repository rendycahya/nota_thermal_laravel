<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = ['total_semua','uang_bayar','uang_kembali','nama_pembeli','pembuat','metode_pembayaran','jenis_transaksi','bukti_tf'];
}
