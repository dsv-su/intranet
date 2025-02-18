<?php

namespace App\Traits;

use App\Models\Dashboard;

trait DashboardIndicator
{
    public function DashboardIndicator($user)
    {
        //travelrequest
        $manager = collect(Dashboard::where('state', 'submitted')->where('manager_id', $user)->get());
        $head = collect(Dashboard::where('state', 'manager_approved')->where('head_id', $user)->get());
        $fo = collect(Dashboard::where('state', 'head_approved')->where('fo_id', $user)->get());
        //pp
        //$head_pp = collect(Dashboard::where('state', 'submitted')->where('head_id', $user)->where('type', 'projectproposal')->get());
        $head_pp = collect(Dashboard::where('state', 'submitted')->where('type', 'projectproposal')->whereJsonContains('unit_head_approved', [$user => 0])->get());
        $vice_pp = collect(Dashboard::where('state', 'head_approved')->where('vice_id', $user)->where('type', 'projectproposal')->get());
        $fo_pp = collect(Dashboard::where('state', 'vice_approved')->where('fo_id', $user)->where('type', 'projectproposal')->get());

        //User
        $manager_return = collect(Dashboard::where('state', 'manager_returned')->where('user_id', $user)->where('status', 'unread')->get());
        $manager_deny = collect(Dashboard::where('state', 'manager_denied')->where('user_id', $user)->where('status', 'unread')->get());
        $fo_return = collect(Dashboard::where('state', 'fo_returned')->where('user_id', $user)->where('status', 'unread')->get());
        $fo_deny = collect(Dashboard::where('state', 'fo_denied')->where('user_id', $user)->where('status', 'unread')->get());
        $head_return = collect(Dashboard::where('state', 'head_returned')->where('user_id', $user)->where('status', 'unread')->get());
        $head_deny = collect(Dashboard::where('state', 'head_denied')->where('user_id', $user)->where('status', 'unread')->get());
        $vice_return = collect(Dashboard::where('state', 'vice_returned')->where('user_id', $user)->where('status', 'unread')->get());
        $vice_deny = collect(Dashboard::where('state', 'vice_denied')->where('user_id', $user)->where('status', 'unread')->get());
        $approved = collect(Dashboard::where('state', 'fo_approved')->where('user_id', $user)->where('status', 'unread')->get());

        return $manager->merge($fo)->merge($head)
            ->merge($head_pp)->merge($vice_pp)->merge($fo_pp)
            ->merge($manager_return)->merge($manager_deny)
            ->merge($fo_return)->merge($fo_deny)
            ->merge($head_return)->merge($head_deny)
            ->merge($vice_return)->merge($vice_deny)->merge($approved);
    }
}
