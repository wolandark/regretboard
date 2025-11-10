-- Connect to the database:
-- docker exec -it regretboard-postgres psql -U regretboard_user -d regretboard

-- ============================================
-- USEFUL QUERIES
-- ============================================

-- List all tables
\dt

-- List all tables with details
\dt+

-- Describe a table structure
\d regrets
\d comments

-- ============================================
-- DATA QUERIES
-- ============================================

-- View all regrets
SELECT * FROM regrets ORDER BY created_at DESC;

-- View all regrets with comment count
SELECT 
    r.id,
    r.content,
    r.created_at,
    COUNT(c.id) as comment_count
FROM regrets r
LEFT JOIN comments c ON c.regret_id = r.id
GROUP BY r.id, r.content, r.created_at
ORDER BY r.created_at DESC;

-- View a specific regret with its comments
SELECT 
    r.id as regret_id,
    r.content as regret_content,
    r.created_at as regret_date,
    c.id as comment_id,
    c.content as comment_content,
    c.created_at as comment_date
FROM regrets r
LEFT JOIN comments c ON c.regret_id = r.id
WHERE r.id = 1
ORDER BY c.created_at ASC;

-- Count total regrets
SELECT COUNT(*) as total_regrets FROM regrets;

-- Count total comments
SELECT COUNT(*) as total_comments FROM comments;

-- View most commented regrets
SELECT 
    r.id,
    r.content,
    COUNT(c.id) as comment_count
FROM regrets r
LEFT JOIN comments c ON c.regret_id = r.id
GROUP BY r.id, r.content
ORDER BY comment_count DESC
LIMIT 10;

-- ============================================
-- MAINTENANCE QUERIES
-- ============================================

-- Delete all data (CAREFUL!)
-- DELETE FROM comments;
-- DELETE FROM regrets;

-- Delete a specific regret (will cascade delete comments due to foreign key)
-- DELETE FROM regrets WHERE id = 1;

-- Delete old regrets (older than 30 days)
-- DELETE FROM regrets WHERE created_at < NOW() - INTERVAL '30 days';

-- ============================================
-- TABLE INFO
-- ============================================

-- Check table sizes
SELECT 
    schemaname,
    tablename,
    pg_size_pretty(pg_total_relation_size(schemaname||'.'||tablename)) AS size
FROM pg_tables
WHERE schemaname = 'public'
ORDER BY pg_total_relation_size(schemaname||'.'||tablename) DESC;

-- Check database size
SELECT pg_size_pretty(pg_database_size('regretboard'));

-- View all indexes
\di

-- ============================================
-- USER MANAGEMENT
-- ============================================

-- List all users
\du

-- Change password (if needed)
-- ALTER USER regretboard_user WITH PASSWORD 'new_password';

