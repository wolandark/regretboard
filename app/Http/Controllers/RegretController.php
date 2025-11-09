<?php

namespace App\Http\Controllers;

use App\Models\Regret;
use App\Models\Comment;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        Regret::create($validated);

        return redirect()->route('regrets.index')
            ->with('success', 'پشیمانی شما ثبت شد.');
    }

    public function comment(Request $request, Regret $regret)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $regret->comments()->create($validated);

        return redirect()->route('regrets.show', $regret)
            ->with('success', 'نظر شما ثبت شد.');
    }
}
