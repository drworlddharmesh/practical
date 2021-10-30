<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    const IMAGE_PATH = '/images';
    protected $table = 'shops';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:m:s',
        'updated_at' => 'datetime:d/m/Y h:m:s',
    ];
    protected $appends = [
        'image_url'
    ];


    public function getImageUrlAttribute()
    {
        return url('storage') . self::IMAGE_PATH . '/' . $this->image;
    }
}
