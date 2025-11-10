@extends('layouts.app')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 20px; color: darkblue;">پشیمانی جدید بنویسید</h2>
        <form action="{{ route('regrets.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">پشیمانی شما:</label>
                <textarea name="content" id="content" rows="5" required placeholder="پشیمانی خود را اینجا بنویسید..."></textarea>
            </div>
            <button type="submit">ارسال</button>
        </form>
    </div>

    <h2 style="color: white; margin: 30px 0 20px 0; text-align: center;">پشیمانی‌های دیگران</h2>

    @forelse($regrets as $regret)
        <div class="card">
            <div class="regret-content">{{ $regret->content }}</div>
            <div class="regret-meta">
                <span>{{ $regret->created_at->diffForHumans() }}</span>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="{{ route('regrets.show', $regret) }}" class="link">
                        <span class="comment-count">{{ $regret->comments->count() }} نظر</span>
                    </a>
                    @if(in_array($regret->token, session('owned_regrets', [])))
                        <a href="{{ route('regrets.edit', $regret) }}" style="color: #667aba; text-decoration: none; font-size: 0.9rem;">✏️ ویرایش</a>
                        <form action="{{ route('regrets.destroy', $regret) }}" method="POST" style="display: inline;" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این پشیمانی را حذف کنید؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 0.9rem; padding: 0;">🗑️ حذف</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="card" style="text-align: center; color: #888;">
            <p>هنوز پشیمانی‌ای ثبت نشده است. اولین نفر باشید!</p>
        </div>
    @endforelse

    <div class="pagination">
        {{ $regrets->links() }}
    </div>
@endsection

