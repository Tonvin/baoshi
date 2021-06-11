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
        $link = Link::where(['id' => $request->id, 'uid' => $request->user()->id])->first();
        if ( null != $link ) {
            return view('link/edit', ['link' => $link ,'passport'=>$request->user()]);
        } else {
            return redirect('/user/'.$request->user()->name.'/page/main');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'url' => 'required',
            'id' => 'required',
        ]);

        $tags = self::format_tags((string)$request->tags);
        if ( false === $tags ) {
            return back()->withInput()->withErrors(['tags' => __('link.too_many_tags')]);
        } else {
            Link::where('id', $request->id)
                ->where('uid', $request->user()->id)
                ->update([
                    'title' => trim($request->title),
                    'url'   => trim($request->url),
                    'tags'  => $tags,
                ]);
            return redirect('/user/'.$request->user()->name.'/page/main');
        }
    }

    /**
     * format tags
     * 
     * rules: explode tags by |,trim each tag.prepend | and append |
     *
     * eg. if tags like 'a||b  |  c|d|',after formatted,it should be like '|a|b|c|d|'.
     *
     * @param $tags string user post tags
     * @return string | boolean
     */

    private function format_tags(string $tags) {
        if ( $tags ) {                  
            $_tags = explode('|', $tags);
            $_tags = array_map(function($tag){return trim($tag);}, $_tags);
            $_tags = array_filter($_tags);
            if ( count($_tags) > 5 ) {
                return false;
            }
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
        if ( false === $link->tags ) {
            return back()->withInput()->withErrors(['tags' => __('link.too_many_tags')]);
        } else {
            $link->save();
            return redirect('/user/'.$request->user()->name.'/page/main');
        }
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

    /**
     * Delete a link.
     */
    public function del(Request $request)
    {
        $link = Link::where(['id' => $request->id, 'uid' => $request->user()->id])->first();
        if ( null != $link ) {
            $link->delete();
        }
        //while link deleted,redirect to page main.
        return redirect('/user/'.$request->user()->name.'/page/main');
    }

    public function list(Request $request)
    {
        if ( $name = $request->name ?? $request->user()->name ) {
            if ( $page = $request->page ?? 'main' ) {
                return redirect('/user/'.$name.'/page/'.$page);
            }
        }
        //return view('link/list', ['passport'=>$request->user()]);
    }

    public function page(Request $request)
    {
        $name = $request->name ?? $request->user()->name;
        return view('link/list', ['name' => $name, 'passport'=>$request->user()]);
    }

    public function index(Request $request)
    {
        if ( $name = $request->name ?? $request->user()->name ) {
            if ( $page = $request->page ?? 'main' ) {
                return redirect('/user/'.$name.'/page/'.$page);
            }
        }
        //return view('', ['name'=>$name, 'passport' => $request->user()]);
    }
}
