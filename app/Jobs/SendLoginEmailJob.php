<?php

namespace App\Jobs;

use App\Mail\SendLoginEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLoginEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $email; // Email address to send to
    protected $data;  // Any additional data for the email

    /**
     * Create a new job instance.
     */
    public function __construct($email, $data = [])
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Queue the email
        Mail::to($this->email)->queue(new SendLoginEmail($this->data));
    }
}