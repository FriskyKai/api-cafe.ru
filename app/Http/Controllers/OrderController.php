<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(OrderCreateRequest $request) {
        $order = new Order($request->all());
        $order->status_order_id = 1;
        $order->save();
        return response()->json($order)->setStatusCode(201, 'Успех');
    }

    
}
