<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Yajra\Datatables\Facades\Datatables;


class LinkController extends Controller
{
    public function add(Request $request)
    {
        return view('link/add');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);

        $link = new Link();
        $link->url = $request->url;
        $link->title = $request->title;
        $link->tags = $request->tags;
        $link->save();
        //back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
        return redirect()->route('list');
    }


    public function select(Request $request)
    {
        $link = new Link();
        $links = $link::all();
        return response()->json($links);
    }

    public function del(Request $request)
    {
        $link = Link::find(intval($request->id));
        $link->delete();
        return redirect()->route('list');
    }

    public function list(Request $request)
    {
        return view('link/list');
    }
}
