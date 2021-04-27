<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'subject_id',
        'subject_type'
    ];

    public function subject()
    {
        return $this->morphTo();
    }
}
