<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'completed',
        'deadline'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // キーワードを含むタスクに絞り込む
    public function scopeSearchWord($query, $word)
    {
        return $query->where('title', 'like', '%'.$word.'%')
                    ->orWhere('description', 'like', '%'.$word.'%');
    }

    public function scopeStatus($query, $status)
    {
        if(is_Null($status)) {
            return;
        }

        if($status == 0 || $status == 1) {
            return $query->where('completed', $status);
        }
    }

    public function scopeOrderByUpdated($query, $sort)
    {
        return $query->orderBy('updated_at', $sort);
    }

}
