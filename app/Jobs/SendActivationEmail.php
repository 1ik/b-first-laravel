<?php

namespace App\Jobs;

use App\Mail\ActivationEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $userData;

    public function __construct($user)
    {
        $this->userData = $user;
    }


    public function handle(): void
    {
        Mail::to($this->userData->email)->send(new ActivationEmailNotification($this->userData));
    }
}
