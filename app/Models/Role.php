<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    // Поля исключающиеся из выборки данных
    protected $hidden = [];
    // Поля с которе необходимо обработать
    protected $casts = [];
    // Связь
    public function users() {
        $this->hasMany(User::class);
    }
}
