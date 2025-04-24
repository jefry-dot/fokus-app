<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\FocusSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FocusSessionController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'duration_minutes' => 'required|integer|min:1',
        'started_at' => 'required|date',
        'ended_at' => 'required|date|after:started_at',
    ]);

    $session = $request->user()->focusSessions()->create($data);

    return response()->json(['message' => 'Sesi disimpan', 'data' => $session]);
}

public function index()
{
    $sessions = FocusSession::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get(['id', 'duration', 'category', 'created_at']);

    return Inertia::render('FocusHistory', [
        'sessions' => $sessions
    ]);
}

}
