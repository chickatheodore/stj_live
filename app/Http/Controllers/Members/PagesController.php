<?php

namespace App\Http\Controllers\Members;

use App\City;
use App\Country;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessMember;
use App\Level;
use App\Member;
use App\Mirana\MemberRegistrationEmail;
use App\Province;
use App\Transaction;
use App\TransactionStatus;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\False_;

class PagesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        //$this->middleware('guest:admin')->except('logout');
        //$this->middleware('guest:member')->except('logout');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'member_id' => ['required'],
            //'sponsor_id' => ['exclude_if:upline_id,false|required'],
            'sponsor_id' => ['required_if:upline_id,false'],
            'upline_id' => ['required_if:sponsor_id,false'],
        ]);
    }

    // User Profile
    public function userProfile() {
        $user = auth()->user();
        $pageConfigs = [
            'sidebarCollapsed' => true
        ];

        $id = auth()->id();
        $member = Member::find($id);

        $levels = Level::all();
        $allMembers = Member::all();
        $countries = Country::all();
        $provinces = Province::all();
        $cities = City::all();

        $breadcrumbs = [
            ['link'=>"dashboard-analytics",'name'=>"Home"], ['link'=>"dashboard-analytics",'name'=>"Pages"], ['name'=>"Profile"]
        ];

        return view('/members/profile', [
            'member' => $member,
            'pageConfigs' => $pageConfigs,
            //'breadcrumbs' => $breadcrumbs
            'levels' => $levels,
            'allMembers' => $allMembers,
            'countries' => $countries,
            'provinces' => $provinces,
            'cities' => $cities
        ]);
    }

    // Register
    public function showMemberRegistrationForm() {
        if (!Auth::guard('member')->check()) {
            return redirect()->intended('/member/login');
        }

        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        $breadcrumbs = [
            [ 'link' => "home", 'name'=>"Home"], [ 'name' => 'Registrasi' ]
        ];

        $allMembers = Member::all()->where('id', '>', 1);
        $countries = Country::all();
        $provinces = Province::all();
        $cities = City::all();

        return view('/members/register', [
            'breadcrumbs' => $breadcrumbs,
            //'pageConfigs' => $pageConfigs,
            'allMembers' => $allMembers,
            'countries' => $countries,
            'provinces' => $provinces,
            'cities' => $cities
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    protected function createMember(Request $request)
    {
        $id = auth()->id();

        //$this->validator($request->all())->validate();
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'nik' => ['required'],
            'password' => ['required'],
            'address' => ['required'],
            'image_file' => ['required'],
        ])->validate();
        //code, username

        $nik_count = Member::where('nik', '=', $request->nik)->count();
        if ($nik_count >= 3)
            throw ValidationException::withMessages(['nik' => 'NIK telah digunakan 3 kali.']);

        $kiri = null;
        $kanan = null;
        $tempat = $request->pohonRadio;

        /*$pass = Hash::make($request->password);
        $pass1 = password_hash ($request->password, PASSWORD_DEFAULT);
        $pass2 = password_hash ($request->password, PASSWORD_BCRYPT);
        $pass3 = password_hash ($request->password, PASSWORD_ARGON2I);
        $pass4 = password_hash ($request->password, PASSWORD_ARGON2ID);*/

        $req = [
            'name' => $request->name,
            'nik' => $request->nik,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'province_id' => $request->province_id,
            'postal_code' => $request->postal_code,
            'country_id' => $request->country_id,
            'phone' => $request->phone,
            //'sponsor_id' => $request->sponsor_id,
            //'upline_id' => $request->upline_id,
            'bank' => $request->bank,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_new_member' => '1',
            'is_active' => '0',
            'ikan' => $request->password,
            'ref_id' => $id
        ];

        $member = Member::create($req);
        $member->setIkanAttribute($request->password);

        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file');

            $curr_file = storage_path('app/members/' . $member->code . '.jpg');
            $thumb_file = storage_path('app/members/thumbnail/' . $member->code . '.jpg');

            if (file_exists($curr_file)) {
                Storage::delete('app/members/' . $member->code . '.jpg');
            }
            if (file_exists($thumb_file)) {
                Storage::delete('app/members/thumbnail/' . $member->code . '.jpg');
            }

            $path = $request->file('image_file')->storeAs('members', $member->code . '.jpg'); //, 'public'
            //$thumb = $request->file('image_file')->storeAs('members/thumbnail', $member->code . '.jpg');

            //$img = Image::make($thumb)->resize(204, 323)->save($thumb);
        }

        //Hapus Left & Right downline jika tersetting
        if ($member->left_downline_id || $member->right_downline_id)
        {
            if ($member->left_downline_id)
                $member->left_downline_id = null;
            if ($member->right_downline_id)
                $member->right_downline_id = null;
            $member->save();
        }

        if ($tempat && $request->upline_id) {
            $upline = Member::find($request->upline_id);
            if ($tempat == 'left' && !$upline->left_downline_id) {
                $upline->left_downline_id = $member->id;
                $upline->save();
            }
            if ($tempat == 'right' && !$upline->right_downline_id) {
                $upline->right_downline_id = $member->id;
                $upline->save();
            }
        } else if ($request->upline_id) {
            $upline = Member::find($request->upline_id);
            $upline->left_downline_id = $member->id;
            $upline->save();
        }

        if ($request->upline_id)
            $this->dispatch(new ProcessMember($member, 'level'));

        $to = env('MAIL_TO', 'admin@stjbali.com');
        try {
            Mail::to($to)->send(new MemberRegistrationEmail($member));
        } catch (\Exception $e) {
            $a = $e->getMessage();
        }

        //return $member;
        return view('members/registered', [
            'member' => $member
        ]);
    }

    public function activateMember(Request $request)
    {
        $id = $request->m;
        $token = $request->t;

        $now = Carbon::now();
        $tgl = Carbon::create($now->year, $now->month, 1, 0, 0, 0);
        $tgl = $tgl->addMonth(2)->subDay();

        $member = Member::find($id);
        //$code = Hash::make($member->code);
        $code = $member->remember_token;
        if ($token === $code)
        {
            $member->is_active = 1;
            $member->activation_date = $now->format('Y-m-d H:i:s');
            $member->close_point_date = $tgl;
            $member->remember_token = null;
            $member->save();
        }

        return view('members/activated');
    }

    public function checkValidKTP(Request $request)
    {
        if ($request->file('image_file')) {
            //convert image to base64
            $image = base64_encode(file_get_contents($request->file('image_file')));

            $data = Helper::getTextFromGoogleVision($image);
            $a = '';
        }
    }

    public function upgradeLevel(Request $request)
    {
        $all = $request->all();

        $this->validate($request, [
            'level_id' => 'required',
        ]);

        $id = $request->_acc_;
        $member = Member::where('id', '=', $id)->first();
        if ($member) {

            $level = Level::find($request->level_id);
            $amount = $level->minimum_point;
            $balance = $member->pin - $amount;

            $all['pin'] = $balance;
            Member::updateOrCreate([ 'id' => $id ], $all);

            Transaction::create([
                'member_id' => $id,
                'user_id' => $id,
                'status_id' => 3,   //Processed
                'type' => 'pin',
                'trans' => 'UPG-LVL',
                'pin_beginning_balance' => $member->pin,
                'pin_amount' => 0 - ($amount),
                'pin_ending_balance' => $balance
            ]);

            return json_encode(['status' => true, 'message' => 'Informasi member telah di update.', 'pin' => $balance]);
        }

        return json_encode(['status' => false, 'message' => 'Silahkan cek input anda.']);
    }

    public function updateProfileAccount(Request $request)
    {
        $all = $request->all();

        $valid = $this->validate($request, [
            'old_password'   => 'required',
            'password' => 'required_with:con_password|same:con_password|min:6'
        ]);

        $id = $request->_acc_; //auth()->id();
        $member = Member::where('id', '=', $id)->first();
        if ($member) {
            $pass = $member->password;
            $hash = Hash::make($request->password);

            if (Hash::check($request->old_password, $pass)) {
                $member->password = $hash;
                $member->setIkanAttribute($request->password);

                $member->save();

                return json_encode(['status' => true, 'message' => 'Password berhasil diubah.']);

            } else {

                return json_encode(['status' => false, 'message' => 'Silahkan cek input anda.']);

            }
        }

        return json_encode(['status' => false, 'message' => 'Silahkan cek input anda.']);
    }

    public function updateProfileInfo(Request $request)
    {
        $all = $request->all();

        $valid = $this->validate($request, [
            'address'   => 'required',
            'nik'   => 'required',
            //'password' => 'required_with:con_password|same:con_password|min:6'
        ]);

        $id = $request->_acc_;
        $member = Member::where('id', '=', $id)->first();
        if ($member) {

            $message = 'Informasi member telah di update.';
            if ($request->hasFile('image_file')) {
                $imagePath = $request->file('image_file');

                $curr_file = storage_path('app/members/' . $member->code . '.jpg');
                if (file_exists($curr_file)) {
                    Storage::delete('app/members/' . $member->code . '.jpg');
                }

                $path = $request->file('image_file')->storeAs('members', $member->code . '.jpg'); //, 'public'
                //$message = $message . ' imagePath: ' . $imagePath . ', path: ' . $path;
            } else {
                //$message = $message . ' Has no file';
            }

            Member::updateOrCreate([ 'id' => $id ], $all);
            //$member->save($all);

            return json_encode(['status' => true, 'message' => $message ]);
        }

        return json_encode(['status' => false, 'message' => 'Silahkan cek input anda.']);
    }

    // Register
    public function showMemberPlacementForm() {
        if (!Auth::guard('member')->check()) {
            return redirect()->intended('/member/login');
        }

        $breadcrumbs = [
            [ 'link' => "home", 'name'=>"Home"], [ 'name' => 'Penempatan' ]
        ];

        $my_id = auth()->id();
        $levels = Level::all();
        $member = Member::find($my_id);
        $newMembers = Member::where('id', '>', 1)
            ->where(function ($query){ return $query->whereNull('sponsor_id')->orWhereNull('upline_id');})
            //->whereNull('upline_id')
            ->get();

        $allMembers = Member::where('id', '>', 1)->get();

        return view('/members/placement', [
            'breadcrumbs' => $breadcrumbs,
            'levels' => $levels,
            'member' => $member,
            'allMembers' => $allMembers,
            'newMembers' => $newMembers
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    protected function memberPlacement(Request $request)
    {
        $this->validator($request->all())->validate();
        //code, username

        $kiri = null;
        $kanan = null;
        $tempat = $request->pohonRadio;

        $member = Member::find($request->member_id);

        if ($member) {
            /*if ($request->level_id !== $member->level_id) {
                $member->level_id = $request->level_id;

                $level = Level::find($request->level_id);
                $member->pin = $member->pin - $level->minimum_point;
            }*/

            $member->sponsor_id = $request->sponsor_id;
            $member->upline_id = $request->upline_id;

            if ($tempat && $request->upline_id) {
                $upline = Member::find($request->upline_id);
                if ($tempat == 'left' && !$upline->left_downline_id) {
                    $upline->left_downline_id = $member->id;
                    $member->tree_level = $upline->tree_level + 1;
                    $member->tree_position = $this->getPosition('left', $upline);
                    $upline->save();
                }
                if ($tempat == 'right' && !$upline->right_downline_id) {
                    $upline->right_downline_id = $member->id;
                    $member->tree_level = $upline->tree_level + 1;
                    $member->tree_position = $this->getPosition('right', $upline);
                    $upline->save();
                }
            } else if ($request->upline_id) {
                $upline = Member::find($request->upline_id);
                $upline->left_downline_id = $member->id;
                $member->tree_level = $upline->tree_level + 1;
                $member->tree_position = $this->getPosition('left', $upline);
                $upline->save();
            }

            $member->save();
        }

        $levels = Level::all();
        $newMembers = Member::whereNull('sponsor_id')->orWhereNull('upline_id')->get();
        $allMembers = Member::where('id', '>', 1)->get();

        return view('members/placement', [
            'levels' => $levels,
            'member' => $member,
            'saved' => true,
            'allMembers' => $allMembers,
            'newMembers' => $newMembers
        ]);
    }

    private function getPosition($pos, $upline)
    {
        $my_pos = 0;
        $pos = doubleval($upline->tree_position);

        if ($pos == 'left')
        {
            $my_pos = ($pos * 2) - 1;
        } else if ($pos == 'right')
        {
            $my_pos = ($pos * 2);
        }
        return strval($my_pos);
    }

    public function showPin() {
        $id = auth()->id();
        $member = Member::find($id);

        $pins = DB::selectOne(
            DB::raw('select SUM(IF(pin_amount > 0, pin_amount, 0)) as masuk, SUM(IF(pin_amount < 0, pin_amount, 0)) as keluar from transactions where (type = :pin or type = :all) and member_id = :my_id'), // or user_id = :us_id
            array('pin' => 'pin', 'all' => 'all', 'my_id' => $id)); //, 'us_id' => $id

        return view('members/pin', [
            'member' => $member,
            'pins' => $pins
        ]);
    }

    public function showTransferPin() {
        $id = auth()->id();
        $member = Member::find($id);
        $allMembers = Member::where('id', '>', 1)->get();

        return view('members/transfer-pin', [
            'member' => $member,
            'allMembers' => $allMembers
        ]);
    }

    public function sponsor()
    {
        $id = auth()->id();
        $sponsors = Member::where('sponsor_id', '=', $id)->get();

        return view('members/sponsor', [
            'sponsors' => $sponsors
        ]);
    }

    public function stockiest()
    {
        $stockiests = Member::where('is_stockiest', '=', 1)->get();

        return view('members/stockiest', [
            'stockiests' => $stockiests
        ]);
    }

    public function getBonus()
    {
        $id = auth()->id();
        $member = Member::find($id);

        return view('members/bonus', [
            'member' => $member
        ]);
    }

    public function showBonusHistory()
    {
        return view('members/bonus-history');
    }

    public function showExtendTUPO()
    {
        $id = auth()->id();
        $member = Member::find($id);

        $breadcrumbs = [
            ['link'=>"/member/home",'name'=>"Home"],['name'=>"Perpanjang TUPO"]
        ];

        return view('/members/extend', [
            'member' => $member,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function extendTUPO(Request $request)
    {
        $id = $request->_acc_;
        $member = Member::where('id', '=', $id)->first();

        $now = Carbon::now();
        $tupo = Carbon::create($now->year, $now->month, 1, 0)->addMonth(3)->subDay();

        $curr_pin = intval($member->pin);

        $member->close_point_date;
        $member->pin = $curr_pin - 1;
        $member->save();

        //Kurangi 1 PIN
        Transaction::create([
            'member_id' => $id,
            'user_id' => $id,
            'type' => 'pin',
            'trans' => 'EXTEND',
            'pin_beginning_balance' => $curr_pin,
            'pin_amount' => 1,
            'pin_ending_balance' => $curr_pin - 1
        ]);

        return json_encode(['status' => true, 'pin' => $member->pin, 'message' => 'Masa Berlaku TUPO telah diperpanjang.']);
    }

    public function showUpgradeLevel()
    {
        $id = auth()->id();
        $member = Member::find($id);
        $levels = Level::all();

        $breadcrumbs = [
            ['link'=>"/member/home",'name'=>"Home"],['name'=>"Upgrade Level"]
        ];

        return view('/members/upgrade', [
            'member' => $member,
            'levels' => $levels,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function getBonusHistory(Request $request)
    {
        $id = $request->_acc_;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $transactions = Transaction::where('member_id', '=', $id)
            ->where(function ($query){ return $query->where('type', '=', 'all')->orWhere('type', '=', 'point');})
            ->whereBetween('transaction_date', [$start_date, $end_date])->get();

        $lists = [];
        foreach ($transactions as $transaction)
        {
            $arr = $transaction->toArray();
            $arr['transaction_date'] = Carbon::parse($transaction->transaction_date)->format('d-M-Y');
            array_push($lists, $arr);
        }

        $data = json_encode($lists);
        return $data;
    }

    public function showPINHistory()
    {
        return view('members/pin-history');
    }

    public function getPINHistory(Request $request)
    {
        $id = $request->_acc_;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $transactions = Transaction::where('member_id', '=', $id)
            ->where(function ($query){ return $query->where('type', '=', 'all')->orWhere('type', '=', 'pin');})
            ->whereBetween('transaction_date', [$start_date, $end_date])->get();

        $lists = [];
        foreach ($transactions as $transaction) {
            $tran = $transaction->toArray();
            $tran['transaction_date'] = Carbon::parse($transaction->transaction_date)->format('d-M-Y');
            array_push($lists, $tran);
        }
        $data = json_encode($lists);
        return $data;
    }

}
