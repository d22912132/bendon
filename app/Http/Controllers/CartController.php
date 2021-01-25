<?php

namespace App\Http\Controllers;

use App\Model\Cart;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 利用$request->user()來抓取目前登入者的資訊。
    public function index(Request $request)
    {
        // 抓出目前登入者的所有購物車資料，即$request->user()->carts()最後利用get()去抓取有資料出來即可。
        $user = $request->user();
        return view('cart.index', compact('user'));
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
    public function store(CartRequest $request)
    {
        // 從資料庫中查詢該商品是否已經在購物車中，如果存在則直接疊加商品數量
        if($cart = $request->user()->carts()->where('product_id',$request->product_id)->first()){
            $cart->update([
                'amount' => $cart->amount + $request->amount,
            ]);
        }else{
            // 否則創建一個新的購物車記錄
            Cart::create($request->all());
        }
        return [];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $request->user()->carts()->where('product_id',$id)->delete();
        return [];
    }
}
