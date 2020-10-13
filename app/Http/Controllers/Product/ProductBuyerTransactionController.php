<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transaction;
use App\Transformers\TransactionTransformer;
use App\User;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:'.TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-product')->only('store');
        $this->middleware('can:pucharse,buyer')->only('store');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {

        $rules = [
            'quantity' => 'required|integer|min:1',
        ];

        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('el comprador debe ser diferente al vendedor del prodcuto', 409);
        }

        if (!$buyer->isVerified()) {
            $this->errorResponse('El comprador debe ser un usuario verificado', 409);
        }

        if (!$product->seller->isVerified()) {
            $this->errorResponse('El vendedor debe ser un usuario verificado', 409);
        }

        if (!$product->disponibilidad()) {
            return $this->errorResponse('El producto solicitado no esta disponible', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('No hay suficiente cantidad para suplir esta transaccion', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
