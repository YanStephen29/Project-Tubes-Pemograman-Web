<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tambahkan variabel fillable jika Anda ingin memungkinkan penugasan massal
    protected $fillable = ['name'];

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

}
