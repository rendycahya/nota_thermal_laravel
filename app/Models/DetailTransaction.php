<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;
    protected $table = 'detail_transactions';
    protected $fillable = ['id_transaction','nama_barang','banyak_barang','harga_barang', 'total_harga_barang','waktu'];
}
