<?php
// Initialize database for Vercel if needed
if (getenv('DB_DATABASE') === '/tmp/database.sqlite' || getenv('VERCEL')) {
    $dbPath = '/tmp/database.sqlite';
    if (!file_exists($dbPath)) {
        touch($dbPath);
        chmod($dbPath, 0666);
    }
}

require __DIR__ . '/../public/index.php';

