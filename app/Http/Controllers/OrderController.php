<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $pizza_sizes = Order::BASES;
        $pizza_toppings = Order::TOPPINGS;
        $orders = Order::get();
        
        foreach ($orders as $ord) {
            $ord->editRoute = route('order.edit', $ord->id);
            $ord->total = $ord->base + count($ord->toppings);
            if (count($ord->toppings) > 3 ) {
                $ord->total = $ord->total*0.9;
                $ord->discounted = true;
            }
        }

        return Inertia::render('Order/List', [
            'pizza_sizes' => $pizza_sizes,
            'pizza_toppings' => $pizza_toppings,
            'orders' => $orders,
        ]);
    }

    public function create()
    {
        $pizza_sizes = Order::BASES;
        $pizza_toppings = Order::TOPPINGS;

        return Inertia::render('Order/Home', [
            'storeUrl' => route('order.store'),
            'pizza_sizes' => $pizza_sizes,
            'pizza_toppings' => $pizza_toppings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'base' => 'required | integer | min:1',
            'toppings' => 'required | array',
            'name' => 'required | string',
        ]);
 
        if ($validator->fails()) {
            $request->flash();
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        $order = new Order;
        $order->base = $request->base;
        $order->toppings = array_keys($request->toppings);
        $order->name = $request->name;
        $order->save();
        
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $pizza_sizes = Order::BASES;
        $pizza_toppings = Order::TOPPINGS;

        foreach($order->toppings as $top)
        {
            $tempTops[$top] = $pizza_toppings[$top];
            unset($pizza_toppings[$top]);
        }
        $order->toppings = $tempTops;
        unset($tempTops);

        $urls = [
            'updateUrl' => route('order.update', $order),
            'destroyUrl' => route('order.destroy', $order)
        ];

        return Inertia::render('Order/Edit', [
            'urls' => $urls,
            'pizza_sizes' => $pizza_sizes,
            'pizza_toppings' => $pizza_toppings,
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'base' => 'required | integer | min:1',
            'toppings' => 'required | array',
            'name' => 'required | string',
        ]);
 
        if ($validator->fails()) {
            $request->flash();
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        $order->base = $request->base;
        $order->toppings = array_keys($request->toppings);
        $order->name = $request->name;
        $order->save();

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('dashboard');
    }
}
