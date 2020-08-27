<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identificador' => (int)$buyer->id,
            'nombre' => (string)$buyer->name,
            'correo' => (string)$buyer->email,
            'verificado' => (int)$buyer->verified,
            //'administrador' => ($buyer->admin === 'true'),
            'fecha_creacion' => (string)$buyer->created_at,
            'fecha_modificacion' => (string)$buyer->updated_at,
            'fecha_eliminacion' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id)
                ],
                [
                    'rel' => 'buyer.categories',
                    'href' => route('buyers.categories.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('products.buyers.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyers.sellers.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id)
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $buyer->id)
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name',
            'correo' => 'email',
            'verificado' => 'verified',
            'fecha_creacion' => 'created_at',
            'fecha_modificacion' => 'updated_at',
            'fecha_eliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
