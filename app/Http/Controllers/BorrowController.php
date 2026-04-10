<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BorrowController extends Controller
{
    private const PICKUP_WINDOW_HOURS = 8;

    public function indexUser()
    {
        BorrowRequest::expireOverduePickups();

        $borrows = BorrowRequest::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('borrow.status_peminjaman_user_clean', compact('borrows'));
    }

    public function indexAdmin()
    {
        BorrowRequest::expireOverduePickups();

        $borrows = BorrowRequest::with(['book', 'user', 'approvedBy'])
            ->latest()
            ->paginate(12);

        $stats = [
            'pending' => BorrowRequest::where('status', 'pending')->count(),
            'approved' => BorrowRequest::where('status', 'approved')->count(),
            'picked_up' => BorrowRequest::where('status', 'picked_up')->count(),
            'return_pending' => BorrowRequest::where('status', 'return_pending')->count(),
            'returned' => BorrowRequest::where('status', 'returned')->count(),
            'cancelled' => BorrowRequest::where('status', 'cancelled')->count(),
        ];

        return view('books_admin.status_peminjaman_buku_clean', compact('borrows', 'stats'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrow_days' => 'required|integer|min:1|max:3',
            'damage_agreement' => 'accepted',
        ]);

        if ($book->stok <= 0) {
            return back()->withErrors([
                'borrow_request' => 'Stok buku habis. Silakan pilih buku lain.',
            ])->withInput();
        }

        $hasActiveRequest = BorrowRequest::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved', 'picked_up', 'return_pending'])
            ->exists();

        if ($hasActiveRequest) {
            return back()->withErrors([
                'borrow_request' => 'Buku ini sudah punya peminjaman aktif atau masih menunggu proses.',
            ])->withInput();
        }

        BorrowRequest::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrower_name' => $request->borrower_name,
            'borrow_days' => (int) $request->borrow_days,
            'status' => 'pending',
            'damage_agreement' => true,
        ]);

        return redirect()
            ->route('borrow.user.index')
            ->with('success', 'Permintaan peminjaman berhasil dikirim dan sedang menunggu konfirmasi admin.');
    }

    public function approve(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->status !== 'pending') {
            return back()->withErrors([
                'borrow_action' => 'Permintaan ini sudah diproses sebelumnya.',
            ]);
        }

        DB::transaction(function () use ($borrowRequest) {
            $book = Book::whereKey($borrowRequest->book_id)->lockForUpdate()->firstOrFail();

            if ($book->stok <= 0) {
                abort(422, 'Stok buku sudah habis.');
            }

            $book->decrement('stok');

            $borrowRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'pickup_deadline' => now()->addHours(self::PICKUP_WINDOW_HOURS),
                'due_date' => now()->addDays($borrowRequest->borrow_days)->toDateString(),
            ]);
        });

        return back()->with('success', 'Peminjaman berhasil dikonfirmasi. User harus ambil buku dalam 8 jam.');
    }

    public function pickup(BorrowRequest $borrowRequest, Request $request)
    {
        if ($borrowRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrowRequest->status !== 'approved') {
            return back()->withErrors([
                'borrow_action' => 'Buku hanya bisa diambil saat status sudah disetujui.',
            ]);
        }

        if ($borrowRequest->pickup_deadline && now()->greaterThan($borrowRequest->pickup_deadline)) {
            BorrowRequest::expireOverduePickups();

            return back()->withErrors([
                'borrow_action' => 'Batas 8 jam sudah lewat. Peminjaman dibatalkan otomatis.',
            ]);
        }

        $request->validate([
            'pickup_code' => 'required|string|max:32',
        ]);

        $validCodes = array_map('trim', $borrowRequest->pickup_code_variants);

        if (! in_array(trim($request->pickup_code), $validCodes, true)) {
            return back()->withErrors([
                'borrow_action' => 'Kode pickup tidak valid. Silakan buka ulang modal dan coba lagi.',
            ]);
        }

        $borrowRequest->update([
            'status' => 'picked_up',
            'picked_up_at' => now(),
        ]);

        return redirect()
            ->route('borrow.user.index')
            ->with('success', 'Buku berhasil diambil. Silakan kembalikan sebelum jatuh tempo.');
    }

    public function pickupData(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrowRequest->status !== 'approved') {
            return response()->json([
                'message' => 'Buku belum siap diambil.',
            ], 422);
        }

        return response()->json([
            'code' => $borrowRequest->pickup_code,
            'deadline' => optional($borrowRequest->pickup_deadline)->translatedFormat('d M Y H:i'),
            'title' => $borrowRequest->book->judul ?? '',
            'author' => $borrowRequest->book->penulis ?? '',
            'category' => $borrowRequest->book->kategori ?? '',
            'cover' => $borrowRequest->book && $borrowRequest->book->cover ? Storage::url($borrowRequest->book->cover) : '',
        ]);
    }

    public function requestReturn(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrowRequest->status !== 'picked_up') {
            return back()->withErrors([
                'borrow_action' => 'Pengembalian hanya bisa diminta setelah buku benar-benar diambil.',
            ]);
        }

        $borrowRequest->update([
            'status' => 'return_pending',
            'return_requested_at' => now(),
        ]);

        return back()->with('success', 'Permintaan pengembalian terkirim dan menunggu konfirmasi admin.');
    }

    public function approveReturn(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->status !== 'return_pending') {
            return back()->withErrors([
                'borrow_action' => 'Permintaan pengembalian ini belum menunggu konfirmasi.',
            ]);
        }

        DB::transaction(function () use ($borrowRequest) {
            $book = Book::whereKey($borrowRequest->book_id)->lockForUpdate()->firstOrFail();

            $book->increment('stok');

            $borrowRequest->update([
                'status' => 'returned',
                'return_approved_at' => now(),
                'returned_at' => now(),
            ]);
        });

        return back()->with('success', 'Pengembalian buku berhasil dikonfirmasi.');
    }

    public function rejectReturn(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->status !== 'return_pending') {
            return back()->withErrors([
                'borrow_action' => 'Permintaan pengembalian ini belum menunggu konfirmasi.',
            ]);
        }

        $borrowRequest->update([
            'status' => 'picked_up',
            'return_requested_at' => null,
        ]);

        return back()->with('success', 'Permintaan pengembalian ditolak.');
    }

    public function reject(BorrowRequest $borrowRequest)
    {
        if ($borrowRequest->status !== 'pending') {
            return back()->withErrors([
                'borrow_action' => 'Permintaan ini sudah diproses sebelumnya.',
            ]);
        }

        $borrowRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Permintaan peminjaman ditolak.');
    }
}
