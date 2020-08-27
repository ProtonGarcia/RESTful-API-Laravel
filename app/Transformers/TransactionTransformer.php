<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identificador' => (int)$transaction->id,
            'cantidad' => (int)$transaction->quantity,
            'comprador' => (int)$transaction->buyer_id,
            'producto' => (int)$transaction->product_id,
            'fecha_creacion' => (string)$transaction->created_at,
            'fecha_modificacion' => (string)$transaction->updated_at, 
            'fecha_eliminacion' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null ,
         ];
    }
}
