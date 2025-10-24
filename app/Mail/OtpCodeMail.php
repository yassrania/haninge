<?php

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $code, public ?string $name = null) {}

    public function build()
    {
return $this->subject('Verifieringskod — Haninge Islamiska Forum')            ->view('emails.otp')
            ->with(['code' => $this->code, 'name' => $this->name]);
    }
}
