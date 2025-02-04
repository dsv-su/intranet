<?php

namespace App\Workflows\Notifications;

use App\Mail\NotifyFONewProjectProposal;
use App\Mail\NotifyHeadNewProjectProposal;
use App\Mail\NotifyViceNewProjectProposal;
use App\Models\Dashboard;
use App\Models\HeadGroup;
use App\Models\ProjectProposal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Workflow\Activity;

class NewProjectProposalNotification extends Activity
{
    protected Dashboard $dashboard;
    protected ProjectProposal $proposal;

    public function execute(string $recipient, int $request): void
    {
        $this->loadDashboard($request);
        $this->loadPP($this->dashboard->request_id);
        $users = $this->loadUsers();

        // Send email based on recipient type
        $this->sendNotification($recipient, $users);

    }

    private function loadDashboard(int $id): void
    {
        $this->dashboard = Dashboard::findOrFail($id);
    }

    private function loadPP(string $uuid): void
    {
        $this->proposal = ProjectProposal::findOrFail($uuid);
    }

    private function loadUsers(): array
    {
        // Check if there are multiple unitheads in request
        if($this->proposal->pp['unit_heads_to_approve'] > 1) {
            // Fetch all relevant users for multiple heads
            $this->head_group = HeadGroup::where('request_id', $this->proposal->id)->first();

            $userIds = array_merge([
                $this->dashboard->user_id,
                $this->dashboard->fo_id,
                $this->getViceHeadUserId(),
            ], $this->head_group->unit_heads);
        } else {
            // Fetch all relevant users
            $userIds = [
                $this->dashboard->user_id,
                $this->dashboard->fo_id,
                $this->dashboard->head_id,
                $this->getViceHeadUserId(),
            ];
        }



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
