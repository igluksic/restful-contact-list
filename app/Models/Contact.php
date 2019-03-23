<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = ['user_id' ,'first_name', 'last_name', 'profile_photo', 'email', 'favourite'];

    public function phones()
    {
        return $this->hasMany(Phone::class, 'contact_id', 'id');
    }
}
