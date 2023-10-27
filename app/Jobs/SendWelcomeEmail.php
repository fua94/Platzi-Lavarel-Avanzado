<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $userEmail;

    public function __construct(string $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function handle()
    {
        $mail = new WelcomeEmail();
        Mail::to($this->userEmail)->send($mail);
    }
}
