<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    //use HasFactory;
    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
    ];


    // Default attributes (double-safety — migration already sets default)
    protected $attributes = [
        'status' => 'inactive',
    ];
}
