<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = "visitor";
    protected $fillable = [
        "ip_address",
        "iso_code",
        "country",
        "state",
        "city",
        "postal_code",
        "user_agent"
    ];
}
