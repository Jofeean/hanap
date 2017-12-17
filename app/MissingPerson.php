<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissingPerson extends Model
{
    protected $table = 'missings';
    protected $primaryKey = 'Missing_id';
}
