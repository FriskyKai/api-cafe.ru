<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['number_of_person', 'table_id', 'shift_worker_id', 'status_order_id'];

    public function shiftWorker()
    {
        return $this->belongsTo(ShiftWorker::class);
    }

    public function statusOrder()
    {
        return $this->belongsTo(StatusOrder::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orderMenus() {
        return $this->hasMany(OrderMenu::class);
    }
}
