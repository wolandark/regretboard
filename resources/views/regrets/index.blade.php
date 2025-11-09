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
                <a href="{{ route('regrets.show', $regret) }}" class="link">
                    <span class="comment-count">{{ $regret->comments->count() }} نظر</span>
                </a>
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

