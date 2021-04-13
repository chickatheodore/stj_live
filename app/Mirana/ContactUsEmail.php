<?php


namespace App\Mirana;


use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class ContactUsEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from($this->data['email'])
            ->view('panels.email')
            ->subject($this->data['subject'])
            ->with([
                'data' => $this->data
            ]);
    }
}
