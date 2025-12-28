<?php

namespace App\Console\Commands;

use App\Models\Rappel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\RappelEmail;

class SendReminderEmails extends Command
{
    protected $signature = 'rappels:send';
    protected $description = 'Envoie les emails de rappel programmés';

    public function handle()
    {
        $rappels = Rappel::where('envoye', false)
            ->where('date_rappel', '<=', now()->addHour())
            ->with(['user', 'vehicule'])
            ->get();

        foreach ($rappels as $rappel) {
            try {
                Mail::to($rappel->user->email)
                    ->send(new RappelEmail($rappel));
                
                $rappel->update(['envoye' => true]);
                $this->info("Rappel envoyé à {$rappel->user->email}");
            } catch (\Exception $e) {
                $this->error("Erreur lors de l'envoi du rappel: " . $e->getMessage());
            }
        }

        $this->info('Tous les rappels ont été traités.');
    }
}