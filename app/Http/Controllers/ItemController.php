<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Stock;

use View;
use Storage;
use File;
use DB;
use Log;

class ItemController extends Controller
{

    public function getItem()
    {
        return View::make('item.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
        $items = Item::orderBy('item_id','DESC')->get();
        return response()->json($items);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        // $items = Item::create($request->all());
        // return response()->json($items);


        //         $path = 'public/';
        //         $file = $request->file('img_path');
        //         $fileName = time().'_'.$file->getClientOriginalName($file);
        //         $upload = $file->storeAs($path, $fileName);
        //         return response()->json(["success" => "Image successfully.","status" => 200]);
                
           
        // if($file = $request->hasFile('image')) {
        //     $file = $request->file('image') ;

        //     $fileName = uniqid().'_'.$file->extension();

        //     $destinationPath = public_path().'/images';
           
        //     $input['img_path'] = $fileName;
            
        //     $file->move($destinationPath,$fileName);
        // }
       
        // Item::create($request->all());
        // return response()->json(["success" => "Image successfully.","status" => 200]);

        $item = new Item;
        $item->description = $request->description;
        $item->cost_price= $request->cost_price;
        $item->sell_price = $request->sell_price;
        $item->title = $request->title;

        $files = $request->file('uploads');
        $item->imagePath = 'images/'.$files->getClientOriginalName();
        // $item->imagePath = uniqid().'_'.$files->getClientOriginalName();
        $item->save();
        Storage::put('/public/images/'.$files->getClientOriginalName(),file_get_contents($files));
        
        return response()->json(["success" => "Item created successfully.","item" => $item ,"status" => 200]);

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = Item::find($id);
        return response()->json($items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $items = Item::find($id);
        
        // $path = Storage::putFileAs('images/pet', $request->file('uploads'),$request->file('uploads')->getClientOriginalName());
        // $request->merge(["imagePath"=>$request->file('uploads')->getClientOriginalName()]);
        // $input = $request->all();
        
        // if($file = $request->hasFile('uploads')) {
        //     $file = $request->file('uploads') ;
        //     $fileName = $file->getClientOriginalName();
        //     $destinationPath = public_path().'/images' ;
        //     $input['imagePath'] = 'images/'.$fileName;            
        //     $items->update($input);
        //     $file->move($destinationPath,$fileName);
        // }
        
        
        // $input = $request->all();
        // $files = $request->file('imagePath');
        // $input['imagePath'] = 'images/'.$files->getClientOriginalName();
        // // $item->save();
        
        // $items = $items->update($input);
        // Storage::put('/public/images/'.$files->getClientOriginalName(),file_get_contents($files));
        
        // $path = Storage::putFileAs('/public/images/', $request->file('imagePath'),$request->file('imagePath')->getClientOriginalName());
        
        // $request->merge(["imagePath"=>$request->file('imagePath')->getClientOriginalName()]);

        // $input = $request->all();

        // if($file = $request->hasFile('imagePath')) {
        //     $file = $request->file('imagePath') ;
        //     $fileName = $file->getClientOriginalName();
        //     $destinationPath = public_path().'/images' ;
        //     $input['imagePath'] = 'images/'.$fileName;  
        //     // dd($items);
        //     $items->update($input);
        //     $file->move($destinationPath,$fileName);
        // } 

        // $items = Item::find($id);

        $items = Item::find($id);
        
        $files = $request->file('uploads');
        if($files = $request->hasFile('uploads')){
            $items->imagePath = 'images/'.$files->getClientOriginalName();
        // $item->imagePath = uniqid().'_'.$files->getClientOriginalName();
        // $items->update();
        Storage::put('/public/images/'.$files->getClientOriginalName(),file_get_contents($files));
        }
        

        $items = $items->update($request->all());
        $items = Item::find($id);
        
        // $items = Item::find($id);

        // $path = Storage::putFileAs('/public/images/', $request->file('uploads'),$request->file('uploads')->getClientOriginalName());
        
        // $request->merge(["imagePath"=>$request->file('uploads')->getClientOriginalName()]);

        // $input = $request->all();

        // if($file = $request->hasFile('uploads')) {
        //     $file = $request->file('uploads') ;
        //     $fileName = $file->getClientOriginalName();
        //     $destinationPath = public_path().'/images' ;
        //     // dd($fileName);
        //     $input['imagePath'] = 'images/'.$fileName;            
        //     $items->update($input);
        //     // dd($grooming);
        //     $file->move($destinationPath,$fileName);
        // } 

        return response()->json($items);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Item::findOrFail($id);
        $items->delete();
        return response()->json(["success" => "Item Deleted Successfully!","status" => 200]);
    }

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