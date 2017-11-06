<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\missing;

class police extends Controller
{
    public function missings()
    {

        if (session('priv') == 'police') {
            $users = new user;
            $data['users'] = $users->get();
            $users = new missing;
            $data['missings'] = $users->orderBy('Missing_fname', 'asc')->get();
            return view('police.missings', $data);
        }
        return redirect('/');
    }
}
