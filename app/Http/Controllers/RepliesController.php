<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    //
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(),[
            'body'  =>  'required'
        ]);
        $thread->addReply([
            'body'      => request('body'),
            'user_id'   => auth()->id(),
        ]);
        return redirect($thread->path());
    }
}
