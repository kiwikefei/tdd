<?php
namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    /**
     * @param $username
     * @return mixed
     * @internal param $builder
     */
    protected $filters = ['by', 'popular'];

    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    protected function popular()
    {
        // remove the existing orderBy (by Thread::latest())
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

}