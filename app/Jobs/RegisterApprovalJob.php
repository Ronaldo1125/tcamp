<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\UserRegisterApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class RegisterApprovalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sentTo, $content;
    /**
     * Create a new job instance.
     */
    public function __construct($sentTo, $content)
    {
        $this->sentTo = $sentTo;
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->sentTo)->send(new UserRegisterApproved($this->content));
    }
}
