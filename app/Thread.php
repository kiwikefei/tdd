<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Thread extends Model
{
    //
    public function path()
    {
        return "/threads/{$this->id}";
    }
}
