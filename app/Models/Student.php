<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'admission_number',
        'class',
        'section',
        'roll_number',
        'date_of_birth',
        'gender',
        'blood_group',
        'admission_details',
        'transport_details',
        'nationality',
        'religion',
        'mother_tongue',
        'aadhar_number',
        'address',
        'emergency_contact_number',
        'father_details',
        'mother_details',
        'sibling_details',
    ];

    public function parents()
    {
        return $this->hasMany('User');
    }
}
