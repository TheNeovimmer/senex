<?php
/**
 * SENEX - Database Seeder
 * 
 * Run: php seed.php
 * 
 * This script:
 *   1. Runs all pending database migrations
 *   2. Creates test user accounts
 *   3. Seeds sample data (categories, badges)
 * 
 * Run it once after installing the project.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Config/Database.php';

echo "===============================\n";
echo "   SENEX Database Seeder\n";
echo "===============================\n\n";

// ─── Database Connection ────────────────────────────────────────

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $pdo = \Config\Database::getConnection();
    echo "[✓] Database connected.\n\n";
} catch (\Exception $e) {
    die("[✗] Connection failed: " . $e->getMessage() . "\n");
}

// ─── Step 1: Add streamer role to users table ───────────────────

echo "─── Step 1: Role column ───\n";
try {
    $pdo->exec("ALTER TABLE users MODIFY COLUMN role ENUM('user','streamer','admin') NOT NULL DEFAULT 'user'");
    echo "[✓] Role column supports 'streamer'.\n";
} catch (\PDOException $e) {
    echo "[i] " . $e->getMessage() . "\n";
}

// ─── Step 2: Run migrations ─────────────────────────────────────

echo "\n─── Step 2: Migrations ───\n";

$migrationMapping = [
    '20260216_create_user_table.php'  => 'CreateUserTable',
    '20261805_create_contact_table.php' => 'CreateContactTable',
    '20261905_create_categories_table.php' => 'CreateCategoriesTable',
    '20261906_create_badges_table.php' => 'CreateBadgesTable',
    '20261907_create_challenges_table.php' => 'CreateChallengesTable',
    '20261908_create_streams_table.php' => 'CreateStreamsTable',
    '20261909_create_user_tables.php' => 'CreateUserTables',
    '20261910_create_interaction_tables.php' => 'CreateInteractionTables',
    '20261911_create_replay_tables.php' => 'CreateReplayTables',
    '20261912_create_moderation_tables.php' => 'CreateModerationTables',
    '20261913_create_ai_tables.php' => 'CreateAiTables',
];

foreach ($migrationMapping as $file => $class) {
    $path = __DIR__ . '/migrations/' . $file;
    if (!file_exists($path)) {
        echo "[ ] $file not found, skipping.\n";
        continue;
    }
    require_once $path;
    if (!class_exists($class)) {
        echo "[✗] Class $class not found in $file.\n";
        continue;
    }
    try {
        $class::up($pdo);
        echo "[✓] $class\n";
    } catch (\PDOException $e) {
        echo "[i] $class: " . $e->getMessage() . "\n";
    }
}

// ─── Step 3: Seed categories ────────────────────────────────────

echo "\n─── Step 3: Categories ───\n";

$categories = [
    ['name' => 'Action',    'slug' => 'action',    'type' => 'both',      'icon' => 'gamepad',     'color' => '#F44336'],
    ['name' => 'Strategy',  'slug' => 'strategy',  'type' => 'both',      'icon' => 'chess',       'color' => '#9B5DE5'],
    ['name' => 'RPG',       'slug' => 'rpg',       'type' => 'challenge', 'icon' => 'dragon',      'color' => '#00BCD4'],
    ['name' => 'FPS',       'slug' => 'fps',       'type' => 'stream',    'icon' => 'crosshairs',  'color' => '#4CAF50'],
    ['name' => 'Racing',    'slug' => 'racing',    'type' => 'stream',    'icon' => 'car',         'color' => '#FF9800'],
    ['name' => 'Creative',  'slug' => 'creative',  'type' => 'both',      'icon' => 'paint-brush', 'color' => '#F15BB5'],
    ['name' => 'Horror',    'slug' => 'horror',    'type' => 'stream',    'icon' => 'ghost',       'color' => '#212121'],
    ['name' => 'Puzzle',    'slug' => 'puzzle',    'type' => 'challenge', 'icon' => 'puzzle-piece','color' => '#E91E63'],
];

$catStmt = $pdo->prepare("INSERT IGNORE INTO categories (name, slug, type, icon, color, is_active) VALUES (?, ?, ?, ?, ?, 1)");
foreach ($categories as $cat) {
    $catStmt->execute([$cat['name'], $cat['slug'], $cat['type'], $cat['icon'], $cat['color']]);
    echo "[✓] Category: {$cat['name']}\n";
}

// ─── Step 4: Seed badges ───────────────────────────────────────

echo "\n─── Step 4: Badges ───\n";

$badges = [
    ['name' => 'Rising Star',     'slug' => 'rising-star',     'desc' => 'Complète 5 défis',         'criteria_type' => 'challenge_count', 'criteria_value' => 5,  'xp_reward' => 200, 'color' => '#FFD700'],
    ['name' => 'Veteran',         'slug' => 'veteran',         'desc' => '10 streams terminés',       'criteria_type' => 'stream_count',    'criteria_value' => 10, 'xp_reward' => 500, 'color' => '#F44336'],
    ['name' => 'Social Butterfly','slug' => 'social-butterfly','desc' => 'Atteins 50 abonnés',        'criteria_type' => 'follower_count',  'criteria_value' => 50, 'xp_reward' => 300, 'color' => '#9B5DE5'],
    ['name' => 'Dedicated',       'slug' => 'dedicated',       'desc' => 'Niveau 10 atteint',         'criteria_type' => 'xp_level',        'criteria_value' => 10, 'xp_reward' => 1000,'color' => '#00BCD4'],
    ['name' => 'Consistent',      'slug' => 'consistent',      'desc' => '7 jours de streak',         'criteria_type' => 'streak',          'criteria_value' => 7,  'xp_reward' => 150, 'color' => '#4CAF50'],
    ['name' => 'Legend',          'slug' => 'legend',          'desc' => 'Badge légendaire spécial',  'criteria_type' => 'special',         'criteria_value' => 1,  'xp_reward' => 999, 'color' => '#FFD700'],
];

$badgeStmt = $pdo->prepare("INSERT IGNORE INTO badges (name, slug, description, criteria_type, criteria_value, xp_reward, color, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
foreach ($badges as $b) {
    $badgeStmt->execute([$b['name'], $b['slug'], $b['desc'], $b['criteria_type'], $b['criteria_value'], $b['xp_reward'], $b['color']]);
    echo "[✓] Badge: {$b['name']} ({$b['xp_reward']} XP)\n";
}

// ─── Step 5: Test users ─────────────────────────────────────────

echo "\n─── Step 5: Test users ───\n";

$users = [
    ['username' => 'testuser',     'email' => 'user@senex.test',     'password' => 'password123', 'role' => 'user'],
    ['username' => 'testadmin',    'email' => 'admin@senex.test',    'password' => 'admin123',    'role' => 'admin'],
    ['username' => 'teststreamer', 'email' => 'streamer@senex.test', 'password' => 'stream123',   'role' => 'streamer'],
];

$insertUser = $pdo->prepare("INSERT IGNORE INTO users (username, email, password, role, active, created_at) VALUES (?, ?, ?, ?, 1, NOW())");
$insertProfile = $pdo->prepare("INSERT IGNORE INTO user_profiles (user_id) VALUES (?)");

foreach ($users as $u) {
    $hash = password_hash($u['password'], PASSWORD_BCRYPT);
    try {
        $insertUser->execute([$u['username'], $u['email'], $hash, $u['role']]);
        $userId = $pdo->lastInsertId();
        if ($userId && $userId !== '0') {
            $insertProfile->execute([$userId]);
            echo "[✓] {$u['username']} ({$u['role']})\n";
        } else {
            echo "[i] {$u['username']} already exists.\n";
        }
    } catch (\PDOException $e) {
        echo "[✗] {$u['username']}: " . $e->getMessage() . "\n";
    }
}

// ─── Summary ────────────────────────────────────────────────────

echo "\n===============================\n";
echo "   Seeding complete!\n";
echo "===============================\n";
echo "\n";
echo "   Test accounts:\n";
echo "   ┌───────────────┬──────────────────────┬──────────────┐\n";
echo "   │ Username       │ Email                │ Password     │\n";
echo "   ├───────────────┼──────────────────────┼──────────────┤\n";
echo "   │ testuser      │ user@senex.test      │ password123  │\n";
echo "   │ teststreamer  │ streamer@senex.test  │ stream123    │\n";
echo "   │ testadmin     │ admin@senex.test     │ admin123     │\n";
echo "   └───────────────┴──────────────────────┴──────────────┘\n";
echo "\n";
echo "   Dashboards:\n";
echo "   - User     → /dashboard\n";
echo "   - Streamer → /streamer\n";
echo "   - Admin    → /admin\n";
echo "\n";
