<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    /**
     * @var string
     */
    protected $table = 'Country';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'short'
    ];
}
