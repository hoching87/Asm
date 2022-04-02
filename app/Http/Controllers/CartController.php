<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        return $cartItems;
    }


    public function addToCart(Request $request)
    {
        \Cart::add(array(
            'id' => $request->id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'name' => $request->name,
            'attributes' =>  $request->image,
        ));
        session()->flash('success', 'Product is Added to Cart Successfully !');

        return 'ok';
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return 'ok';
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return 'ok';
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return 'ok';
    }
}
