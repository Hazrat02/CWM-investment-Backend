<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;

class userdetails extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $pass;


    /**
     * Create a new message instance.
     *
     * @param int $forgetCode
     * @return void
     */
    public function __construct($email ,$pass)
    {
        $this->email = $email;
        $this->pass = $pass;

    }
    public function content()
    {
        return new Content(
            view: 'emails.userdetailse', // Change 'view.name' to the actual Blade view name
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@capitalswealthmanagement.com') // Set the sender's email address
                    ->view('emails.userdetailse') // Change 'view.name' to the actual Blade view name
                    ->subject('New User Account Create');

       
    }
}
