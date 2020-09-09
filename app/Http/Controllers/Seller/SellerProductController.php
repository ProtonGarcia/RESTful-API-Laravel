<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Product;
use App\Transformers\ProductTransformer;
use App\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.ProductTransformer::class)->only(['store', 'update']);
    }


    /**
     * Listando los productos por vendedor
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->showAll($products);
    }



    /**
     *Creacion de nuevos productos para que vendedores o usuarios que aun no son vendedores
     *puedan ingresar nuevos productos
     */
    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['status'] = Product::PRODUCT_UNAVAILABLE;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product, 201);
    }



    /**
     * Actualizar el producto de un vendedor especifico
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in: ' . Product::PRODUCT_AVAILABLE . ',' . Product::PRODUCT_UNAVAILABLE,
            'image' => 'image',
        ];

        $this->validate($request, $rules);

        $this->sellerVerify($seller,$product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));

        if ($request->has('status')) {
            $product->status =  $request->status;
        }

        if ($product->disponibilidad() && $product->categories()->count() == 0) {
            return $this->errorResponse('producto activo sin categoria, los productos deben pertenecer a una categoria como minimo.', 409);
        }

        if ($request->hasFile('image')) {
            Storage::delete($product->image);

            $product->image = $request->image->store('');
        }

        if ($product->isClean()) {
            return $this->errorResponse('Se debe especificar al menos uno o mas cambios para realizar esta accion.', 422);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->sellerVerify($seller,$product);

        Storage::delete($product->image);

        $product->delete();

        return $this->showOne($product);
    }

    protected function sellerVerify(Seller $seller, Product $product){
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422, 'No puedes modificar un producto que no es de tu propiedad');
           // return $this->errorResponse('No puedes modificar un producto que no es de tu propiedad', 422);
        }
    }
}
