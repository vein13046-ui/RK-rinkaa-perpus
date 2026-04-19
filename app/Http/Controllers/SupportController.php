<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\SupportThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SupportController extends Controller
{
    private function issueOptions(): array
    {
        return SupportThread::issueOptions();
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $isAdmin = (($user->role ?? 'user') === 'admin');
        $issueOptions = $this->issueOptions();

        if ($isAdmin) {
            $threads = SupportThread::with(['user', 'latestMessage.sender'])
                ->whereNotNull('last_message_at')
                ->orderByDesc('last_message_at')
                ->orderByDesc('updated_at')
                ->get();

            $selectedThreadId = (int) $request->query('thread', $threads->first()?->id ?? 0);
            $thread = $selectedThreadId
                ? SupportThread::with(['user', 'messages.sender', 'latestMessage.sender'])->find($selectedThreadId)
                : null;

            if ($thread) {
                $this->markThreadAsRead($thread, true);
                $thread->load(['user', 'messages.sender', 'latestMessage.sender']);
            }

            $threads = SupportThread::with(['user', 'latestMessage.sender'])
                ->whereNotNull('last_message_at')
                ->orderByDesc('last_message_at')
                ->orderByDesc('updated_at')
                ->get();

            return view('support.index', compact('threads', 'thread', 'isAdmin', 'issueOptions'));
        }

        $thread = SupportThread::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'open']
        );

        $this->markThreadAsRead($thread, false);
        $thread->load(['user', 'messages.sender', 'latestMessage.sender']);

        return view('support.index', [
            'threads' => collect([$thread]),
            'thread' => $thread,
            'isAdmin' => false,
            'issueOptions' => $issueOptions,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $isAdmin = (($user->role ?? 'user') === 'admin');
        $issueOptions = $this->issueOptions();

        $rules = [
            'body' => ['required', 'string', 'min:1', 'max:2000'],
            'thread_id' => ['nullable', 'integer', 'exists:support_threads,id'],
        ];

        if (! $isAdmin) {
            $rules['issue_type'] = ['required', Rule::in(array_keys($issueOptions))];
        }

        $request->validate($rules);

        $thread = DB::transaction(function () use ($request, $user, $isAdmin) {
            if ($isAdmin) {
                $threadId = (int) $request->input('thread_id');
                $thread = SupportThread::lockForUpdate()->findOrFail($threadId);
            } else {
                $thread = SupportThread::firstOrCreate(
                    ['user_id' => $user->id],
                    ['status' => 'open']
                );
            }

            if (! $isAdmin) {
                $thread->forceFill([
                    'issue_type' => $request->input('issue_type'),
                ])->save();
            }

            $message = $thread->messages()->create([
                'sender_id' => $user->id,
                'sender_role' => $isAdmin ? 'admin' : 'user',
                'body' => trim((string) $request->input('body')),
            ]);

            if ($isAdmin) {
                $thread->forceFill([
                    'status' => 'open',
                    'last_message_at' => $message->created_at,
                    'unread_admin_count' => 0,
                ])->save();

                $thread->increment('unread_user_count');
            } else {
                $thread->forceFill([
                    'status' => 'open',
                    'last_message_at' => $message->created_at,
                    'unread_user_count' => 0,
                ])->save();

                $thread->increment('unread_admin_count');
            }

            return $thread;
        });

        if ($isAdmin) {
            return redirect()
                ->route('support.index', ['thread' => $thread->id])
                ->with('success', 'Pesan berhasil dikirim ke user.');
        }

        return redirect()
            ->route('support.index')
            ->with('success', 'Pesan berhasil dikirim ke admin.');
    }

    public function clear(Request $request)
    {
        $user = $request->user();
        $thread = SupportThread::where('user_id', $user->id)->first();

        if (! $thread) {
            return back()->with('success', 'Obrolan sudah kosong.');
        }

        DB::transaction(function () use ($thread) {
            SupportMessage::where('support_thread_id', $thread->id)->delete();

            $thread->forceFill([
                'issue_type' => null,
                'last_message_at' => null,
                'unread_user_count' => 0,
                'unread_admin_count' => 0,
            ])->save();
        });

        return redirect()
            ->route('support.index')
            ->with('success', 'Obrolan berhasil dibersihkan. Kamu bisa mulai dari awal.');
    }

    private function markThreadAsRead(SupportThread $thread, bool $isAdmin): void
    {
        $senderRole = $isAdmin ? 'user' : 'admin';

        SupportMessage::where('support_thread_id', $thread->id)
            ->where('sender_role', $senderRole)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($isAdmin) {
            $thread->forceFill(['unread_admin_count' => 0])->saveQuietly();
        } else {
            $thread->forceFill(['unread_user_count' => 0])->saveQuietly();
        }
    }
}
