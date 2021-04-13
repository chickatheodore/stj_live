<?php

namespace App\Http\Controllers\Members;

use Carbon\Carbon;
use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Level;
use App\Member;
use App\MemberTree;
use App\Province;
use App\Shop;
use App\TransactionPoint;
use App\TransactionStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TreeController extends Controller
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

    public function getTree(Request $request) {
        /*$id = auth()->id();
        $member = Member::find($id);
        $my_descendants = Member::with('leftDownLine', 'rightDownLine')->descendantsAndSelf($id)->toTree();
        return $my_descendants;*/

        return view('members/tree');
    }

    public function getMemberTree(Request $request) {
        $id = auth()->id();
        $count = 2;
        if (isset($request->id)) {
            if ($request->id !== null) {
                $id = intval($request->id);
                $count = 1;
            }
        }

        $my_teams = Member::with('leftDownLine', 'rightDownLine')->descendantsAndSelf($id)->toTree();
        $cm = Member::find($id);
        //return json_encode($my_teams);

        //$teams = Member::children()->toTree();
        $down = new MemberTree();

        $has_children = $cm->left_downline_id != null ||$cm->right_downline_id != null;
        //if (!$has_children)  //$my_teams->count() == 0
        //    return json_encode($this->buildEmptyMember($down));

        //$team = $my_teams[0];
        $iStart = $cm->tree_level;    //$team->tree_level;
        $iMaximum = $iStart + $count;

        $traverse = function (&$memberTree, $member) use (&$traverse, &$down, &$iStart, &$iMaximum) {
            if ($member->tree_level >= $iMaximum || $member->tree_level == 0)
                return;

            $memberTree->id = $member->id;
            $memberTree->code = $member->code;
            $memberTree->username = $member->username;
            $memberTree->name = $member->name;  //$member->username . ' - ' . $member->name;

            $memberTree->parentId = $member->upline_id;

            $memberTree->pin = number_format($member->pin, 0);
            $memberTree->bv = '25 BV';
            if (Carbon::parse($member->close_point_date) < Carbon::now())
                $memberTree->bv = '0 BV';
            $memberTree->cpd = Carbon::parse($member->close_point_date)->format('d-M-Y');
            $memberTree->poin = number_format($member->left_point, 0) . ' | ' . number_format($member->right_point, 0);
            $memberTree->point_bonus = number_format($member->point_bonus, 0);
            $memberTree->sponsor_bonus = number_format($member->sponsor_bonus, 0);
            $memberTree->pair_bonus = number_format($member->pair_bonus, 0);

            $childs = [ ];

            $kiri = $member->left_downline_id; //$member->getLft();
            $kanan = $member->right_downline_id; //$member->getRgt();
            $memberTree->left_id = $kiri;
            $memberTree->right_id = $kanan;

            $memberTree->relationship = $this->getRelationshipValue($member);

            $memberTree->className = 'exist' . ($member->level_id == 2 ? ' gold' : '');

            //$iStart = $member->tree_level;
            $memberTree->level = $member->tree_level;
            $memberTree->level_id = $member->level_id;

            $treeKiri = new MemberTree();
            $treeKanan = new MemberTree();

            if ($kiri) {
                $memberKiri = Member::find($kiri);
                $treeKiri->id = $memberKiri->id;
                $treeKiri->code = $memberKiri->code;
                $treeKiri->username = $memberKiri->username;
                $treeKiri->name = $memberKiri->name;    //$memberKiri->username . ' - ' . $memberKiri->name;
                $treeKiri->parentId = $memberKiri->upline_id;
                $treeKiri->level = $memberKiri->tree_level;
                $treeKiri->level_id = $memberKiri->level_id;

                $treeKiri->pin = number_format($memberKiri->pin, 0);
                $treeKiri->bv = '25 BV';
                if (Carbon::parse($memberKiri->close_point_date) < Carbon::now())
                    $treeKiri->bv = '0 BV';
                $treeKiri->cpd = Carbon::parse($memberKiri->close_point_date)->format('d-M-Y');
                $treeKiri->poin = number_format($memberKiri->left_point, 0) . ' | ' . number_format($memberKiri->right_point, 0);
                $treeKiri->point_bonus = number_format($memberKiri->point_bonus, 0);
                $treeKiri->sponsor_bonus = number_format($memberKiri->sponsor_bonus, 0);
                $treeKiri->pair_bonus = number_format($memberKiri->pair_bonus, 0);

                $treeKiri->className = 'exist' . ($memberKiri->level_id == 2 ? ' gold' : '');
                $treeKiri->relationship = $this->getRelationshipValue($memberKiri);

                //$memberTree->leftDownline = $treeKiri;
                array_push($childs, $treeKiri);

                //$traverse($memberTree->leftDownline, $memberKiri);
                $traverse($treeKiri, $memberKiri);
            } else {
                //$memberTree->leftDownline = null;
                array_push($childs, $this->buildEmptyMember($treeKiri));
            }

            if ($kanan) {
                $memberKanan = Member::find($kanan);
                $treeKanan->id = $memberKanan->id;
                $treeKanan->code = $memberKanan->code;
                $treeKanan->username = $memberKanan->username;
                $treeKanan->name = $memberKanan->name;  //$memberKanan->username . ' - ' . $memberKanan->name;
                $treeKanan->parentId = $memberKanan->upline_id;
                $treeKanan->level = $memberKanan->tree_level;
                $treeKanan->level_id = $memberKanan->level_id;

                $treeKanan->pin = number_format($memberKanan->pin, 0);
                $treeKanan->bv = '25 BV';
                if (Carbon::parse($memberKanan->close_point_date) < Carbon::now())
                    $treeKanan->bv = '0 BV';
                $treeKanan->cpd = Carbon::parse($memberKanan->close_point_date)->format('d-M-Y');
                $treeKanan->poin = number_format($memberKanan->left_point, 0) . ' | ' . number_format($memberKanan->right_point, 0);
                $treeKanan->point_bonus = number_format($memberKanan->point_bonus, 0);
                $treeKanan->sponsor_bonus = number_format($memberKanan->sponsor_bonus, 0);
                $treeKanan->pair_bonus = number_format($memberKanan->pair_bonus, 0);

                $treeKanan->className = 'exist' . ($memberKanan->level_id == 2 ? ' gold' : '');
                $treeKanan->relationship = $this->getRelationshipValue($memberKanan);

                //$memberTree->rightDownline = $treeKanan;
                array_push($childs, $treeKanan);

                //$traverse($memberTree->rightDownline, $memberKanan);
                $traverse($treeKanan, $memberKanan);
            } else {
                //$memberTree->rightDownline = null;
                array_push($childs, $this->buildEmptyMember($treeKanan));
            }

            if (!$kiri && !$kanan)
                $childs = [];

            if (count($childs) > 0)
                $memberTree->children = $childs;

        };

        $traverse($down, $cm);    //$traverse($down, $team);

        return json_encode($down);
    }

    private function buildEmptyMember(MemberTree $tree)
    {
        $tree->id = 0;
        $tree->code = '-';
        $tree->username = '( Kosong )';
        $tree->name = '-';
        $tree->children = [];
        $tree->className = 'empty';
        return $tree;
    }

    private function getRelationshipValue(Member $member)
    {
        //check if have parent
        $first = '0';   //$member->upline_id ? '1' : '0';
        //$first = $member->hasParent() ? '1' : '0';

        $second = '0';
        if ($member->upline_id)
        {
            $siblings = $member->siblings()->get();
            $second = count($siblings) > 0 ? '1' : '0';
        }

        //$third = $member->hasChildren() ? '1' : 0;
        $third = $member->left_downline_id || $member->right_downline_id ? '1' : '0';

        return $first . $second . $third;
    }

    public function getTreeOld(Request $request) {
        $id = auth()->id();
        //$id = $request->id;

        $member = Member::find($id);
        $clean = $member->descendants()->pluck('id');

        /*$result = Member::where('id', '=', $id)->withDepth()
            ->having('depth', '<', '5')->get();
        $trees = $result->toTree();*/

        $my_teams = Member::descendantsAndSelf($id);
        $my_trees = $my_teams->toTree();

        $xxc = Member::with('descendants')->paginate(100);

        $ar = $my_teams->toArray();
        foreach ($my_trees as $my_tree) {
            $child = $my_tree->children;
            $a = '';
        }

        $cats = [];
        //$shops = Shop::get()->toTree();
        $traverse = function ($lists, $prefix = '-') use (&$traverse, &$cats) {
            foreach ($lists as $item) {
                $kiri = $item->getLft();
                $kanan = $item->getRgt();

                //$abcd = [];
                //$arr = $item->siblings()->get();
                //foreach ($arr as $aa) {
                //    array_push($abcd, $aa->toArray());
                //}

                if ($kiri) {
                    $_left = Member::where('id', '=', $kiri)->get();
                    $traverse($_left, $prefix.'-');
                } else {
                    array_push($cats, new \stdClass());
                }

                array_push($cats, $prefix.' '.$item->name);
                //$cats = PHP_EOL.$prefix.' '.$item->category_name;
                $traverse($item->children, $prefix.'-');
            }
        };
        $traverse($my_trees);

        $tree_level = 0; //$member->tree_level;
        $max_level = ($tree_level + 4);

        /*while ($tree_level <= $max_level) {
            $left = $member->leftDownLine();
            $right = $member->rightDownLine();
        }*/
    }

    public function rebuildTree()
    {
        /*
        $member = Member::find(2);

        $traverse = function ($member) use (&$traverse) {

            $kiri = $member->left_downline_id;
            $kanan = $member->right_downline_id;

            $level = intval($member->tree_level);
            echo 'member : '.$member->id.', level : '.$member->tree_level.', downline : '.$member->left_downline_id.' | '.$member->right_downline_id.'<br />';

            if ($kiri) {
                DB::statement('update members set tree_level = ' . ($level + 1) . ' where id = ' . $kiri);

                $memberKiri = Member::find($kiri);
                echo 'member kiri : '.$memberKiri->id.', level : '.$memberKiri->tree_level.', downline : '.$memberKiri->left_downline_id.' | '.$memberKiri->right_downline_id.'<br />';
                $traverse($memberKiri);
            }

            if ($kanan) {
                DB::statement('update members set tree_level = ' . ($level + 1) . ' where id = ' . $kanan);

                $memberKanan = Member::find($kanan);
                echo 'member kanan : '.$memberKanan->id.', level : '.$memberKanan->tree_level.', downline : '.$memberKanan->left_downline_id.' | '.$memberKanan->right_downline_id.'<br />';
                $traverse($memberKanan);
            }
        };

        $traverse($member);
        */

        /*
        $members = Member::where('id', '>', '1')->get();
        foreach ($members as $member) {
            $item = Member::find($member->upline_id);

            if ($item) {
                DB::statement('update members set tree_level = ' . (intval($item->tree_level) + 1) . ' where id = ' . $member->id);
            }
        }
        */

        $i = 4;
        $max = Member::max('tree_level');
        while ($i <= $max)
        {
            $members = Member::where('tree_level', '=', $i)->get();
            foreach ($members as $member) {
                if ($member->upline_id == null)
                    continue;

                $id = $member->id;
                $upline = Member::find($member->upline_id); //$member->upLine->fresh();
                //$upline->refresh();

                $pos = doubleval($upline->tree_position);

                $my_pos = 0;
                if ($id === $upline->left_downline_id)
                    $my_pos = ($pos * 2) - 1;
                elseif ($id === $upline->right_downline_id)
                    $my_pos = ($pos * 2);

                $member->tree_position = strval($my_pos);
                $member->save();
            }

            $i++;
        }

    }

}
