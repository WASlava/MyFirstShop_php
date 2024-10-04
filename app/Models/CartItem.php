<?php

namespace App\Models;

class CartItem
{
    public $product;
    public $count;

    public function __construct($product, $count = 1)
    {
        $this->product = $product;
        $this->count = $count;
    }

    public function getTotalPrice()
    {
        return $this->product->price * $this->count;
    }
}
