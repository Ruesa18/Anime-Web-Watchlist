<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    /**
     * @var string
     */
    protected $table = 'Permission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];
}
