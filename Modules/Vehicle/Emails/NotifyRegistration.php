<?php

namespace Modules\Vehicle\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Modules\Vehicle\Entities\Tanker;

class NotifyRegistration extends Mailable
{
    protected $tanker;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tanker $tanker)
    {
        $this->tanker = $tanker;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tanker = $this->tanker;
        return $this->view('vehicle::email.registration-email')->with('tanker', $tanker)
                    ->subject('Notifikasi Pendaftaran Donatur');
    }
}
