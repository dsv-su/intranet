<?php
namespace App\Services\Review;

use App\Models\Dashboard;
use App\Models\FoComment;
use App\Models\HeadComment;
use App\Models\ManagerComment;
use App\Models\TravelRequest;
use App\Models\User;

class RequestReviewHandler
{
    protected $dashboard;
    protected $reviewer;
    protected $comment;
    protected $workflowhandler;

    public function __construct(Dashboard $dashboard, User $reviewer, $comment)
    {
        $this->dashboard = $dashboard;
        $this->reviewer = $reviewer;
        $this->comment = $comment;
        $this->workflowhandler = new WorkflowHandler($this->dashboard->request_id);
    }

    public function review()
    {
        $this->register_comment();
    }

    private function register_comment()
    {
        //Register comment
        switch($this->dashboard->type) {
            case('travelrequest'):
                $tr = TravelRequest::find($this->dashboard->id);
                switch($this->getRole()) {
                    case('manager'):
                        $comment = $this->manager_comment('travelrequest', $tr->id, $this->reviewer->id, $this->comment);
                        $tr->manager_comment_id = $comment->id;
                        $this->workflowhandler->ManagerApprove();
                        break;
                    case('fo'):
                        $comment = $this->fo_comment('travelrequest', $tr->id, $this->reviewer->id, $this->comment);
                        $tr->fo_comment_id = $comment->id;
                        $this->workflowhandler->FOApprove();
                        break;
                    case('head'):
                        $comment = $this->head_comment('travelrequest', $tr->id, $this->reviewer->id, $this->comment);
                        $tr->head_comment_id = $comment->id;
                        $this->workflowhandler->HeadApprove();
                        break;
                }
                $tr->save();
        }
    }

    private function getRole()
    {
        switch ($this->dashboard->state) {
            case('submitted'):
                if($this->dashboard->manager_id == $this->reviewer->id) {
                    $role = 'manager';
                }
                break;
            case('manager_approved'):
                if ($this->dashboard->fo_id == $this->reviewer->id) {
                    $role = 'fo';
                }
                break;
            case('fo_approved'):
                if ($this->dashboard->head_id == $this->reviewer->id) {
                    $role = 'head';
                }

        }
        return $role;
    }

    private function manager_comment($type, $req_id, $role_id, $comment)
    {
        switch($type) {
            case('travelrequest'):
                $id = ManagerComment::create([
                    'reqid' => $req_id,
                    'user_id' => $role_id,
                    'comment' => $comment
                ]);
                break;
        }
        return $id;
    }

    private function fo_comment($type, $req_id, $role_id, $comment)
    {
        switch($type) {
            case('travelrequest'):
                $id = FoComment::create([
                    'reqid' => $req_id,
                    'user_id' => $role_id,
                    'comment' => $comment
                ]);
                break;
        }
        return $id;
    }

    private function head_comment($type, $req_id, $role_id, $comment)
    {
        switch($type) {
            case('travelrequest'):
                $id = HeadComment::create([
                    'reqid' => $req_id,
                    'user_id' => $role_id,
                    'comment' => $comment
                ]);
                break;
        }
        return $id;
    }

}
