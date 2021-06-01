<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;


class LinkController extends Controller
{
    public function add(Request $request)
    {
        return view('add');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);

        $link = new Link();
        $link->url = $request->url;
        $link->save();
        //back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
        return redirect()->route('add');
    }
}
