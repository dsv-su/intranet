<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Statamic\View\View;

class ProjectProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web', 'auth', 'dsv']);

    }

    public function my_pp()
    {
        return (new \Statamic\View\View)
            ->template('pp.index')
            ->layout('mylayout');
    }

    public function all_pp()
    {
        return (new \Statamic\View\View)
            ->template('pp.all_projects')
            ->layout('mylayout');
    }

    public function create()
    {
        $viewData = $this->prepareProjectProposalData();
        $viewData['type'] = 'create';

        return $this->createView('pp.create', 'mylayout', $viewData);
    }

    public function submit(Request $request)
    {
        dd($request->all());
    }

    private function prepareProjectProposalData()
    {
        $roleIdsUnitHead = $this->getUserIdsByGroup('enhetschef');
        $unitheads = User::whereIn('id', $roleIdsUnitHead)->get();

        return [
            'unitheads' => $unitheads,
        ];
    }

    private function getUserIdsByGroup($group)
    {
        return DB::table('group_user')->where('group_id', $group)->pluck('user_id');
    }

    private function createView($template, $layout, $data)
    {
        return (new View)->template($template)->layout($layout)->with($data);
    }
}
