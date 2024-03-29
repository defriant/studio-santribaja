<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    use HasFactory;

    protected $table = 'mailbox';
    protected $fillable = [
        "name",
        "phone",
        "email",
        "message",
        "is_read"
    ];
}
