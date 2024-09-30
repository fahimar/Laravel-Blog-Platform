<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commend extends Model
{
    use HasFactory,SoftDeletes;

    protected $with = ['user','children'];

    protected $fillable = [
        'user_id',
        'post_id',
        'message',
    ];

    public function parent()
    {
        return $this->belongsTo($this::class, 'commend_id');
    }

    public function children()
    {
        return $this->hasMany($this::class, 'commend_id');

    }
        public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
