<table width="100%">
    <tr>
        <td>Member ID</td>
        <td>:</td>
        <td>{{ $member->code }}</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{ $member->name }}</td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $member->nik }}</td>
    </tr>
    <tr>
        <td>NIK Terpakai</td>
        <td>:</td>
        <td>{{ $nik_count }} kali</td>
    </tr>
    <tr>
        <td>Gambar KTP</td>
        <td>:</td>
        <td><img src="{{ env('APP_URL') . '/member/ktp/' . $member->code . '.jpg' }}" height="204" width="323"></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td>Referral</td>
        <td>:</td>
        <td>
            @if($member->ref_id !== null)
            {{ $member->referral->code }} {{ $member->referral->name }}
            @else
            -
            @endif
        </td>
    </tr>
    <tr>
        <td>Activation Link</td>
        <td>:</td>
        <td>
            <a target="_blank" href="{{ env('APP_URL') . '/member/activate?m=' . $member->id . '&t=' . $member->remember_token }}">Activate Member</a>
        </td>
    </tr>
</table>
