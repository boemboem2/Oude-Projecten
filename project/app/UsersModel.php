<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    //
    protected $table = 'users_profiles';

    protected $fillable = ['name', 'category', 'description', 'specialities', 'gender', 'qtitles', 'qualifications', 'photo', 'phone', 'fax', 'email', 'address', 'city', 'website', 'featured', 'status'];
    public static $withoutAppends = false;

    public function getQualificationsAttribute($qualifications)
    {
        if ($qualifications != ""){
            return explode(',', $qualifications);
        }
        return $qualifications;
    }

    public function getQtitlesAttribute($qtitles)
    {
        if ($qtitles != ""){
            return explode(',', $qtitles);
        }
        return $qtitles;
    }

    public function getSpecialitiesAttribute($specialities)
    {
        if(self::$withoutAppends){
            return $specialities;
        }
        return explode(',', $specialities);
    }

}
