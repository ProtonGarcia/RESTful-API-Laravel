<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Seller;

class sellerController extends ApiController
{

    public function index()
    {
        $vendedores = Seller::has('products')->get();
        //return response()->json(['data' => $vendedores], 200);

        return $this->showAll($vendedores);
    }


    public function show(Seller $seller)
    {
        //$vendedor = Seller::has('products')->findOrFail($id);

        //return response()->json(['data' => $vendedor],200);
        return $this->showOne($seller);
    }
}
