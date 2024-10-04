<?php

namespace App\Models;

class Cart
{
    protected $items = [];

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function getCartItems()
    {
        return $this->items;
    }

    public function addToCart(CartItem $item)
    {
        foreach ($this->items as &$cartItem) {
            if ($cartItem->getProduct()->getId() == $item->getProduct()->getId()) {
                $cartItem->setCount($cartItem->getCount() + 1);
                return;
            }
        }
        $this->items[] = $item;
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotalPrice();
        }
        return $total;
    }

    public function removeFromCart($id)
    {
        foreach ($this->items as $key => $cartItem) {
            if ($cartItem->getProduct()->getId() == $id) {
                unset($this->items[$key]);
                return true;
            }
        }
        return false;
    }

    public function removeFromCartItem(CartItem $cartItem)
    {
        return $this->removeFromCart($cartItem->getProduct()->getId());
    }

    public function incCount($id)
    {
        foreach ($this->items as &$cartItem) {
            if ($cartItem->getProduct()->getId() == $id) {
                $this->addToCart($cartItem);
                return;
            }
        }
    }

    public function decCount($id)
    {
        foreach ($this->items as &$cartItem) {
            if ($cartItem->getProduct()->getId() == $id) {
                $cartItem->setCount($cartItem->getCount() - 1);
                if ($cartItem->getCount() <= 0) {
                    $this->removeFromCartItem($cartItem);
                }
                return;
            }
        }
    }
}

