<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    /**
     * @var string
     */
    protected $table = 'Role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
}
