<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('scope:manage-products')->except('index');
        $this->middleware('can:add-category,product')->only('update');
        $this->middleware('can:delete-category,product')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;

        return $this->showAll($categories);
    }



    /**
     * Sele agregara una categoria al producto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,Category $category)
    {
        //sync, attach, syncWithoutDetaching

        #sync = agregaria un nuevo elemento pero eliminando los demas
        #attach = agrega un nuevo elemento pero no reconoce si hay elementos repetidos
        #syncWithoutDetaching = agrega un nuevo elemento y reconoce si hay elementos repetidos

        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    /**
     * Eliminar una categoria de las categorias de un producto
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('No se encontro asociacion del producto con la categoria especificada', 404);  
        }

         #detach = remover
         $product->categories()->detach([$category->id]);

         return $this->showAll($product->categories);
    }
}
