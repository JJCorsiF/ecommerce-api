<?php

namespace App\Mail;

use App\Cliente;
use App\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoRealizado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;

    public $cliente;

    public $produtos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, Cliente $cliente)
    {
        $this->pedido = $pedido;
        $this->cliente = $cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@ecommerce-api.com')->view('mail-template');
    }
}
