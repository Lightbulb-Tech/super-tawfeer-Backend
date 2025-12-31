<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartRequest as objRequest;
use App\Http\Resources\CartResource as objResource;
use App\Services\Banha\CartService as objService;
use App\Services\Banha\ProductService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(objService $service)
    {
        $data = $service->getWhere(['user_id' => Auth::guard('api')->id()]);
        $total_price_in_cart = $data->sum(function ($item) {
            return $item->final_price * $item->quantity;
        });
        $total_saving_in_cart = $data->sum(function ($item) {
            return ($item->price * $item->quantity) - ($item->final_price * $item->quantity);
        });
        $total_points_in_cart = $data->sum(function ($item) {
            return $item->points * $item->quantity;
        });
        return jsonSuccess([
            'items' => objResource::collection($data),
            'total_price_in_cart' => (double)$total_price_in_cart,
            'total_saving_in_cart' => (double)$total_saving_in_cart,
            'total_points_in_cart' => round($total_points_in_cart, '2'),
        ]);
    }

    public function store(objRequest $request, objService $service, ProductService $productService)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::guard('api')->id();
        $product = $productService->find($data['product_id']);
        $data['price'] = $product->price;
        $data['points'] = $product->points;
        $data['final_price'] = $data['price'];
        $data['offer_discount'] = $data['price'] - $data['final_price'];
        if (isset($product->offer)) {
            $data['offer_id'] = $product->offer->id;
            $data['offer_type'] = $product->offer->type;
            $data['offer_value'] = $product->offer->value;
            $data['final_price'] = calculatePriceAfterOffer($product->price, $product->offer);
            $data['offer_discount'] = $product->price - $data['final_price'];
        }
        $available_amount_for_order = $product->amount - $product->reserved_amount;
        if ($product->amount < $data['quantity']) {
            return jsonSuccess(null, __("api.quantity_not_enough"), 422);
        }
        if ($data['quantity'] > $available_amount_for_order) {
            return jsonSuccess(null, __("api.The_requested_product_quantity_is_currently_unavailable_for_order"), 422);
        }
        if ($data['quantity'] > $product->max_quantity_for_order) {
            return jsonSuccess(null, __("api.Sorry_you_have_reached_the_maximum_quantity_for_this_product"), 422);
        }
        $cartObj = $service->checkIfProductInCartForUser($data);
        if ($cartObj) {
            $newQuantity = $cartObj->quantity + $data['quantity'];
            if ($newQuantity > $available_amount_for_order) {
                return jsonSuccess(null, __("api.The_requested_product_quantity_is_currently_unavailable_for_order"), 422);
            }
            $cartObj->update(['quantity' => $newQuantity]);
        } else {
            $service->store($data);
        }

        return jsonSuccess(null, __("api.added_to_cart_successfully"));
    }

    public function update(objRequest $request, $id, objService $service)
    {
        $data = $request->validated();
        $cart = $service->find($id);
        if (!$cart) {
            return jsonSuccess(null, __("api.data_not_found"), 422);
        }
        $available_amount_for_order = @$cart->product->amount - @$cart->product->reserved_amount;
        if (!$cart->product) {
            return jsonSuccess(null, __("api.product_not_found"), 422);
        }
        if ($data['type'] === 'increase') {
            $newQuantity = $cart->quantity + $data['quantity'];
            if ($newQuantity > @$cart->product->amount) {
                return jsonSuccess(null, __("api.quantity_not_enough"), 422);
            }
            if ($newQuantity > $available_amount_for_order) {
                return jsonSuccess(null, __("api.The_requested_product_quantity_is_currently_unavailable_for_order"), 422);
            }
            if ($newQuantity > @$cart->product->max_quantity_for_order) {
                return jsonSuccess(null, __("api.Sorry_you_have_reached_the_maximum_quantity_for_this_product"), 422);
            }
            $cart->update(['quantity' => $newQuantity]);
        } elseif ($data['type'] === 'decrease') {
            if ($cart->quantity >= $data['quantity']) {
                $newQuantity = $cart->quantity - $data['quantity'];
                if ($newQuantity <= 0) {
                    $cart->delete();
                    return jsonSuccess(null, __("api.removed_from_cart_successfully"));
                }
                $cart->update(['quantity' => $newQuantity]);
            } else {
                return jsonSuccess(null, __("api.quantity_not_enough"), 422);
            }
        }

        return jsonSuccess(null, __("api.updated_cart_successfully"));
    }

    public function destroy($id, objService $service)
    {
        if ($id == 'all') {
            $service->getWhere(['user_id' => Auth::guard('api')->id()])->each(function ($cart) {
                $cart->delete();
            });
        } else {
            $cart = $service->find($id);
            if (!$cart) {
                return jsonSuccess(null, __("api.data_not_found"), 422);
            }
            $service->delete($id);
        }
        return jsonSuccess();
    }

}
