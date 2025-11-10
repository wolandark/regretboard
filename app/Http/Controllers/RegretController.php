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

        // Send Telegram notification
        $telegram->notifyNewRegret($regret);

        return redirect()->route('regrets.index')
            ->with('success', 'پشیمانی شما ثبت شد.');
    }

    public function comment(Request $request, Regret $regret, TelegramService $telegram)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment = $regret->comments()->create($validated);

        // Send Telegram notification
        $telegram->notifyNewComment($comment, $regret);

        return redirect()->route('regrets.show', $regret)
            ->with('success', 'نظر شما ثبت شد.');
    }
}
