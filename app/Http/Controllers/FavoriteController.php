<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class FavoriteController extends Controller
{
    public function getFavorites(Request $request)
    {
        $customerId = $request->input('customer_id');

        $customer = Customer::find($customerId);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $favorites = $customer->favorites()->with('product')->get();

        return response()->json($favorites);
    }

    public function addToFavorites(Request $request)
    {
        $customerId = $request->input('customer_id');
        $productId = $request->input('product_id');

        $customer = Customer::find($customerId);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($customer->favorites()->where('product_id', $productId)->exists()) {
            return response()->json(['message' => 'Product already in favorites'], 400);
        }

        $customer->favorites()->create(['product_id' => $product->id]);

        return response()->json(['message' => 'Product added to favorites']);
    }

    public function removeFromFavorites(Request $request)
    {
      $customerId = $request->input('customer_id');
      $productIds = $request->input('product_ids');

      $customer = Customer::find($customerId);
      if (!$customer) {
          return response()->json(['message' => 'Customer not found'], 404);
      }

      if (empty($productIds)) {
          return response()->json(['message' => 'No product IDs provided'], 400);
      }

      $favorites = $customer->favorites()->whereIn('product_id', $productIds)->get();

      if ($favorites->isEmpty()) {
          return response()->json(['message' => 'No matching products in favorites'], 404);
      }

      $favorites->each(function($favorite) {
          $favorite->delete();
      });

      return response()->json(['message' => 'Selected products removed from favorites']);
    }

    public function addToCart(Request $request)
    {
      $request->validate([
          'product_ids' => 'required|array',
          'product_ids.*' => 'integer|exists:products,id',
      ]);

      $productIds = $request->input('product_ids');

      $cart = session()->get('cart', []);

      foreach ($productIds as $productId) {
          $product = Product::find($productId);

          if (!$product) {
              continue;
          }

          $variant = ProductVariant::where('product_id', $productId)
              ->where('stock', '>', 0)
              ->first();

          if (!$variant) {
              continue;
          }

          $cartItem = [
              'id' => $productId,
              'variant_id' => $variant->id,
              'model_id' => $variant->capacity_id,
              'color_id' => $variant->color_id,
              'price' => $product->price + $variant->price_difference,
              'image_url' => $product->image_url,
              'quantity' => 1,
          ];

          if (isset($cart[$productId][$variant->capacity_id][$variant->color_id])) {
              $cart[$productId][$variant->capacity_id][$variant->color_id]['quantity'] += 1;
          } else {
              $cart[$productId][$variant->capacity_id][$variant->color_id] = $cartItem;
          }
      }

      session()->put('cart', $cart);

      return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng']);
    }
}
