@extends('layouts.app')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 20px; color: darkblue;">ویرایش پشیمانی</h2>
        <form action="{{ route('regrets.update', $regret) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="content">پشیمانی شما:</label>
                <textarea name="content" id="content" rows="5" required placeholder="پشیمانی خود را اینجا بنویسید...">{{ old('content', $regret->content) }}</textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit">ذخیره تغییرات</button>
                <a href="{{ route('regrets.show', $regret) }}" class="btn btn-secondary">انصراف</a>
            </div>
        </form>
    </div>
@endsection

