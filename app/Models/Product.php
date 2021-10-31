<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    const IMAGE_PATH = '/images';
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y h:m:s',
        'updated_at' => 'datetime:d/m/Y h:m:s',
    ];
    protected $appends = [
        'video_url'
    ];


    public function getVideoUrlAttribute()
    {
        return url('storage') . self::IMAGE_PATH . '/' . $this->video;
    }
}
