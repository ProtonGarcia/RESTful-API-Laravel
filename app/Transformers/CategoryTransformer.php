<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    
    public function transform(Category $category)
    {
        return [
            'identificador' => (int)$category->id,
            'titulo' => (string)$category->name,
            'detalles' => (string)$category->description,
            'fecha_creacion' => (string)$category->created_at,
            'fecha_modificacion' => (string)$category->updated_at,
            'fecha_eliminacion' => isset($category->deleted_at) ? (string)$category->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $category->id)
                ],
                [
                    'rel' => 'category.buyers',
                    'href' => route('categories.buyers.index', $category->id)
                ],
                [
                    'rel' => 'category.products',
                    'href' => route('categories.products.index', $category->id)
                ],
                [
                    'rel' => 'category.sellers',
                    'href' => route('categories.sellers.index', $category->id)
                ],
                [
                    'rel' => 'category.transactions',
                    'href' => route('categories.transactions.index', $category->id)
                ]

            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'titulo' => 'name',
            'detalles' => 'description',
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
            'description' => 'detalles',
            'created_at' => 'fecha_creacion',
            'updated_at' => 'fecha_modificacion',
            'deleted_at' => 'fecha_eliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
