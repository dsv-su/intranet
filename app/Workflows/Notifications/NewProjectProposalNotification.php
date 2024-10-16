<?php

namespace App\Workflows\Notifications;

use App\Mail\NotifyFONewProjectProposal;
use App\Mail\NotifyHeadNewProjectProposal;
use App\Mail\NotifyViceNewProjectProposal;
use App\Models\Dashboard;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Workflow\Activity;

class NewProjectProposalNotification extends Activity
{
    protected Dashboard $dashboard;

    public function execute(string $recipient, int $request): void
    {
        $this->loadDashboard($request);
        $users = $this->loadUsers();

        // Send email based on recipient type
        $this->sendNotification($recipient, $users);

    }

    private function loadDashboard(int $id): void
    {
        $this->dashboard = Dashboard::findOrFail($id);
    }

    private function loadUsers(): array
    {
        // Fetch all relevant users
        $userIds = [
            $this->dashboard->user_id,
            $this->dashboard->fo_id,
            $this->dashboard->head_id,
            $this->getViceHeadUserId(),
        ];

        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        return [
            'user' => $users[$this->dashboard->user_id],
            'fo' => $users[$this->dashboard->fo_id],
            'head' => $users[$this->dashboard->head_id],
            'vice' => $users[$this->getViceHeadUserId()],
        ];
    }

    private function getViceHeadUserId(): string
    {
        return DB::table('role_user')
            ->where('role_id', 'vice_head')
            ->value('user_id');
    }

    private function sendNotification(string $recipient, array $users): void
    {
        $emailData = [$users['user'], $users['head'], $users['vice'], $this->dashboard];

        switch ($recipient) {
            case 'head':
                Mail::to($users['head']->email)->send(new NotifyHeadNewProjectProposal(...$emailData));
                break;
            case 'vice':
                Mail::to($users['vice']->email)->send(new NotifyViceNewProjectProposal(...$emailData));
                break;
            case 'fo':
                Mail::to($users['fo']->email)->send(new NotifyFONewProjectProposal(...$emailData));
                break;
            default:
                throw new InvalidArgumentException("Invalid recipient type: $recipient");
        }
    }

}
