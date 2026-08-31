<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'title',
        'category',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }


    public function images()
    {
        return $this->hasMany(PostImage::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
