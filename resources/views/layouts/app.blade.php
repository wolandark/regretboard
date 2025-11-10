<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تخته پشیمانی</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* background: linear-gradient(135deg, #1e1e2e 0%, #764ba2 100%); */
            background: #1e1e2e;
            min-height: 100vh;
            padding: 20px;
            color: #cdcdcd;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            color: #cdcdcd;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .regret-content {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 15px;
            color: #444;
        }

        .regret-meta {
            font-size: 0.9rem;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comment-count {
            background: darkcyan;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            resize: vertical;
            transition: border-color 0.3s;
        }

        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        button, .btn {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            background: #667aba;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: opacity 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        button:hover, .btn:hover {
            opacity: 0.9;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .comments-section {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #eee;
        }

        .comment {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-right: 4px solid #667eea;
        }

        .comment-content {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .comment-date {
            font-size: 0.85rem;
            color: #888;
        }

        .link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .link:hover {
            text-decoration: underline;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .pagination a, .pagination span {
            padding: 8px 15px;
            background: white;
            border-radius: 6px;
            text-decoration: none;
            color: #667eea;
        }

        .pagination .active {
            background: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>تخته پشیمانی</h1>
            <p class="subtitle">پشیمانی‌های خود را به اشتراک بگذارید و با دیگران ارتباط برقرار کنید</p>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error" style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>

