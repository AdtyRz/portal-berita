<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // <-- PENTING
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCommentReceived implements ShouldBroadcast // <-- Tambahkan ini
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastOn(): array
    {
        // Admin akan mendengarkan channel 'admin-dashboard'
        return [
            new Channel('admin-dashboard'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new.comment'; // Nama event di frontend
    }
}