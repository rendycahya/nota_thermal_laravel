<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = ['nama_barang','harga_barang','id_category_barang','stok_barang','deskripsi_barang','foto_barang','created_at', 'updated_at'];
}
