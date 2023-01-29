<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $table = "information";
    protected $fillable = [
        "email",
        "telepon",
        "facebook",
        "instagram",
        "youtube",
        "whatsapp",
        "about",
        "product_price"
    ];

    public $incrementing = false;

    public function about_images()
    {
        return $this->hasMany(AboutImage::class, 'company_id');
    }
}
