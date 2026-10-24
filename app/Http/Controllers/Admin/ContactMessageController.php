<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        // Status filter (unread, read, all)
        $status = $request->input('status', 'all');
        if ($status === 'unread') {
            $query->where('is_read', false);
        } elseif ($status === 'read') {
            $query->where('is_read', true);
        }

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $totalCount = ContactMessage::count();
        $unreadCount = ContactMessage::where('is_read', false)->count();
        $readCount = ContactMessage::where('is_read', true)->count();

        return view('admin.contact-messages.index', compact(
            'messages',
            'status',
            'search',
            'totalCount',
            'unreadCount',
            'readCount'
        ));
    }

    /**
     * Display the specified contact message and mark as read.
     */
    public function show(ContactMessage $contactMessage): View
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Toggle the read/unread status of the message.
     */
    public function toggleRead(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update([
            'is_read' => ! $contactMessage->is_read,
        ]);

        $statusText = $contactMessage->is_read ? 'পঠিত (Read)' : 'অপঠিত (Unread)';

        return back()->with('success', "বার্তাটি {$statusText} হিসেবে চিহ্নিত করা হয়েছে।");
    }

    /**
     * Remove the specified contact message from storage.
     */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'বার্তাটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
