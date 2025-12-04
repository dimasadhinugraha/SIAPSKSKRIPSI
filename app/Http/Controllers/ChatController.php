<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get all verified users except current user
        $users = User::where('id', '!=', $user->id)
            ->where('is_verified', true)
            ->orderBy('name')
            ->get();

        // Get existing chats for current user
        $existingChats = Chat::forUser($user->id)
            ->active()
            ->with(['latestMessage.user'])
            ->get();

        // Add chat info and unread count to each user
        foreach ($users as $otherUser) {
            // Find existing private chat with this user
            $existingChat = $existingChats->first(function ($chat) use ($user, $otherUser) {
                return $chat->type === 'private' &&
                       in_array($user->id, $chat->participants) &&
                       in_array($otherUser->id, $chat->participants);
            });

            $otherUser->existing_chat = $existingChat;
            $otherUser->unread_count = $existingChat ? $existingChat->getUnreadCount($user->id) : 0;
            $otherUser->last_message = $existingChat ? $existingChat->latestMessage : null;
        }

        return view('chat.index', compact('users'));
    }

    public function getChatWithUser(User $user)
    {
        $currentUser = auth()->user();
        $chat = Chat::createPrivateChat($currentUser->id, $user->id, "Chat dengan {$user->name}");

        $chat->markAsRead($currentUser->id);

        $messages = $chat->messages()->with('user')->get();

        return response()->json([
            'chat_id' => $chat->id,
            'user' => [
                'name' => $user->name,
                'initials' => $user->initials,
            ],
            'messages' => $messages,
        ]);
    }

    public function show(Chat $chat)
    {
        $user = auth()->user();

        // Check if user is participant
        if (!$chat->isParticipant($user->id)) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }

        // Mark messages as read
        $chat->markAsRead($user->id);

        // Load messages with users
        $messages = $chat->messages()->with('user')->get();

        // Get participants
        $participants = $chat->getParticipantUsers();

        return view('chat.show', compact('chat', 'messages', 'participants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:private,group,announcement',
            'title' => 'required|string|max:255',
            'participants' => 'required_if:type,group|array',
            'participants.*' => 'exists:users,id',
        ]);

        $user = auth()->user();

        switch ($request->type) {
            case 'private':
                if (count($request->participants) !== 1) {
                    return back()->with('error', 'Chat private hanya bisa dengan 1 orang.');
                }
                $chat = Chat::createPrivateChat($user->id, $request->participants[0], $request->title);
                break;

            case 'group':
                $chat = Chat::createGroupChat($user->id, $request->participants, $request->title);
                break;

            case 'announcement':
                $chat = Chat::createAnnouncementChat($user->id, $request->title);
                break;
        }

        return redirect()->route('chat.show', $chat)->with('success', 'Chat berhasil dibuat.');
    }

    public function sendMessage(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required_without:file|string|max:1000',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $chat = Chat::find($request->chat_id);

        // Check if user is participant
        if (!$chat->isParticipant($user->id)) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }

        $messageData = [
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'message' => $request->message ?? '',
            'type' => 'text',
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('chat-files', $fileName, 'public');

            $messageData['type'] = $this->getFileType($file);
            $messageData['file_path'] = $filePath;
            $messageData['file_name'] = $file->getClientOriginalName();
            $messageData['message'] = $messageData['message'] ?: 'File: ' . $file->getClientOriginalName();
        }

        $message = ChatMessage::create($messageData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('user'),
            ]);
        }

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    public function getMessages(Chat $chat)
    {
        $user = auth()->user();

        // Check if user is participant
        if (!$chat->isParticipant($user->id)) {
            abort(403);
        }

        // Mark messages as read
        $chat->markAsRead($user->id);

        $messages = $chat->messages()->with('user')->get();

        return response()->json($messages);
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())
            ->where('is_verified', true)
            ->orderBy('name')
            ->get();

        return view('chat.create', compact('users'));
    }

    public function startPrivateChat(User $user)
    {
        $currentUser = auth()->user();

        // Create or get existing private chat
        $chat = Chat::createPrivateChat($currentUser->id, $user->id, "Chat dengan {$user->name}");

        return redirect()->route('chat.show', $chat);
    }

    private function getFileType($file)
    {
        $mimeType = $file->getMimeType();
        
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }
        
        return 'file';
    }

    public function downloadFile(ChatMessage $message)
    {
        $user = auth()->user();

        // Check if user is participant of the chat
        if (!$message->chat->isParticipant($user->id)) {
            abort(403);
        }

        if (!$message->file_path || !Storage::disk('public')->exists($message->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($message->file_path, $message->file_name);
    }

    public function addParticipant(Request $request, Chat $chat)
    {
        $user = auth()->user();

        // Only creator or admin can add participants
        if ($chat->created_by !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $chat->addParticipant($request->user_id);

        return back()->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function removeParticipant(Request $request, Chat $chat)
    {
        $user = auth()->user();

        // Only creator or admin can remove participants
        if ($chat->created_by !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $chat->removeParticipant($request->user_id);

        return back()->with('success', 'Peserta berhasil dihapus.');
    }

    public function leaveChat(Chat $chat)
    {
        $user = auth()->user();

        if (!$chat->isParticipant($user->id)) {
            abort(403);
        }

        $chat->removeParticipant($user->id);

        return redirect()->route('chat.index')->with('success', 'Anda telah keluar dari chat.');
    }
}
