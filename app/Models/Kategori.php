<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];
    protected $table = 'kategori';

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
