<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkShiftCreateRequest;
use App\Http\Requests\WorkShiftUserAddRequest;
use App\Models\Order;
use App\Models\ShiftWorker;
use App\Models\WorkShift;
use Illuminate\Http\Request;

class WorkShiftController extends Controller
{
    // Создание смены
    public function create(WorkShiftCreateRequest $request) {
        $workShift = new WorkShift($request->all());
        $workShift->save();
        return response()->json($workShift)->setStatusCode(201, 'Успех');
    }

    // Открытие смены
    public function open($id) {
        $workShift = WorkShift::find($id);
        if (!$workShift) {
            return response()->json('Смена не найдена')->setStatusCode(404, 'Не найдено');
        }

        $error = [
            'error' => [
                'code' => 403,
                'message' => 'Forbidden. There are open shifts!'
            ]
        ];

        if (WorkShift::where('active', 1)->first()) {
            return response()->json($error)->setStatusCode(403, 'Попытка открыть вторую смену');
        }
        else {
            $workShift->active = 1;
            $workShift->save();
            return response()->json($workShift)->setStatusCode(200, 'Успех');
        }
    }

    // Закрытие смены
    public function close($id) {
        $workShift = WorkShift::find($id);
        if (!$workShift) {
            return response()->json('Смена не найдена')->setStatusCode(404, 'Не найдено');
        }

        if ($workShift->active == 0) {
            $error = [
                'error' => [
                    'code' => 403,
                    'message' => 'Forbidden. There shift is already closed!'
                ]
            ];

            return response()->json($error)->setStatusCode(403, 'Попытка закрыть закрытую смену');
        }
        else {
            $workShift->active = 0;
            $workShift->save();
            return response()->json($workShift)->setStatusCode(200, 'Успех');
        }
    }

    // Добавление сотрудников на смену
    public function userAdd(WorkShiftUserAddRequest $request, $id) {
        $workShift = WorkShift::find($id);
        $user_id = $request->user_id;

        $error = [
            'error' => [
                'code' => 403,
                'message' => 'Forbidden. The worker is already on shift!'
            ]
        ];

        if (ShiftWorker::where('work_shift_id', $workShift)->where('user_id', $user_id)) {
            return response()->json($error)->setStatusCode(403, 'Попытка два раза добавить работника');
        }
        else {
            ShiftWorker::create([
                'work_shift_id' => $workShift->id,
                'user_id' => $user_id
            ]);

            $data = [
                'data' => [
                    'id_user' => $user_id,
                    'status' => 'added'
                ]
            ];

            return response()->json($data)->setStatusCode(200, 'Успех');
        }
    }

    // Просмотр заказов за конкретную смену
    public function orderShow($id) {
        $workShift = WorkShift::find($id);
        $orders = Order::all();

        $amount_for_all = $orders->sum(function ($order) {
            return $order->orderMenus->sum(function ($orderMenu) {
                return $orderMenu->menu->price * $orderMenu->count;
            });
        });

        $data = [
            'data' => [
                'id' => $workShift->id,
                'start' => $workShift->start,
                'end' => $workShift->end,
                'active' => $workShift->active,
                'orders' => $orders->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'table' => $order->table->name,
                        'shift_workers' => $order->shiftWorker,
                        'create_at' => $order->created_at,
                        'status' => $order->status_order_id,
                        'price' => $order->orderMenus->sum(function ($orderMenu) {
                            return $orderMenu->menu->price * $orderMenu->count;
                        }),
                    ];
                }),
                'amount_for_all' => $amount_for_all,
            ]
        ];

        return response()->json($data)->setStatusCode(200, 'Успех');
    }
}
