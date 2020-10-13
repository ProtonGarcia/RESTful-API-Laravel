<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategorySellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     *Lista de los vendedores de una categoria especifica
     *obtener la lista de transacciones por categoria
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $this->allowedAdminAction();
        $sellers = $category->products()
        ->with('seller')
        ->get()
        ->pluck('seller')
        ->unique()
        ->values();

        return $this->showAll($sellers);

    }

 
}
