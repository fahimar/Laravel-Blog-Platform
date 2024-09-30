<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    protected $with = ['user'];

    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commends(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Commend::class);
    }

}
