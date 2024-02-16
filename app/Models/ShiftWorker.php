<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftWorker extends Model
{
    use HasFactory;

    protected $fillable = ['work_shift_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workShift()
    {
        return $this->belongsTo(WorkShift::class);
    }
}
