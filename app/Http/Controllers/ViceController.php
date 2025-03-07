<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViceController extends Controller
{
    public function __construct()
    {
        $this->middleware('vicehead');
    }

    public function settings()
    {
        //Financial officers
        //$roleIds = DB::table('role_user')->where('role_id', 'financial_officer')->pluck('user_id');
        $roleIds = DB::table('group_user')->where('group_id', 'ekonomi')->pluck('user_id');
        $financialofficer = User::whereIn('id', $roleIds)->get();

        $roleId = DB::table('role_user')->where('role_id', 'vice_head')->pluck('user_id');
        $vicehead = User::find($roleId);

        return (new \Statamic\View\View)
            ->template('requests.vice.settings')
            ->layout('mylayout')
            ->with(['vice' => $vicehead, 'fos' => $financialofficer]);
    }
}
