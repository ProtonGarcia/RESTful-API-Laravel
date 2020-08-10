<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerCategoryController extends ApiController
{
    /**
     * obtener la lista de categorias en las que un vendedor ha realizado una transaccion o venta.
     * Lista de compradores de un vendedor especifico
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products()
        ->with('categories')
        ->get()
        ->pluck('categories')
        ->collapse()
        ->unique('id')
        ->values();

        return $this->showAll($categories);
    }

}
