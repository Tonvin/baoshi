<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Link;
use App\Models\User;


class SettingController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        return view('link/page-setting', ['page'=>$request->page, 'user' => $user, 'passport'=>$request->user()]);
    }

    public function update(Request $request)
    {
        $uid = Auth::id();
        $user  = Auth::user();
        $request->validate([
            'page' => 'required',
            'old_page' => 'required',
        ]);

        $request->page = trim($request->page);
        if ( mb_strlen($request->page) > 30 ) {
            return back()->withInput($request->all())->withErrors(['page' => __('link.page_name_too_long')]);
        }
        if ( $request->old_page == $request->page ) {
            return back()->withInput($request->all())->withErrors(['page' => __('link.page_name_not_changed')]);
        }
        Link::where('page', $request->old_page)->where('uid', $uid)->update(['page' => trim($request->page)]);
        return redirect("/$user->name/".$request->page);
    }

}
