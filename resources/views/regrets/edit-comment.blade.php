@extends('layouts.app')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 20px; color: darkblue;">ویرایش نظر</h2>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>پشیمانی:</strong>
            <p style="margin-top: 10px; color: #666;">{{ $regret->content }}</p>
        </div>
        <form action="{{ route('regrets.comments.update', [$regret, $comment]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="content">نظر شما:</label>
                <textarea name="content" id="content" rows="4" required placeholder="نظر خود را اینجا بنویسید...">{{ old('content', $comment->content) }}</textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit">ذخیره تغییرات</button>
                <a href="{{ route('regrets.show', $regret) }}" class="btn btn-secondary">انصراف</a>
            </div>
        </form>
    </div>
@endsection

