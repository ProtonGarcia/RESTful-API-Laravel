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
            'fecha_eliminacion' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null ,
        ];
    }
}
