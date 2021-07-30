<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'link',
        'read',
        'color',
        'icon',
        'dismissible'
    ];

    /**
     * Get recent notification
     * Used for displaying in topbar
     * @param int $limit Count of notifications to return (Default: 5)
     * @param bool $unread Must be notification unread - True: Unread, False: All (Default: true)
     * @return Collection Array of loaded notifications
     */
    public static function loadRecentNotifications(int $limit = 5, bool $unread = true): Collection
    {
        $notification =  Notification::where('user_id', auth()->user()->id ?? 0);

        if ($unread) {
            $notification->where('read', false);
        }

        return $notification
            ->take($limit)
            ->get();
    }
}
