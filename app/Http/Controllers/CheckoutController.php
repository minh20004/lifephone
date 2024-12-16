<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
{
    $checkoutCart = session('checkout_cart', []);
    return view('client.page.checkout.index', compact('checkoutCart'));
}

}
