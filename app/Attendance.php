<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table = "attendance";
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(AttendanceUser::class, 'id_attendance', 'id');
    }
}
