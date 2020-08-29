<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identificador' => (int)$product->id,
            'titulo' => (string)$product->name,
            'descripcion' => (string)$product->description,
            'disponibles' => (int)$product->quantity,
            'imagen' => url("img/{$product->image}"),
            'vendedor' => (int)$product->seller_id,
            'fecha_creacion' => (string)$product->created_at,
            'fecha_modificacion' => (string)$product->updated_at,
            'fecha_eliminacion' => isset($product->deleted_at) ? (string)$product->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id)
                ],
                [
                    'rel' => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id)
                ],
                [
                    'rel' => 'product.categories',
                    'href' => route('products.categories.index', $product->id)
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('products.transactions.index', $product->id)
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('sellers.show', $product->seller_id)
                ]
                ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'titulo' => 'name',
            'descripcion' => 'description',
            'disponibles' => 'quantity',
            'imagen' => 'image',
            'vendedor' => 'seller_id',
            'fecha_creacion' => 'created_at',
            'fecha_modificacion' => 'updated_at',
            'fecha_eliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identificador',
            'name' => 'titulo',
            'description' => 'descripcion',
            'quantity' => 'disponibles',
            'image' => 'imagen',
            'seller_id' => 'vendedor',
            'created_at' => 'fecha_creacion',
            'updated_at' => 'fecha_modificacion',
            'deleted_at' => 'fecha_eliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
