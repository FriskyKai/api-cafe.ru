<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Role;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
        return response()->json($roles)->setStatusCode(200, 'Успешно');
    }
    // Просмотр по id
    public function show($id) {
        $role = Role::find($id);
        if ($role) {
            return response()->json($role)->setStatusCode(200, 'Успешно');
        } else {
            return response()->json('Роль не найдена')->setStatusCode(404, 'Не найдено');
        }
    }
    // Создание
    public function create(RoleCreateRequest $request) {
        $role = new Role($request->all());
        $role->save();
        return response()->json($role)->setStatusCode(200, 'Добавлено');
    }
    // Обновление
    public function update(RoleUpdateRequest $request, $id) {
        $role = Role::find($id);
        if ($role) {
            $role->update($request->all());
            return response()->json($role)->setStatusCode(200, 'Изменено');
        } else {
            return response()->json('Роль не найдена')->setStatusCode(404, 'Не найдено');
        }
    }
    // Удаление
    public function destroy($id) {
        $role = Role::find($id);
        if ($role) {
            Role::destroy($id);
            return response()->json('Роль удалена')->setStatusCode(200, 'Удалено');
        } else {
            return response()->json('Роль не найдена')->setStatusCode(404, 'Не найдено');
        }
    }
}
