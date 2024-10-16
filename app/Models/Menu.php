<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['id_kategori','nama_menu', 'gambar' ,'harga', 'status', 'jenis'];
    protected $table = 'menu';


    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu');
    }
}
