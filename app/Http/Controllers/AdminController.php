<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\ProjectProposal;
use Illuminate\Http\Request;
use Workflow\WorkflowStub;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['web', 'auth', 'dsv']);
    }

    public function pp()
    {
        $viewData['proposals'] = ProjectProposal::where('status_stage3', '!=', 'pending')->paginate(5);
        $viewData['breadcrumb'] = 'Admin';
        return (new \Statamic\View\View)
            ->template('pp.admin.index')
            ->with($viewData)
            ->layout('mylayout');
    }

    public function pp_delete($id)
    {
        $proposal = ProjectProposal::find($id);
        $dashboard = Dashboard::where('request_id' ,$id)->first();
        $workflow = WorkflowStub::load($dashboard->workflow_id);

        return redirect()->back()->with('success', 'Your Project proposal has successfully been archived!');
    }
}
