<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Channel extends Model
{
    public function getRouteKeyName()
    {
//        return parent::getRouteKeyName(); // TODO: Change the autogenerated stub
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
