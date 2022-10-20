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

    // タスクの状態が完了か未完了かで絞り込む
    public function scopeCompleted($query, $status)
    {
        // 未完了タスク
        if($status == 'yet') {
            return $query->where('completed', 0);
        }

        // 完了タスク
        if($status == 'done') {
            return $query->where('completed', 1);
        }
        return;
    }

    // 更新日の古い順、新しい順で並べかえる
    public function scopeOrderByUpdated($query, $sort)
    {
        if($sort == 'asc') {
            return $query->orderBy('updated_at', 'asc');
        }
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeDeadline($query, $deadline)
    {
        // 期限を過ぎたタスクのみに絞り込み
        if($deadline == 'past') {
            return $query->where('deadline', '<', now());
        }
        // 期限がまだ過ぎていないタスクのみに絞り込み
        if($deadline == 'future') {
            return $query->where('deadline', '>=', now());
        }
        return;
    }

}
