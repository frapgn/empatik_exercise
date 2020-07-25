<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id', 'name'];

    // Relationships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function login_credentials()
    {
        return $this->hasMany('App\Login_credential');
    }
}
