<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Attachment;

class OrderSuccess extends Mailable
{
    use Queueable, SerializesModels;
    public $cart;
    public $user_info;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_info, $cart)
    {
        $this->cart = $cart;
        $this->user_info = $user_info;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // メールタイトル
    public function envelope()
    {
        return new Envelope(
            subject: 'Order Success',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.order.orderSuccess',
            with: ([
                'cart' => $this->cart,
                'user_ifno' => $this->user_info
            ])

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $attachments = [];

        foreach ($this->cart as $item) {
            if (isset($item['image_path'])) {
                $attachmentPath = public_path('storage/' . $item['image_path']);
                $attachments[] = Attachment::fromPath($attachmentPath);
            }
        }
        return $attachments;
    }
}
