<?php

namespace App\Http\Controllers;

use App\Models\Regret;
use App\Models\Comment;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class RegretController extends Controller
{
    public function index()
    {
        $regrets = Regret::with('comments')
            ->latest()
            ->paginate(10);

        return view('regrets.index', compact('regrets'));
    }

    public function show(Regret $regret)
    {
        $regret->load('comments');
        return view('regrets.show', compact('regret'));
    }

    public function store(Request $request, TelegramService $telegram)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $regret = Regret::create($validated);

        // Store token in session so user can edit/delete
        $ownedRegrets = $request->session()->get('owned_regrets', []);
        $ownedRegrets[] = $regret->token;
        $request->session()->put('owned_regrets', $ownedRegrets);

        // Send Telegram notification
        $telegram->notifyNewRegret($regret);

        return redirect()->route('regrets.index')
            ->with('success', 'پشیمانی شما ثبت شد. لینک ویرایش برای شما ذخیره شد.');
    }

    public function edit(Request $request, Regret $regret)
    {
        // Check if user owns this regret
        $ownedRegrets = $request->session()->get('owned_regrets', []);
        if (!in_array($regret->token, $ownedRegrets)) {
            abort(403, 'شما اجازه ویرایش این پشیمانی را ندارید.');
        }

        return view('regrets.edit', compact('regret'));
    }

    public function update(Request $request, Regret $regret)
    {
        // Check if user owns this regret
        $ownedRegrets = $request->session()->get('owned_regrets', []);
        if (!in_array($regret->token, $ownedRegrets)) {
            abort(403, 'شما اجازه ویرایش این پشیمانی را ندارید.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $regret->update($validated);

        return redirect()->route('regrets.show', $regret)
            ->with('success', 'پشیمانی شما به‌روزرسانی شد.');
    }

    public function destroy(Request $request, Regret $regret)
    {
        // Check if user owns this regret
        $ownedRegrets = $request->session()->get('owned_regrets', []);
        if (!in_array($regret->token, $ownedRegrets)) {
            abort(403, 'شما اجازه حذف این پشیمانی را ندارید.');
        }

        $regret->delete();

        // Remove token from session
        $ownedRegrets = array_diff($ownedRegrets, [$regret->token]);
        $request->session()->put('owned_regrets', $ownedRegrets);

        return redirect()->route('regrets.index')
            ->with('success', 'پشیمانی شما حذف شد.');
    }

    public function comment(Request $request, Regret $regret, TelegramService $telegram)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment = $regret->comments()->create($validated);

        // Store token in session so user can edit/delete
        $ownedComments = $request->session()->get('owned_comments', []);
        $ownedComments[] = $comment->token;
        $request->session()->put('owned_comments', $ownedComments);

        // Send Telegram notification
        $telegram->notifyNewComment($comment, $regret);

        return redirect()->route('regrets.show', $regret)
            ->with('success', 'نظر شما ثبت شد.');
    }

    public function editComment(Request $request, Regret $regret, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        // Check if comment belongs to regret
        if ($comment->regret_id !== $regret->id) {
            abort(404);
        }

        // Check if user owns this comment
        $ownedComments = $request->session()->get('owned_comments', []);
        if (!in_array($comment->token, $ownedComments)) {
            abort(403, 'شما اجازه ویرایش این نظر را ندارید.');
        }

        return view('regrets.edit-comment', compact('regret', 'comment'));
    }

    public function updateComment(Request $request, Regret $regret, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        // Check if comment belongs to regret
        if ($comment->regret_id !== $regret->id) {
            abort(404);
        }

        // Check if user owns this comment
        $ownedComments = $request->session()->get('owned_comments', []);
        if (!in_array($comment->token, $ownedComments)) {
            abort(403, 'شما اجازه ویرایش این نظر را ندارید.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment->update($validated);

        return redirect()->route('regrets.show', $regret)
            ->with('success', 'نظر شما به‌روزرسانی شد.');
    }

    public function destroyComment(Request $request, Regret $regret, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        // Check if comment belongs to regret
        if ($comment->regret_id !== $regret->id) {
            abort(404);
        }

        // Check if user owns this comment
        $ownedComments = $request->session()->get('owned_comments', []);
        if (!in_array($comment->token, $ownedComments)) {
            abort(403, 'شما اجازه حذف این نظر را ندارید.');
        }

        $comment->delete();

        // Remove token from session
        $ownedComments = array_diff($ownedComments, [$comment->token]);
        $request->session()->put('owned_comments', $ownedComments);

        return redirect()->route('regrets.show', $regret)
            ->with('success', 'نظر شما حذف شد.');
    }
}
