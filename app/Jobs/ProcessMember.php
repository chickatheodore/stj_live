<?php

namespace App\Jobs;

use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class ProcessMember implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The member instance.
     *
     * @var Member
     */
    protected $member;
    protected $operation;

    /**
     * Create a new job instance.
     *
     * @param Member $member
     * @param $operation
     * @return void
     */
    public function __construct(Member $member, $operation)
    {
        $this->member = $member;
        $this->operation = $operation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ops = $this->operation;
        if ($ops == 'level')
            $this->processMemberLevel();
        else if ($ops == 'overdue')
            $this->processOverdueMember();
        else if ($ops == 'bonus')
            $this->processMemberBonus();
    }

    private function processMemberLevel()
    {
        //Pastikan user harus punya 1 poin biar bisa ditempatkan
        if (!$this->member->pin)
            return;

        //Mencari level untuk member baru, serta update jumlah member kiri atau kanan

        $upline = $this->member->upLine;
        $upline_level = $upline->tree_level;

        $this->member->tree_level = $upline_level++;

        while ($upline_level > 0) {

            //cari posisi member baru, kiri apa kanan
            if ($this->member->id == $upline->left_downline_id)
                $upline->left_downline_count++;
            else if ($this->member->id == $upline->right_downline_id)
                $upline->right_downline_count++;

            $upline->save();

            $upline = $upline->upLine;
            $upline_level = $upline->tree_level;
        }
    }

    private function processOverdueMember()
    {
        $this->member->left_bonus_point = 0;
        $this->member->right_bonus_point = 0;

        $this->member->left_bonus_partner = 0;
        $this->member->right_bonus_partner = 0;

        $this->member->save();
    }

    private function processMemberBonus()
    {
        //$this->member->level->point_value
    }

}
