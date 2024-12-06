<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_profile';

    public function modulos()
    {
        return $this->hasManyThrough(
            Module::class,
            Profile_Module::class,
            'id_profile',
            'id',
            'id_profile',
            'id_module'
        );
    }
}
