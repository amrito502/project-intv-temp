<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RankUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $user = 3;
    protected $ranks;

    public function __construct($user, $ranks)
    {
        $this->user = $user;
        $this->ranks = $ranks;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get user hand points
        $hand1 = $this->user->downLevelAllReferWhereRankIsMemberPoint(1);
        $hand2 = $this->user->downLevelAllReferWhereRankIsMemberPoint(2);
        $hand3 = $this->user->downLevelAllReferWhereRankIsMemberPoint(3);

        // compare hand points with rank
        $selectedRank = $this->ranks->where('requirements.1', '<=', $hand1)
            ->where('requirements.2', '<=', $hand2)
            ->where('requirements.3', '<=', $hand3)->first();

        if (!$selectedRank) {
            return true;
        }

        // update user rank
        if ($this->user->rank == $selectedRank['name']) {
            return true;
        }

        $currentRank = $this->ranks->where('name', $this->user->rank)->first();

        if ($currentRank) {
            if ($currentRank['sl'] > $selectedRank['sl']) {
                return true;
            }
        }

        $this->user->rank = $selectedRank['name'];
        $this->user->rank_date = date('Y-m-d H:i:s');

        $this->user->save();
    }
}
