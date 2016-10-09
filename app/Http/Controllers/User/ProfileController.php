<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\User;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMy()
    {
        if(\Auth::user())
        {
            $user=User::where('name', '=', \Auth::user()['name'])->first();
            echo $user['name'];
            echo "<br/> has role Founder:".$user->hasRole('Founder');
            echo "<br/> has role Admin:".$user->hasRole('Admin');
            echo "<br/> user can manage_contents:".$user->can('manage_contents');   // false
            echo "<br/> user can manage_users:".$user->can('manage_users'); // true
        }
        else
        {
            echo "not log in";
        }
    }
}
