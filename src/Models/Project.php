<?php

namespace Makkapoya\PayUz\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use SoftDeletes;

    const NOT_ACTIVE = 0;
    const ACTIVE = 1;

    protected $dates    = [
        'deleted_at'
    ];
}