<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credentials_request extends Model
{
    protected $fillable = ['user_id', 'login_credential_id'];

    // Relationships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function login_credential()
    {
        return $this->belongsTo('App\Login_credential');
    }
}
