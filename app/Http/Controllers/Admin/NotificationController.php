<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Contact;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Dipanggil di AppServiceProvider untuk dikirim ke semua view admin
     */
    public function getHeaderData()
    {
        // Gunakan with('post') untuk menghindari N+1 query problem
        $pendingComments = Comment::with('post')
            ->where('is_approved', false)
            ->latest()
            ->take(5)
            ->get();
            
        $newMessages = Contact::where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        $notifications = [];
        
        foreach ($pendingComments as $comment) {
            $notifications[] = [
                'id' => 'c_' . $comment->id,
                'type' => 'comment',
                'title' => 'New Comment Pending',
                'message' => 'On: ' . substr($comment->post->title ?? 'Post', 0, 25) . '...',
                'time' => $comment->created_at->diffForHumans(),
                'timestamp' => $comment->created_at->timestamp, // Ditambahkan untuk sorting
                'url' => route('admin.comments.index'),
                'is_read' => false
            ];
        }

        foreach ($newMessages as $message) {
            $notifications[] = [
                'id' => 'm_' . $message->id,
                'type' => 'message',
                'title' => 'New Contact Message',
                'message' => 'From: ' . $message->name,
                'time' => $message->created_at->diffForHumans(),
                'timestamp' => $message->created_at->timestamp, // Ditambahkan untuk sorting
                'url' => route('admin.contacts.show', $message->id),
                'is_read' => false
            ];
        }

        // Urutkan berdasarkan timestamp (Terbaru di atas / Descending)
        usort($notifications, function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        // Hapus key 'timestamp' agar tidak dikirim ke frontend (lebih bersih)
        $cleanNotifications = array_map(function($item) {
            unset($item['timestamp']);
            return $item;
        }, $notifications);

        return [
            'notifications' => array_slice($cleanNotifications, 0, 10), // Max 10 notifikasi
            'unreadCount' => $pendingComments->count() + $newMessages->count()
        ];
    }

    /**
     * Endpoint untuk menandai sudah dibaca saat dropdown dibuka
     */
    public function markAsRead(Request $request)
    {
        // Tandai semua contact baru sebagai sudah dibaca
        Contact::where('is_read', false)->update(['is_read' => true]);
        
        // Catatan: Comment tetap dianggap "unread" sampai benar-benar di-approve/dihapus
        
        return response()->json(['success' => true]);
    }
}