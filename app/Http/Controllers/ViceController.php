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
        $roleId = DB::table('role_user')->where('role_id', 'vice_head')->pluck('user_id');
        $vicehead = User::find($roleId);

        return (new \Statamic\View\View)
            ->template('requests.vice.settings')
            ->layout('mylayout')
            ->with(['vice' => $vicehead]);
    }
}
