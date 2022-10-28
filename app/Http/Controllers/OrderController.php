<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Stock;

use db;
use log;


class OrderController extends Controller
{
    public function postCheckout(Request $request){
        // $items = json_decode($request->json()->all());
        $items = json_decode($request->getContent(),true);
        // Log::info(print_r($request->getContent()));
        Log::info(print_r($items, true));
        
        try {
            DB::beginTransaction();
            $order = new Order();
            $customer = Customer::find(1);
            // dd($cart->items);
            $customer->orders()->save($order);
            // dd($cart->items);
            // Log::info(print_r($order->orderinfo_id, true));
            foreach($items as $item) {
              // Log::info(print_r($item, true));
               $id = $item['item_id'];
               // Log::info(print_r($, true));
               $order->items()->attach($order->orderinfo_id,['quantity'=> $item['quantity'],'item_id'=>$id]);
               // Log::info(print_r($order, true));
               $stock = Stock::find($id);
               $stock->quantity = $stock->quantity - $item['quantity'];
               $stock->save();
            }
          }
          catch (\Exception $e) {
            DB::rollback();
              return response()->json(array('status' => 'Order failed','code'=>409,'error'=>$e->getMessage()));
            }
      
          DB::commit();
          return response()->json(array('status' => 'Order Success','code'=>200,'order id'=>$order->orderinfo_id));
          }//end postcheckout
}
