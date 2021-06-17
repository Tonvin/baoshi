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

        $request->url = trim($request->url);
        if ( mb_strlen($request->url) > 2048 ) {
            return back()->withInput($request->all())->withErrors(['url' => __('link.url_length_illegal')]);
        }
        $request->title = trim($request->title);
        if ( mb_strlen($request->title) > 30 ) {
            return back()->withInput($request->all())->withErrors(['title' => __('link.title_length_illegal')]);
        }

        //access default is secret, value is 1.
        $access = 2 == $request->access ? 2 : 1;

        $result = self::sanitize_tags((string)$request->tags);
        if ( $result['flag'] == 1 ) {
            Link::where('id', $request->id)
            ->where('uid', $request->user()->id)
            ->update([
                'title' => trim($request->title),
                'url'   => trim($request->url),
                'tags'  => $result['tags'],
                'access'  => $access,
            ]);
            return redirect('/'.$request->user()->name.'/main');
        } else {
            return back()->withInput($request->all())->withErrors(['tags' => $result['detail']]);
        }
    }

    /**
     * sanitize tags
     * 
     * rules: explode tags by |,trim each tag.prepend | and append |
     *
     * eg. if tags like 'a||b  |  c|d|',after sanitized,it should be like '|a|b|c|d|'.
     *
     * @param $tags string user post tags
     * @return array
     */

    private function sanitize_tags(string $tags) : array {
        $back = array();
        $_tags = explode('|', $tags);

        //检测长度
        foreach ( $_tags ?? [] as &$t ) {
            $t = trim($t);
            if ( mb_strlen($t) > 10 ) {
                $back['flag'] = 2;
                $back['detail'] = __('link.single_tag_length_limit');
                return  $back;
            }
        }
        //tag去空
        $_tags = array_filter($_tags);

        //tag去重
        $_tags = array_unique($_tags);

        //检测tag数量
        if ( count($_tags) > 5 ) {
            $back['flag'] = 2;
            $back['detail'] = __('link.too_many_tags');
            return  $back;
        }

        $back['flag'] = 1;
        $back['tags'] = '|'.implode('|', $_tags).'|';                                                                                  
        return $back;
    }

    public function insert(Request $request)
    {
        $request->validate([
            'url' => 'required',
        ]);

        $link = new Link();
        $link->uid = $request->user()->id;
        $link->url = trim($request->url);
        if ( mb_strlen($link->url) > 2048 ) {
            return back()->withInput($request->all())->withErrors(['url' => __('link.url_length_illegal')]);
        }

        $link->title = trim($request->title);
        if ( mb_strlen($request->title) > 30 ) {
            return back()->withInput($request->all())->withErrors(['title' => __('link.title_length_illegal')]);
        }

        //access default is secret, value is 1.
        $link->access = 2 == $request->access ? 2 : 1;

        $result = self::sanitize_tags((string)$request->tags);
        if ( $result['flag'] == 1 ) {
            $link->tags = $result['tags'];
            $link->save();
            return redirect('/'.$request->user()->name.'/main');
        } else {
            return back()->withInput($request->all())->withErrors(['tags' => $result['detail']]);
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
        return redirect('/'.$request->user()->name.'/main');
    }

    public function list(Request $request)
    {
        if ( $name = $request->name ?? $request->user()->name ) {
            if ( $page = $request->page ?? 'main' ) {
                return redirect('/'.$name.'/'.$page);
            }
        }
        //return view('link/list', ['passport'=>$request->user()]);
    }

    public function tag(Request $request)
    {
        $user = new \stdClass();
        $user->name = $request->user()->name;
        $user->id = $request->user()->id;

        $link = new \stdClass();
        $link->user = $request->user;
        $link->page = $request->page;
        $link->tag = $request->tag;
        $link->url = "/".$link->user."/".$link->page."/".$link->tag;

        if ($request->isMethod('post')) {
            $links = [];
            if ( $name =  $request->user ) {
                $user = User::where('name', $name)->first();
                if ( $uid = $user->id ) {
                    $links = DB::table('links')->select('id', 'title', 'url', 'tags', 'created_at')
                                               ->where('uid', $uid)
                                               ->where('tags', 'like', '%|'.$link->tag.'|%')->get();
                    foreach ($links ?? [] as &$link) {
                        $link->tags = trim($link->tags, '|');
                        $link->url  = rtrim($link->url, '/');
                    }
                }
            }
            return response()->json($links);
        } else {
            return view('link/tag', ['link' => $link, 'user' => $user, 'passport'=>$request->user()]);
        }
    }

    public function page(Request $request)
    {
        $user = new \stdClass();
        $user->name = $request->user()->name;
        $user->id = $request->user()->id;

        $link = new \stdClass();
        $link->user = $request->user;
        $link->page = $request->page;
        $link->url = "/".$link->user."/".$link->page;
        if ( $link->tag = $request->tag ) {
            $link->url .= "/".$link->tag;
        }

        if ($request->isMethod('post')) {
            $links = [];
            if ( $name =  $request->user ) {
                $user = User::where('name', $name)->first();
                if ( $uid = $user->id ) {
                    if ( $link->tag ) {
                        $links = DB::table('links')->select('id', 'title', 'url', 'tags', 'created_at')
                                               ->where('uid', $uid)
                                               ->where('tags', 'like', '%|'.$link->tag.'|%')->get();
                    } else {
                        $links = DB::table('links')->select('id', 'title', 'url', 'tags', 'created_at')
                                                   ->where('uid', $uid)->get();
                    }
                    foreach ($links ?? [] as &$link) {
                        $link->tags = trim($link->tags, '|');
                        $link->url  = rtrim($link->url, '/');
                    }
                }
            }
            return response()->json($links);
        } else {
            return view('link/page', ['link' => $link, 'user' => $user, 'passport'=>$request->user()]);
        }
    }

    public function ___tag(Request $request)
    {
        $name = $request->name ?? $request->user()->name;

        $link = new \StdClass();
        $link->user = $request->name;
        $link->page = $request->page;
        $link->tag = $request->tag;

        return view('link/list', ['link' => $link, 'name' => $name, 'passport'=>$request->user()]);
    }

    public function index(Request $request)
    {
        if ( $user = $request->user()->name ) {
            if ( $page = $request->page ?? 'main' ) {
                return redirect("/$user/$page");
            }
        } else {
            echo 248;exit;
                return redirect("/login");
        }
        //return view('', ['name'=>$name, 'passport' => $request->user()]);
    }
}
