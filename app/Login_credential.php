<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login_credential extends Model
{
    protected $fillable = ['user_id', 'project_id', 'service_id', 'username', 'password'];

    // Relationships
    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
