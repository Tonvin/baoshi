<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class UserController extends Controller
{
    public function index(Request $request)
    {
        if ( $request->user() ) {
            if ( $user = $request->user()->name ) {
                if ( $page = $request->page ?? 'main' ) {
                    return redirect("/$user/$page");
                }
            }
        }
        return redirect()->route('login');
    }
}
