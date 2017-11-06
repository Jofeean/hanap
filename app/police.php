<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class police extends Model
{
    protected $table = 'polices';
    protected $hidden = 'Police_password';
}
