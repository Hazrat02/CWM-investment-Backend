<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;

class forgetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $forgetCode;
    public $title;
    public $btn;
    public $sub;

    /**
     * Create a new message instance.
     *
     * @param int $forgetCode
     * @return void
     */
    public function __construct($forgetCode ,$title,$btn ,$sub)
    {
        $this->forgetCode = $forgetCode;
        $this->title = $title;
        $this->btn = $btn;
        $this->sub = $sub;
    }
    public function content()
    {
        return new Content(
            view: 'emails.forget_plain', // Change 'view.name' to the actual Blade view name
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hazratbd80@gmail.com') // Set the sender's email address
                    ->view('emails.forget_plain') // Change 'view.name' to the actual Blade view name
                    ->subject($this->sub);

       
    }
}
