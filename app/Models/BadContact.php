<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadContact extends Model
{
    use HasFactory;

    protected $table = 'bad_contacts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'reason',
        'source',
        'batch',
    ];

}
