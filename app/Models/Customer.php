<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name', 'date_of_birth','profile_photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
