<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identificador' => (int)$category->id,
            'titulo' => (string)$category->name,
            'detalles' => (string)$category->description,
            'fecha_creacion' => (string)$category->created_at,
            'fecha_modificacion' => (string)$category->updated_at, 
            'fecha_eliminacion' => isset($category->deleted_at) ? (string)$category->deleted_at : null ,
        ];
    }
}
