<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Orders;
use App\Models\PopularProduct;
use App\Models\Product;
use App\Models\Region;
use App\Models\Tag;
use App\Nova\PaymentAndDelivery;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\RecommendedProductsTrait;
use App\Models\PaymentAndDelivery as Payment;

class CartController extends Controller
{
    use RecommendedProductsTrait;

    public function index()
    {
        $user_cookies = json_decode(Cookie::get('user'));

        $countOfCartProducts = 0;

        if($user_cookies) {
            $countOfCartProducts = count($user_cookies->cart);
        }

        $homepage_path = route('homepage');
        $storage_path = asset('storage/');
        $order_link = route('pages.cart.order');

        if($countOfCartProducts === 0) {
            return redirect()->route('homepage');
        }

        $non_tile_recommended_products = $this->getNonTileRecommendedProducts();
        $tile_recommended_products = $this->getTileRecommendedProducts();
        $json_encoded_recommended_products = $this->getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products);

        return view('pages.cart.index', compact('homepage_path', 'json_encoded_recommended_products', 'storage_path', 'order_link'));
    }

    public function order()
    {
        $delivery_phone = Contact::find(1)->delivery_phone;
        $online_phone = Contact::find(1)->online_shop_phone;;

        $regions = Region::orderBy('name_ru', 'ASC')->get();

        $non_tile_recommended_products = $this->getNonTileRecommendedProducts();
        $tile_recommended_products = $this->getTileRecommendedProducts();
        $json_encoded_recommended_products = $this->getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products);

        $modal = Payment::find(1);
        $modalDeliveryClause = $modal['delivery_clause_' . self::$lang];

        return view('pages.cart.order', compact('json_encoded_recommended_products', 'delivery_phone', 'online_phone', 'regions', 'modalDeliveryClause'));
    }

    public function checkout(OrderRequest $request)
    {
        try {
            $order = new Orders;

            $order->status = 'new';
            $order->url = 'cart/order/'.Str::random();
            $order->payment = $request->get('payment', '');
            $order->payment_method = $request->get('payment_method', '');
            $order->delivery_method = $request->get('delivery_method', '');
            $order->delivery_info = $request->get('delivery_form_data', '{}');
            $order->customer_name = $request->get('customer_name', '');
            $order->customer_phone = $request->get('customer_phone', '');
            $order->customer_email = $request->get('customer_email', '');
            $order->comment = $request->get('comment', '');
            $order->products = $request->get('products', '{}');
            $order->total = (int)str_replace(' ', '', $request->get('total_sum', 0));
            if($order->save()) {
                $this->addToPopular($request->get('products', '{}'));
                $this->decreaseProductStock($request->get('products', '{}'));

                $createdOrder = Orders::findOrFail($order->id);

                return response()->json(['success' => 'created successfully', 'order' => $createdOrder], 200);
            } else {
                return response()->json(['fail' => 'cannot create'], 404);
            }
        } catch (QueryException $queryException) {
            return response()->json(['fail' => $queryException->getMessage()], 404);
        }
    }

    public function addToPopular(string $products_json)
    {
        $products = json_decode($products_json, JSON_UNESCAPED_UNICODE);

        if($products) {
            foreach ($products as $product) {
                if(isset($product['products'])) {
                    $p = Product::ofArticul($product['product_id_for_kit'])->first();

                    if($p) {
                        $popular_product = PopularProduct::firstOrNew(['articul' => $p->articul]);
                        $popular_product->count_of_orders = $popular_product->count_of_orders + 1;
                        $popular_product->save();
                    }
                } else {
                    $p = Product::find($product['id']);

                    if($p) {
                        $popular_product = PopularProduct::firstOrNew(['articul' => $p->articul]);
                        $popular_product->count_of_orders = $popular_product->count_of_orders + 1;
                        $popular_product->save();
                    } else continue;
                }
            }
        }
    }

    public function decreaseProductStock(string $products_json)
    {
        $products = json_decode($products_json, JSON_UNESCAPED_UNICODE);

        if($products) {
            foreach ($products as $product) {
                if(isset($product['products'])) {
                    foreach ($product['products'] as $item) {
                        $p = Product::find($item['id']);

                        if($p) {
                            $p->stock -= $product['count'];
                            $p->save();
                        } else continue;
                    }

                    $p = Product::ofArticul($product['product_id_for_kit'])->first();

                    if($p) {
                        $p->stock -= $product['count'];
                        $p->save();
                    } else continue;
                } else {
                    $p = Product::find($product['id']);

                    if($p) {
                        $p->stock -= $product['count'];
                        $p->save();
                    } else continue;
                }
            }
        }
    }

    public function status(string $identification_key)
    {
        $url = 'cart/order/'.$identification_key;
        $order = Orders::where('url', $url)->first();
        $non_tile_recommended_products = $this->getNonTileRecommendedProducts();
        $tile_recommended_products = $this->getTileRecommendedProducts();
        $json_encoded_recommended_products = $this->getJsonEncodedRecommendedProducts($non_tile_recommended_products, $tile_recommended_products);

        return view('pages.cart.status', compact('order', 'json_encoded_recommended_products'));
    }
}
