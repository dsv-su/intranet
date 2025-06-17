<?php

namespace App\Jobs;

use App\Mail\RegistratorFinalApproval;
use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFinalToRegistrator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user, $dashboard, $filePath;

    public function __construct($user, $dashboard, $filePath)
    {
        $this->user = $user;
        $this->dashboard = $dashboard;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //Registrator
        Mail::to('registrator@dsv.su.se')->send(new RegistratorFinalApproval($this->user,  $this->dashboard, $this->filePath));

        //Vice
        Mail::to('panagiotis@dsv.su.se')->send(new RegistratorFinalApproval($this->user,  $this->dashboard, $this->filePath));
    }
}
