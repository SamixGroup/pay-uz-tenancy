<?php

namespace Makkapoya\PayUz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    public function getTable(){
        return  config('payuz.db_prefix'). parent::getTable();
    }
}