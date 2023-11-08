<?php

use App\Constants\HttpStatusConstants;
use App\Models\Order;
use App\Service\Responser;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $order = Order::where('id',2)->first();

    $status = $order->latest_status->where('delivery_id',2)->pluck('order_status')->toarray()/*->order_status*/;

    if(in_array('pendingk',$status))
        die('d');
    die(json_encode(($status)));

    if($status == 'canceled')
    die('ss');
    return response()->json(
        Responser::success(new \App\Http\Resources\OrderStatusResource($status),HttpStatusConstants::SUCCESS)

    );
    $payload = [
        'role' => 'delivery',
        'id' => 1
    ];

    $jwt = JWT::encode($payload, env('JWT_KEY'), env('JWT_ALGORITHM'));
    $decoded = JWT::decode($jwt, new Key(env('JWT_KEY'), env('JWT_ALGORITHM')));
    die(json_encode($jwt));

});


