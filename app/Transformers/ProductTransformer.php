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
            'titulo' => (string)$product->quantity,
            'descripcion' => (string)$product->description,
            'disponibles' => (int)$product->quantity,
            'imagen' => url("img/{$product->image}"),
            'vendedor' => (int)$product->seller_id, 
            'fecha_creacion' => (string)$product->created_at,
            'fecha_modificacion' => (string)$product->updated_at, 
            'fecha_eliminacion' => isset($product->deleted_at) ? (string)$product->deleted_at : null ,
        ];
    }
}
