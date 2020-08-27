<?php

namespace App;

use App\Scopes\BuyerScope;
use App\Transaction;
use App\Transformers\BuyerTransformer;

class Buyer extends User
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    public function Transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    #transformador
    public $transformer = BuyerTransformer::class;
}
