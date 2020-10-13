<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Seller;

class sellerController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
        $this->middleware('can:view seller')->only('show');
    }

    public function index()
    {
        $this->allowedAdminAction();

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
