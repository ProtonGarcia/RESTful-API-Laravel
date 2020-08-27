<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identificador' => (int)$user->id,
            'nombre' => (string)$user->name,
            'correo' => (string)$user->email,
            'verificado' => (int)$user->verified,
            'administrador' => ($user->admin === 'true'),
            'fecha_creacion' => (string)$user->created_at,
            'fecha_modificacion' => (string)$user->updated_at, 
            'fecha_eliminacion' => isset($user->deleted_at) ? (string)$user->deleted_at : null ,
        ];
    }
}
