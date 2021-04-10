<?php


namespace App\Mirana;


use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class MemberRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function build()
    {
        $nik_count = Member::where('nik', '=', $this->member->nik)->count();

        $from = env('MAIL_FROM','no-reply@stjbali.com');

        return $this->from($from)
            ->view('members.email')
            ->subject('Registrasi Member baru')
            ->with([
                'member' => $this->member,
                'nik_count' => $nik_count,
                //'hash' => Hash::make($this->member->code)
            ]);
    }
}
