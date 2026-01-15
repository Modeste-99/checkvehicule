<?php

namespace App\Jobs;

use App\Mail\RappelEmail;
use App\Models\Rappel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRappelEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Rappel $rappel)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Envoyer l'email au user
        Mail::to($this->rappel->user->email)->send(new RappelEmail($this->rappel));

        // Marquer le rappel comme envoyé
        $this->rappel->update(['envoye' => true]);
    }
}
