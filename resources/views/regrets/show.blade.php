@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="regret-content">{{ $regret->content }}</div>
        <div class="regret-meta">
            <span>{{ $regret->created_at->diffForHumans() }}</span>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-bottom: 20px; color: darkblue;">نظر خود را بنویسید</h2>
        <form action="{{ route('regrets.comment', $regret) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">نظر شما:</label>
                <textarea name="content" id="content" rows="4" required placeholder="نظر خود را اینجا بنویسید..."></textarea>
            </div>
            <button type="submit">ارسال نظر</button>
        </form>
    </div>

    <div class="card">
        <h2 style="margin-bottom: 20px; color: darkcyan;">نظرات ({{ $regret->comments->count() }})</h2>
        
        @forelse($regret->comments as $comment)
            <div class="comment">
                <div class="comment-content">{{ $comment->content }}</div>
                <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
            </div>
        @empty
            <p style="color: #888; text-align: center;">هنوز نظری ثبت نشده است.</p>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('regrets.index') }}" class="btn btn-secondary">بازگشت به صفحه اصلی</a>
    </div>
@endsection

