<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    const PRODUCT_AVAILABLE = 'disponible';
    const PRODUCT_UNAVAILABLE = 'no disponible';

    use SoftDeletes;
    //

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    protected $hidden =[
        'pivot'
    ];

    public function disponibilidad()
    {
        return $this->status == Product::PRODUCT_AVAILABLE;
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}
