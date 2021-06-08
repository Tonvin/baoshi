<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Link;
use App\Models\User;


class LinkController extends Controller
{
    public function add(Request $request)
    {
        return view('link/add', ['passport'=>$request->user()]);
    }

    public function edit(Request $request)
    {
        $link = Link::find($request->id);
        return view('link/edit', ['link' => $link]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'url' => 'required',
            'id' => 'required',
        ]);

        $link = Link::find($request->id);
        $link->url = trim($request->url);
        $link->title = $request->title;
        $link->tags = self::format_tags((string)$request->tags);
        $link->save();
        //back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
        return redirect('/link/list')->with('status', '修改成功');

    }

    /**
     * format tags
     * 
     * rules: explode tags by |,trim each tag.prepend | and append |
     *
     * eg. if tags like 'a||b  |  c|d|',after formatted,it should be like '|a|b|c|d|'.
     *
     * @param $tags string user post tags
     * @return string or null
     */

    private function format_tags(string $tags) : string {
        if ( $tags ) {                  
            $_tags = explode('|', $tags);
            $_tags = array_map(function($tag){return trim($tag);}, $_tags);
            $_tags = array_filter($_tags);
            return '|'.implode('|', $_tags).'|';                                                                                  
        }
        return '';
    }

    public function insert(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);

        $link = new Link();
        $link->uid = $request->user()->id;
        $link->url = trim($request->url);
        $link->title = $request->title;
        $link->tags = self::format_tags($request->tags);
        $link->save();
        //back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
        return redirect('/'.$request->user()->name.'/main');
    }


    public function select(Request $request)
    {
        $name = $request->name ?? $request->user()->name;
        if ( $name =  $request->name ) {
            $user = User::where('name', $name)->first();
            $uid = $user->id;
        } else if ( $name = $request->user()->name ) {
            $uid = $request->user()->id;
        }
        $links = DB::table('links')->select('id', 'title', 'url', 'tags', 'created_at')->where('uid', $uid)->get();
        foreach ($links ?? [] as &$link) {
            $link->tags = trim($link->tags, '|');
            $link->url  = rtrim($link->url, '/');
        }
        return response()->json($links);
    }

    public function del(Request $request)
    {
        $link = Link::find($request->id);
        $link->delete();
        return redirect('/'.$request->user()->name.'/main');
    }

    public function list(Request $request)
    {
        return view('link/list', ['passport'=>$request->user()]);
    }

    public function main(Request $request)
    {
        $name = $request->name ?? $request->user()->name;
        return view('link/list', ['name'=>$name, 'passport' => $request->user()]);
    }
}
