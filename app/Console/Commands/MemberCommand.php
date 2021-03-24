<?php

namespace App\Console\Commands;

use App\Jobs\ProcessMember;
use App\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class MemberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild member tree level and member downline counts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*
         * Mencari posisi pada tree pada member baru
         * beserta update jumlah member pada uplink sampai level ke satu
         */
        $new_members = Member::where('tree_level', '=', 0);
        foreach ($new_members as $member) {
            dispatch(new ProcessMember($member, 'level'));
        }

        /*
         * Mencari member yang masa TUPO sudah lewat
         */
        $overdue_members = Member::where('close_point_date', '<', Carbon::now()->format('Y-m-d'));
        foreach ($overdue_members as $overdue_member) {
            dispatch(new ProcessMember($overdue_member, 'overdue'));
        }
    }
}
