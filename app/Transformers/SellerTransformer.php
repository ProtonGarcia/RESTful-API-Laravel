<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identificador' => (int)$seller->id,
            'nombre' => (string)$seller->name,
            'correo' => (string)$seller->email,
            'verificado' => (int)$seller->verified,
            //'administrador' => ($seller->admin === 'true'),
            'fecha_creacion' => (string)$seller->created_at,
            'fecha_modificacion' => (string)$seller->updated_at,
            'fecha_eliminacion' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('sellers.show', $seller->id)
                ],
                [
                    'rel' => 'seller.buyers',
                    'href' => route('sellers.buyers.index', $seller->id)
                ],
                [
                    'rel' => 'seller.categories',
                    'href' => route('sellers.categories.index', $seller->id)
                ],
                [
                    'rel' => 'seller.products',
                    'href' => route('sellers.products.index', $seller->id)
                ],
                
                [
                    'rel' => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $seller->id)
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $seller->id)
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
