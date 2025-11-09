# تخته پشیمانی (Regret Board)

A simple, minimal regret board website built with Laravel where people can anonymously share their regrets and comment on others' regrets.

## Features

- Anonymous posting (no authentication required)
- Persian language interface with RTL support
- Minimal and stylish design
- Comment system for regrets
- Responsive layout

## Requirements

- PHP 8.2 or higher
- Composer
- SQLite PHP extension

## Installation

1. Install dependencies:
```bash
composer install
```

2. Install SQLite PHP extension (if not already installed):

**On Arch Linux:**
```bash
sudo pacman -S php-sqlite
```

**On Ubuntu/Debian:**
```bash
sudo apt-get install php-sqlite3
```

**On macOS (with Homebrew):**
```bash
brew install php
```

3. Create the database file (if it doesn't exist):
```bash
touch database/database.sqlite
```

4. Run migrations:
```bash
php artisan migrate
```

5. Start the development server:
```bash
php artisan serve
```

6. Visit `http://localhost:8000` in your browser.

## Usage

- Visit the homepage to see all regrets
- Write a new regret using the form at the top
- Click on a regret to view it and add comments
- All content is in Persian with RTL layout

## Database

The application uses SQLite by default. The database file is located at `database/database.sqlite`.

To use MySQL or PostgreSQL instead, update the `.env` file with your database credentials.
