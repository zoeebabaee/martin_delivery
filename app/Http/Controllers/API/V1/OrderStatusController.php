<?php

namespace App\Http\Controllers\API\V1;

use App\Constants\HttpStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Service\Responser;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $company_id = JWT::decode(Str::substr($request->header('Authorization'), 7)
            , new Key(env('JWT_KEY'), env('JWT_ALGORITHM')))->id;

        $order = Order::where('tracking_order',$request['tracking_id'])->where('company_id',$company_id)->first();
        if($order)
        {
            $status = Order::with('latest_status')->find($order->id);
            return response()->json(
                Responser::success(new \App\Http\Resources\OrderStatusResource($status),HttpStatusConstants::SUCCESS)

            );


        }
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
}
