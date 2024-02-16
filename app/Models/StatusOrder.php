<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function orders() {
        $this->hasMany(Order::class);
    }
}
