<?php

namespace App\Providers;

use App\Idea;
use App\User;
use App\DesignTask;
use App\Proposal;
use XMovement\Poll\Poll;
use XMovement\Contribution\Contribution;

use App\Policies\IdeaPolicy;
use App\Policies\UserPolicy;
use App\Policies\DesignTaskPolicy;
use App\Policies\PollPolicy;
use App\Policies\ContributionPolicy;
use App\Policies\ProposalPolicy;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Idea::class => IdeaPolicy::class,
        User::class => UserPolicy::class,
        DesignTask::class => DesignTaskPolicy::class,
        Poll::class => PollPolicy::class,
        Contribution::class => ContributionPolicy::class,
        Proposal::class => ProposalPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
