<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'surname', 'patronymic', 'login', 'password', 'photo_file', 'api_token', 'status'];
    // Поля исключающиеся из выборки данных
    protected $hidden = ['password', 'api_token'];

    public function logOut() {
        $this->api_token = null;
        $this->save();
    }


    // Связь
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function shiftWorkers() {
        $this->hasMany(ShiftWorker::class);
    }

    // Получение роли пользователя
    public function hasRole($roles)
    {
        return in_array($this->role->code, $roles);
    }


}
