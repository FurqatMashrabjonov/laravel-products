<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Repositories\ProductRepository,
    Models\Product,
    Http\Requests\CartRequest
};

class ProductController extends Controller
{

     /**
     * The Controller instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
      //  $this->middleware('auth');

    }

    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products = $this->repository->funcSelect($request);
        if($request->ajax()){
            return response()->json([
               'table'=>view("product.product-standart", ['products'=>$products])->
               render(),
            ]);
        }
        return view('product.index', ['products' => $products]);
    }

     /**
     * Show the application productpage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product($id, Product $model_product)
    {
         $product = $model_product->find($id);
       // $product = $this->repository->funcSelectOne($id);
        return view('product.product', compact('product'));
    }

     /**
     * Show the application cartpage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cart(Request $request)
    {
        $carts = $this->repository->fromCart();
        if($request->ajax()){
            return response()->json([
                'table'=>view("product.cart-standart", ['carts'=>$carts])->
                render(),
            ]);
        }
        return view('product.cart', compact('carts'));
    }

    /**
     * Store data to cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tocart(CartRequest $request)
    {
        $this->repository->store($request);
        return redirect(route('cart'));
    }

    /**
     * Remove all cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clearall(Request $request , Cart $model_cart)
    {
        $model_cart->truncate();

 if($request->ajax()){
            return response()->json();
        }

        return redirect(route('cart'));
    }

    /**
     * Remove one cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clearone(Request $request)
    {
           $this->repository->clearone($request);
    }

    /**
     * method send message.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mailer(Request $request)
    {
        return $this->repository->mailer($request);
    }

}
