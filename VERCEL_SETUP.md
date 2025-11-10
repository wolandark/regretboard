# Vercel Deployment Setup

## Important: Database Persistence Issue

⚠️ **SQLite on Vercel is NOT persistent!** Each serverless function invocation gets a fresh `/tmp` directory, so data will be lost between requests.

**You MUST use a cloud database for production.** Options:
- **PlanetScale** (MySQL) - Free tier available
- **Supabase** (PostgreSQL) - Free tier available  
- **Railway** (PostgreSQL) - Free tier available
- **Neon** (PostgreSQL) - Free tier available

## Required Environment Variables in Vercel

Go to your Vercel project settings → Environment Variables and add:

1. **APP_KEY** (REQUIRED)
   ```bash
   php artisan key:generate --show
   ```
   Copy the output and set it as `APP_KEY` in Vercel.

2. **Database Configuration** (if using cloud database):
   - `DB_CONNECTION=mysql` (or `pgsql`)
   - `DB_HOST=your-db-host`
   - `DB_PORT=3306` (or `5432` for PostgreSQL)
   - `DB_DATABASE=your-database-name`
   - `DB_USERNAME=your-username`
   - `DB_PASSWORD=your-password`

## Current Configuration

The `vercel.json` is configured to use SQLite at `/tmp/database.sqlite` for testing, but this won't persist. For production, you must:

1. Set up a cloud database
2. Update the environment variables in Vercel
3. Remove or update `DB_DATABASE` in `vercel.json` to use your cloud database

## Troubleshooting 500 Errors

1. **Check APP_KEY is set** - This is the most common cause
2. **Check database connection** - Ensure credentials are correct
3. **Check Vercel logs** - View function logs in Vercel dashboard
4. **Enable debug temporarily** - Set `APP_DEBUG=true` to see errors (remove after fixing!)

## Migration

After setting up your cloud database, you'll need to run migrations. You can:

1. Use Vercel's build command to run migrations:
   ```json
   "buildCommand": "php artisan migrate --force"
   ```

2. Or create a one-time migration endpoint (for security, protect it with a secret)

