<?php

namespace App\Mail;

use App\Models\Cart1;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CartMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $cart;
    public $totalPrice;

    public function __construct(User $user, Cart1 $cart, $totalPrice)
    {
        $this->user = $user;
        $this->cart = $cart;
        $this->totalPrice = $totalPrice;
    }

    public function build()
    {
        return $this->view('emails.cart')
            ->with([
                'user' => $this->user,
                'cart' => $this->cart,
                'totalPrice' => $this->totalPrice,
            ]);
    }
}
