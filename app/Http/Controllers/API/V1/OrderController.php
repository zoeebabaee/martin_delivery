<?php

namespace App\Http\Controllers\API\V1;

use App\Constants\HttpStatusConstants;
use App\Events\ChangeStatusEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Service\Responser;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::wherehas('pending_order')->get();
        return response()->json(
            Responser::success(OrderResource::collection($orders),HttpStatusConstants::SUCCESS)

        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $decoded_jwt = JWT::decode(Str::substr($request->header('Authorization'), 7)
        , new Key(env('JWT_KEY'), env('JWT_ALGORITHM')));

        $company_id = $decoded_jwt->id;
        $tracking_code = mt_rand();
        $data_attributes = $request->safe()->merge(['company_id'=>$company_id,'tracking_code'=>$tracking_code]);
        $order = Order::create($data_attributes->all());

        $order_status_record = new OrderStatus();
        $order_status_record->order_status = 'pending';
        $order->order_statuses()->save($order_status_record);
        event(new ChangeStatusEvent($order_status_record));  //fires the NewUserEvent event

        return response()->json(
            Responser::success(new OrderResource($order),HttpStatusConstants::SUCCESS)

        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function accept_order(Request $request)
    {
        $order_id = $request['order_id'];
        $delivery_id = JWT::decode(Str::substr($request->header('Authorization'), 7)
            , new Key(env('JWT_KEY'), env('JWT_ALGORITHM')))->id;

        $order = Order::where('id',$order_id)->first();
        if($order) {
            $order_status = $order->latest_status->order_status;
            if($order_status == 'pending') {
                //not pick_up or accepted for another order
                $delivery_status = $order->latest_status->where('delivery_id',$delivery_id)->pluck('order_status')->toarray();
                if(in_array('pick_up',$delivery_status) || in_array('accepted',$delivery_status)) {
                }
                else{
                    $order_status_record = new OrderStatus();
                    $order_status_record->order_status = 'accepted';
                    $order_status_record->delivery_id = $delivery_id;
                    $order->order_statuses()->save($order_status_record);

                    return response()->json(
                        Responser::success(HttpStatusConstants::SUCCESS));                }

            }
        }

    }

    public function complete_order(Request $request)
    {
        $order_id = $request['order_id'];
        $delivery_id = JWT::decode(Str::substr($request->header('Authorization'), 7)
            , new Key(env('JWT_KEY'), env('JWT_ALGORITHM')))->id;

        $order = Order::where('id',$order_id)->first();
        if($order) {
            $status = $order->latest_status->order_status;
            if($status == 'pick_up') {
                $order_status_record = new OrderStatus();
                $order_status_record->order_status = 'completed';
                $order_status_record->delivery_id = $delivery_id;
                $order->order_statuses()->save($order_status_record);

                return response()->json(
                    Responser::success(HttpStatusConstants::SUCCESS)

                );
            }
        }
    }

    public function cancel_order(Request $request)
    {
        $order_id = $request['order_id'];
        $company_id = JWT::decode(Str::substr($request->header('Authorization'), 7)
            , new Key(env('JWT_KEY'), env('JWT_ALGORITHM')))->id;

        $order = Order::where('id',$order_id)->where('company_id',$company_id)->first();
        if($order)
        {
            $status = $order->latest_status->order_status;
            if($status == 'pending')
            {
                $order_status_record = new OrderStatus();
                $order_status_record->order_status = 'pending';
                $order->order_statuses()->save($order_status_record);

                return response()->json(
                    Responser::success(HttpStatusConstants::SUCCESS)

                );
            }
        }
    }

}
