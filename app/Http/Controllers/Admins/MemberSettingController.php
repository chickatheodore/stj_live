<?php


namespace App\Http\Controllers\Admins;


use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Kucing;
use App\Member;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class MemberSettingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $members = Member::with('sponsor', 'upLine', 'leftDownLine', 'rightDownLine')->get();

        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"], ['name'=>"User List"]
        ];
        return view('/admins/user-list', [
            'breadcrumbs' => $breadcrumbs,
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $kucing = new Kucing();
        $member = new Member();
        $countries = Country::all();
        $provinces = Province::all();
        $cities = City::all();

        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"], ['name'=>"User List"]
        ];
        return view('/admins/user-edit', [
            'breadcrumbs' => $breadcrumbs,
            'member' => $member,
            'kucing' => $kucing,
            'countries' => $countries,
            'provinces' => $provinces,
            'cities' => $cities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $all = $request->all();
        unset($all['_token']);

        $pass = '';
        $real_pass = '123456';
        if (!isset($request->password)) {
            $pass = Hash::make('123456');
            $all['password'] = $pass;
        }

        if (isset($request->id)) {
            $member = Member::find($request->id);
            $member->name = $request->name;
            $member->email = $request->email;
            $member->nik = $request->nik;
            $member->address = $request->address;
            $member->phone = $request->phone;
            $member->country_id = $request->country_id;
            $member->province_id = $request->province_id;
            $member->city_id = $request->city_id;
            $member->bank = $request->bank;
            $member->account_number = $request->account_number;
            $member->account_name = $request->account_name;
            if ($all['password']) {
                $member->password = $pass;
                $real_pass = $all['password'];
            }
            $member->save();
        } else {
            $member = Member::updateOrCreate($all);
        }
        if (isset($request->id)) {
            if (isset($all['password'])) {
                if ($all['password']) {
                    $kucing = Kucing::where('kucing_id', '=', $member->id)->first();
                    $kucing->ikan_asin = $real_pass;
                    $kucing->save();
                }
            }
        } else
            Kucing::create(['member_id' => $member->id, 'ikan_asin' => '123456']);

        return redirect('/admin/member/edit/' . $member->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $member = Member::find($id);
        $kucing = Kucing::where('kucing_id', '=', $id)->first();
        if ($kucing === null)
        {
            $kucing = new Kucing();
            $kucing->ikan_asin = '';
        }

        $countries = Country::all();
        $provinces = Province::all();
        $cities = City::all();

        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"], ['name'=>"User List"]
        ];
        return view('/admins/user-edit', [
            'breadcrumbs' => $breadcrumbs,
            'member' => $member,
            'kucing' => $kucing,
            'countries' => $countries,
            'provinces' => $provinces,
            'cities' => $cities
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getMembers()
    {
        $arr = [];
        $members = Member::all();

        foreach ($members as $member) {
            $item = $member->toArray();
            $item['sponsor'] = $member->sponsor == null ? null : $member->sponsor->name;
            $item['upLine'] = $member->upLine == null ? null : $member->upLine->name;
            $item['leftDownLine'] = $member->leftDownLine == null ? null : $member->leftDownLine->name;
            $item['rightDownLine'] = $member->rightDownLine == null ? null : $member->rightDownLine->name;
            //array_push($arr, $member->toArray());
            array_push($arr, $item);
        }

        $json = json_encode($arr);
        return $json;
    }

}
