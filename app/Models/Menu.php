<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'menu_category_id'];

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function orderMenus() {
        $this->hasMany(OrderMenu::class);
    }
}
