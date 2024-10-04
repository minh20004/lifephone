<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    // Index lấy dữ liệu
    public function index()
    {
        // $orders = $this->order->id;
        // return view('admin.orders.index', compact('orders'));

        $listOrderItem=OrderItem::all();
        return view('admin.orders.index',compact('listOrderItem'));
    }

    public function loadAllOrderItem(){
        return $this->belongsTo(Order::class,'product_id' );
    }
    public function create()
    {
        return view('orders.create');
    }
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'order_id'=>'required',
            'product_id'=>'required',
            'variant_id'=>'required',
            'quantity'=>'required',
            'price'=>'required',
        ]);
        OrderItem::create([
           'order_id'=>$validateData['order_id'],
            'product_id'=>$validateData['product_id'],
            'variant_id'=>$validateData['variant_id'],
            'quantity'=>$validateData['quantity'],
            'price'=>$validateData['price'], 
        ]);
        return redirect()->route('orders.index');
    }
}
