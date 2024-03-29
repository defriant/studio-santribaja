<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutImage extends Model
{
    use HasFactory;

    protected $table = 'about_image';

    protected $fillable = [
        'company_id',
        'filename'
    ];

    public function about()
    {
        return $this->belongsTo(Information::class);
    }
}
