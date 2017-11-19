<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
//        Approach 1:   => use DB Facade
//        \DB::table('favorites')->insert([
//            'user_id'   => auth()->id(),
//            'favorited_id'   => $reply->id,
//            'favorited_type'  =>  get_class($reply),
//        ]);

//        Approach 2    => use dedicate pivot table Model 'Favorite'
//        Favorite::create([
//            'user_id'   => auth()->id(),
//            'favorited_id'   => $reply->id,
//            'favorited_type'  =>  get_class($reply),
//        ]);

//        Approach 3    => use Model's polymorphism relationship 'favorites'
//        $reply->favorites()->create([
//            'user_id'   => auth()->id()
//        ]);

//        Approach 4    => use Model behavior
        return $reply->favorite();
    }
}
