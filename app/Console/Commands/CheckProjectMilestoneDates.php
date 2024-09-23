<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;
use Carbon\Carbon;

class CheckProjectMilestoneDates extends Command
{
    protected $signature = 'check:dates';
    protected $description = 'Check milestones and project dates and send notifications if needed';

    protected $pusher;

    public function __construct()
    {
        parent::__construct();
        $this->pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true,
            ]
        );
    }

    public function handle()
    {

        // Vérifier les milestones
        $milestones = Milestone::whereDate('date_echeance', '<=', now())->get();
        foreach ($milestones as $milestone) {
            $this->sendNotification("Le milestone {$milestone->name} est arrivé à échéance.");
        }

        // Vérifier les projets
        $projects =  Project::whereDate('end_date', '<=', now())->get();
        foreach ($projects as $project) {
            $this->sendNotification("Le projet {$project->name} est arrivé à sa date de fin.");
        }

        Log::info('Milestones trouvés: ', $milestones->toArray());
        Log::info('Projects trouvés: ', $projects->toArray());

    }

    protected function sendNotification($message)
    {
        $this->pusher->trigger('notifications', 'notification', ['message' => $message]);
    }
}

