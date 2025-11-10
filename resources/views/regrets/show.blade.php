@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="regret-content">{{ $regret->content }}</div>
        <div class="regret-meta">
            <span>{{ $regret->created_at->diffForHumans() }}</span>
            @if(in_array($regret->token, session('owned_regrets', [])))
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('regrets.edit', $regret) }}" style="color: #667aba; text-decoration: none; font-size: 0.9rem;">✏️ ویرایش</a>
                    <form action="{{ route('regrets.destroy', $regret) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این پشیمانی را حذف کنید؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 0.9rem; padding: 0;">🗑️ حذف</button>
                    </form>
                </div>
            @endif
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
                <div class="comment-date" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                    @if(in_array($comment->token, session('owned_comments', [])))
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('regrets.comments.edit', [$regret, $comment]) }}" style="color: #667aba; text-decoration: none; font-size: 0.85rem;">✏️ ویرایش</a>
                            <form action="{{ route('regrets.comments.destroy', [$regret, $comment]) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این نظر را حذف کنید؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 0.85rem; padding: 0;">🗑️ حذف</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p style="color: #888; text-align: center;">هنوز نظری ثبت نشده است.</p>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('regrets.index') }}" class="btn btn-secondary">بازگشت به صفحه اصلی</a>
    </div>
@endsection

