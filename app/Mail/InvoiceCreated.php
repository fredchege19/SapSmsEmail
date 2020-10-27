<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $items;
    public $invoice;
    public $customer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, $get_docentry, $get_email)
    {
        $this->items = $products;
        $this->invoice = $get_docentry;
        $this->customer = $get_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invoice_created');
    }
}
