<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
     *
     *obtener la lista de transacciones por categoria
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {

        $this->allowedAdminAction();
        $transactions = $category->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showAll($transactions);
    }
}
