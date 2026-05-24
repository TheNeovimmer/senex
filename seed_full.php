<?php
/**
 * SENEX - Comprehensive Test Seeder
 *
 * Run AFTER seed.php: php seed_full.php
 *
 * Seeds 17 tables with realistic test data covering ALL use cases.
 * Idempotent — safe to run multiple times (uses INSERT IGNORE).
 *
 * Test accounts added by this script:
 *   streamer_luna  / streamer_luna@senex.test  / password123
 *   streamer_neo   / streamer_neo@senex.test   / password123
 *   user_camille   / user_camille@senex.test    / password123
 *   user_leo       / user_leo@senex.test        / password123
 *   user_sarah     / user_sarah@senex.test      / password123
 *   banned_user    / banned_user@senex.test     / password123
 *   inactive_user  / inactive_user@senex.test   / password123
 *
 * All existing accounts (testuser, teststreamer, testadmin) also get
 * updated profiles and additional data.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Config/Database.php';

echo "========================================\n";
echo "   SENEX Comprehensive Test Seeder\n";
echo "========================================\n\n";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $pdo = \Config\Database::getConnection();
    echo "[✓] Database connected.\n\n";
} catch (\Exception $e) {
    die("[✗] Connection failed: " . $e->getMessage() . "\n");
}

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

// ─── Helpers ──────────────────────────────────────────────────────

function userId(PDO $pdo, string $username): ?int {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['id'] : null;
}

function categoryId(PDO $pdo, string $slug): ?int {
    $stmt = $pdo->prepare("SELECT id FROM categories WHERE slug = ?");
    $stmt->execute([$slug]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['id'] : null;
}

function badgeId(PDO $pdo, string $slug): ?int {
    $stmt = $pdo->prepare("SELECT id FROM badges WHERE slug = ?");
    $stmt->execute([$slug]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['id'] : null;
}

function password(string $plain): string {
    return password_hash($plain, PASSWORD_BCRYPT);
}

// Predefined password hash for re-use (saves CPU on re-runs)
$COMMON_HASH = password_hash('password123', PASSWORD_BCRYPT);

// ──────────────────────────────────────────────────────────────────
// STEP 1: Additional test users
// ──────────────────────────────────────────────────────────────────
echo "─── Step 1: Additional users ───\n";

$extraUsers = [
    // Streamers
    ['username' => 'streamer_luna',  'email' => 'streamer_luna@senex.test',  'display_name' => 'Luna Fox',      'role' => 'streamer', 'is_active' => 1, 'is_banned' => 0],
    ['username' => 'streamer_neo',   'email' => 'streamer_neo@senex.test',   'display_name' => 'Neo Phantom',   'role' => 'streamer', 'is_active' => 1, 'is_banned' => 0],
    // Regular users
    ['username' => 'user_camille',   'email' => 'user_camille@senex.test',   'display_name' => 'Camille Rose',  'role' => 'user',     'is_active' => 1, 'is_banned' => 0],
    ['username' => 'user_leo',       'email' => 'user_leo@senex.test',       'display_name' => 'Leo Hart',      'role' => 'user',     'is_active' => 1, 'is_banned' => 0],
    ['username' => 'user_sarah',     'email' => 'user_sarah@senex.test',     'display_name' => 'Sarah Blue',    'role' => 'user',     'is_active' => 1, 'is_banned' => 0],
    // Edge-case users
    ['username' => 'banned_user',    'email' => 'banned_user@senex.test',    'display_name' => 'Banned User',   'role' => 'user',     'is_active' => 1, 'is_banned' => 1],
    ['username' => 'inactive_user',  'email' => 'inactive_user@senex.test',  'display_name' => null,            'role' => 'user',     'is_active' => 0, 'is_banned' => 0],
];

$insertUser = $pdo->prepare(
    "INSERT IGNORE INTO users (username, email, password, role, active, is_active, is_banned, avatar_url, display_name, last_login, created_at)
     VALUES (?, ?, ?, ?, 1, ?, ?, NULL, ?, NOW(), NOW())"
);

foreach ($extraUsers as $u) {
    try {
        $insertUser->execute([$u['username'], $u['email'], $COMMON_HASH, $u['role'], $u['is_active'], $u['is_banned'], $u['display_name']]);
        echo "[✓] {$u['username']} ({$u['role']})\n";
    } catch (\PDOException $e) {
        echo "[i] {$u['username']}: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 2: Update existing test users with display_name and extras
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 2: Update existing users ───\n";

$updateUser = $pdo->prepare("UPDATE users SET is_active = 1, display_name = ? WHERE username = ? AND display_name IS NULL");
$updateUser->execute(['Test Streamer', 'teststreamer']);
$updateUser->execute(['Test Admin', 'testadmin']);
$updateUser->execute(['Test User', 'testuser']);
echo "[✓] Existing user display_names set.\n";

// Also ensure testadmin has streamer role since they access /streamer
$pdo->exec("UPDATE users SET role = 'admin' WHERE username = 'testadmin'");
echo "[✓] testadmin role is admin (also sees streamer dashboard via middleware).\n";

// ──────────────────────────────────────────────────────────────────
// STEP 3: Cache all user IDs for FK references
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 3: Caching IDs ───\n";

$userIds = [];
$usernames = ['testuser', 'teststreamer', 'testadmin', 'streamer_luna', 'streamer_neo', 'user_camille', 'user_leo', 'user_sarah', 'banned_user', 'inactive_user'];
foreach ($usernames as $name) {
    $id = userId($pdo, $name);
    if ($id) {
        $userIds[$name] = $id;
        echo "[ ] $name → ID $id\n";
    } else {
        echo "[✗] $name NOT FOUND\n";
    }
}

$catIds = [];
$catSlugs = ['action', 'strategy', 'rpg', 'fps', 'racing', 'creative', 'horror', 'puzzle'];
foreach ($catSlugs as $slug) {
    $id = categoryId($pdo, $slug);
    if ($id) $catIds[$slug] = $id;
}

$badgeSlugs = ['rising-star', 'veteran', 'social-butterfly', 'dedicated', 'consistent', 'legend'];
$badgeIds = [];
foreach ($badgeSlugs as $slug) {
    $id = badgeId($pdo, $slug);
    if ($id) $badgeIds[$slug] = $id;
}

$TU  = $userIds['testuser'];
$TS  = $userIds['teststreamer'];
$TA  = $userIds['testadmin'];
$LU  = $userIds['streamer_luna'];
$NE  = $userIds['streamer_neo'];
$CA  = $userIds['user_camille'];
$LE  = $userIds['user_leo'];
$SA  = $userIds['user_sarah'];
$BU  = $userIds['banned_user'];
$IU  = $userIds['inactive_user'];

// Categories
$ACT = $catIds['action'];
$STR = $catIds['strategy'];
$RPG = $catIds['rpg'];
$FPS = $catIds['fps'];
$RAC = $catIds['racing'];
$CRE = $catIds['creative'];
$HOR = $catIds['horror'];
$PUZ = $catIds['puzzle'];

// Badges
$RS  = $badgeIds['rising-star'];
$VET = $badgeIds['veteran'];
$SB  = $badgeIds['social-butterfly'];
$DED = $badgeIds['dedicated'];
$CON = $badgeIds['consistent'];
$LEG = $badgeIds['legend'];

// ──────────────────────────────────────────────────────────────────
// STEP 4: Update user_profiles with realistic data
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 4: User profiles ───\n";

$profileStmt = $pdo->prepare("
    INSERT INTO user_profiles (user_id, bio, skills, social_links, banner_url, experience_points, level, popularity_score, total_challenges, total_streams, total_followers, streak_days)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        bio = VALUES(bio),
        skills = VALUES(skills),
        social_links = VALUES(social_links),
        experience_points = VALUES(experience_points),
        level = VALUES(level),
        popularity_score = VALUES(popularity_score),
        total_challenges = VALUES(total_challenges),
        total_streams = VALUES(total_streams),
        total_followers = VALUES(total_followers),
        streak_days = VALUES(streak_days)
");

$profiles = [
    [$TU, 'Just a regular user exploring SENEX challenges.',                                          '["quick-learner","team-player"]',                    '{"twitter":"testuser","discord":"testuser#1234"}',              'https://placehold.co/1200x400/1E1E2F/9B5DE5?text=Test+User',       1500, 8,  45.50, 12, 0,  5,  3],
    [$TS, 'Professional streamer bringing you the best live challenges!',                             '["charismatic","strategic","endurance"]',             '{"twitch":"teststreamer","twitter":"teststreamer","youtube":"TestStreamer"}', 'https://placehold.co/1200x400/1E1E2F/F15BB5?text=Test+Streamer', 8500, 15, 92.30, 25, 42, 128, 12],
    [$TA, 'SENEX platform administrator. Keeping the community safe and fun.',                        '["leadership","moderation","technical"]',             '{"discord":"testadmin#admin"}',                                   'https://placehold.co/1200x400/1E1E2F/00BCD4?text=Admin',            12000, 20, 99.90, 5,  0,  0,  30],
    [$LU, 'Creative artist streaming fun challenges. Paint, build, and laugh with me!',               '["creative","improvisation","storytelling"]',         '{"twitch":"lunafox","instagram":"luna.fox","tiktok":"lunafox"}', 'https://placehold.co/1200x400/1E1E2F/F15BB5?text=Luna+Fox',        3200, 10, 75.00, 8,  15, 56, 7],
    [$NE, 'Speedrunner and FPS enthusiast. Watch me break records!',                                  '["reflexes","precision","speed"]',                   '{"twitch":"neophantom","twitter":"neo_phantom"}',                 'https://placehold.co/1200x400/1E1E2F/4CAF50?text=Neo+Phantom',     5600, 13, 88.50, 15, 28, 89, 5],
    [$CA, 'Love watching challenges and supporting my favorite streamers!',                           '["supporter","analytical"]',                         '{"twitter":"camille_rose"}',                                      'https://placehold.co/1200x400/1E1E2F/9B5DE5?text=Camille+Rose',     200,  3,  12.00, 3,  0,  2,  1],
    [$LE, 'Challenge completer. I finish what I start. Currently on a streak!',                       '["dedicated","competitive","strategic"]',            '{"twitter":"leo_hart","discord":"leohart#5678"}',                 'https://placehold.co/1200x400/1E1E2F/FF9800?text=Leo+Hart',        4100, 12, 67.30, 22, 0,  15, 14],
    [$SA, 'New to SENEX! Excited to explore and maybe try my first challenge soon.',                  '["curious","friendly"]',                             '{}',                                                              'https://placehold.co/1200x400/1E1E2F/E91E63?text=Sarah+Blue',       50,   1,  2.00,  0,  0,  0,  0],
    [$BU, 'This profile belongs to a banned user — no content should be visible.',                    '[]',                                                 '{}',                                                              null,                                                                                 0,   1,  0.00,  0,  0,  0,  0],
    [$IU, 'Inactive account.',                                                                        '[]',                                                 '{}',                                                              null,                                                                                 0,   1,  0.00,  0,  0,  0,  0],
];

foreach ($profiles as $p) {
    $profileStmt->execute($p);
}
echo "[✓] " . count($profiles) . " user profiles updated.\n";

// ──────────────────────────────────────────────────────────────────
// STEP 5: Streams
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 5: Streams ───\n";

// Generate unique stream keys
function streamKey(): string {
    return bin2hex(random_bytes(16));
}

$streams = [
    // Live streams (for public streams page, stream detail, chat)
    ['user_id' => $LU, 'category_id' => $CRE, 'title' => "Luna's Creative Hour — Live Art Challenge",
     'description' => 'Join Luna as she takes on creative challenges live! Painting, building, and surprising viewers with artistic dares.',
     'stream_key' => streamKey(), 'status' => 'live',  'viewer_count' => 142, 'peak_viewers' => 189,
     'started_at' => '2026-05-24 14:00:00', 'is_featured' => 1, 'has_replay' => 0],

    ['user_id' => $NE, 'category_id' => $FPS, 'title' => "Neo's Speedrun Marathon — Beating Records",
     'description' => 'Watch Neo attempt to break speedrun records while taking on viewer challenges!',
     'stream_key' => streamKey(), 'status' => 'live',  'viewer_count' => 287, 'peak_viewers' => 341,
     'started_at' => '2026-05-24 15:30:00', 'is_featured' => 1, 'has_replay' => 0],

    ['user_id' => $TS, 'category_id' => $ACT, 'title' => 'Test Streamer Goes Live!',
     'description' => 'Testing the streaming platform with some action-packed challenges.',
     'stream_key' => streamKey(), 'status' => 'live',  'viewer_count' => 53, 'peak_viewers' => 67,
     'started_at' => '2026-05-24 16:00:00', 'is_featured' => 0, 'has_replay' => 0],

    // Ended streams (for replays)
    ['user_id' => $TS, 'category_id' => $STR, 'title' => 'Strategy Showdown — Chess Challenge',
     'description' => 'An intense strategy session where viewers voted on moves.',
     'stream_key' => streamKey(), 'status' => 'ended', 'viewer_count' => 89, 'peak_viewers' => 112,
     'started_at' => '2026-05-22 18:00:00', 'ended_at' => '2026-05-22 20:30:00', 'duration_seconds' => 9000, 'is_featured' => 0, 'has_replay' => 1],

    ['user_id' => $LU, 'category_id' => $CRE, 'title' => 'Midnight Creative Stream — Glow Art',
     'description' => 'Late night creative session with glow-in-the-dark painting challenges.',
     'stream_key' => streamKey(), 'status' => 'ended', 'viewer_count' => 204, 'peak_viewers' => 267,
     'started_at' => '2026-05-21 23:00:00', 'ended_at' => '2026-05-22 01:45:00', 'duration_seconds' => 9900, 'is_featured' => 1, 'has_replay' => 1],

    ['user_id' => $NE, 'category_id' => $RAC, 'title' => 'Racing Night — Viewer Choice Tracks',
     'description' => 'Viewers picked the tracks and Neo raced against the clock.',
     'stream_key' => streamKey(), 'status' => 'ended', 'viewer_count' => 156, 'peak_viewers' => 198,
     'started_at' => '2026-05-20 20:00:00', 'ended_at' => '2026-05-20 22:15:00', 'duration_seconds' => 8100, 'is_featured' => 0, 'has_replay' => 1],

    // Scheduled stream
    ['user_id' => $LU, 'category_id' => $CRE, 'title' => 'Weekend Special — Community Art Project',
     'description' => 'A special weekend stream where the community creates art together. Everyone votes on the next piece!',
     'stream_key' => streamKey(), 'status' => 'scheduled', 'viewer_count' => 0, 'peak_viewers' => 0,
     'scheduled_at' => '2026-05-28 16:00:00', 'is_featured' => 0, 'has_replay' => 0],

    // Cancelled stream
    ['user_id' => $NE, 'category_id' => $HOR, 'title' => 'Horror Night — Cancelled',
     'description' => 'Was going to be a horror game marathon but got cancelled due to technical issues.',
     'stream_key' => streamKey(), 'status' => 'cancelled', 'viewer_count' => 0, 'peak_viewers' => 0,
     'scheduled_at' => '2026-05-19 21:00:00', 'is_featured' => 0, 'has_replay' => 0],
];

$insertStream = $pdo->prepare("
    INSERT IGNORE INTO streams (user_id, category_id, title, description, stream_key, status, viewer_count, peak_viewers, scheduled_at, started_at, ended_at, duration_seconds, is_featured, has_replay)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$streamIds = [];
foreach ($streams as $s) {
    try {
        $insertStream->execute([
            $s['user_id'], $s['category_id'], $s['title'], $s['description'],
            $s['stream_key'], $s['status'], $s['viewer_count'], $s['peak_viewers'],
            $s['scheduled_at'] ?? null, $s['started_at'] ?? null, $s['ended_at'] ?? null,
            $s['duration_seconds'] ?? 0, $s['is_featured'], $s['has_replay']
        ]);
        $sid = $pdo->lastInsertId();
        if ($sid && $sid !== '0') {
            $streamIds[] = (int)$sid;
            echo "[✓] {$s['title']} ({$s['status']}) → ID $sid\n";
        }
    } catch (\PDOException $e) {
        echo "[i] {$s['title']}: {$e->getMessage()}\n";
    }
}

// Map stream titles to IDs for reference
function streamIdByTitle(PDO $pdo, string $title): ?int {
    $stmt = $pdo->prepare("SELECT id FROM streams WHERE title LIKE ? ORDER BY id DESC LIMIT 1");
    $stmt->execute(["$title%"]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['id'] : null;
}

$S_LUNA_LIVE     = streamIdByTitle($pdo, "Luna's Creative Hour");
$S_NEO_LIVE      = streamIdByTitle($pdo, "Neo's Speedrun Marathon");
$S_TS_LIVE       = streamIdByTitle($pdo, "Test Streamer Goes Live");
$S_STRATEGY      = streamIdByTitle($pdo, "Strategy Showdown");
$S_GLOW_ART      = streamIdByTitle($pdo, "Midnight Creative Stream");
$S_RACING        = streamIdByTitle($pdo, "Racing Night");
$S_SCHEDULED     = streamIdByTitle($pdo, "Weekend Special");
$S_CANCELLED     = streamIdByTitle($pdo, "Horror Night");

// ──────────────────────────────────────────────────────────────────
// STEP 6: Challenges
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 6: Challenges ───\n";

$challenges = [
    ['user_id' => $LU, 'category_id' => $CRE, 'title' => 'Glow Art Battle',
     'description' => 'Create the most stunning glow-in-the-dark artwork in 10 minutes! Viewers vote on the winner.',
     'rules' => 'Use only the provided glow materials. No digital tools. Must be completed within time limit.',
     'difficulty' => 'easy', 'type' => 'viewer', 'duration_seconds' => 600, 'xp_reward' => 150,
     'status' => 'active', 'is_featured' => 1],

    ['user_id' => $NE, 'category_id' => $ACT, 'title' => 'Precision Shot Challenge',
     'description' => 'Hit 10 targets from increasing distances. Each miss costs 5 seconds. Beat the clock!',
     'rules' => 'Stand behind the marked line. One shot per target. Time starts on first shot.',
     'difficulty' => 'hard', 'type' => 'solo', 'duration_seconds' => 120, 'xp_reward' => 300,
     'status' => 'active', 'is_featured' => 1],

    ['user_id' => $TS, 'category_id' => $STR, 'title' => 'Team Escape Room',
     'description' => 'Form teams of 3 and solve puzzles to escape the room within 30 minutes.',
     'rules' => 'Teams must stay together. Use hints sparingly — each hint costs 2 minutes.',
     'difficulty' => 'extreme', 'type' => 'team', 'duration_seconds' => 1800, 'xp_reward' => 500,
     'status' => 'active', 'is_featured' => 1],

    ['user_id' => $LU, 'category_id' => $CRE, 'title' => 'Viewer Trivia Takeover',
     'description' => 'Viewers submit trivia questions and the streamer must answer them live!',
     'rules' => 'Questions must be appropriate. Streamer has 10 seconds per question. 3 wrong answers = challenge lost.',
     'difficulty' => 'medium', 'type' => 'viewer', 'duration_seconds' => 900, 'xp_reward' => 200,
     'status' => 'active', 'is_featured' => 0],

    ['user_id' => $NE, 'category_id' => $FPS, 'title' => 'Speedrun Showdown',
     'description' => 'Race through the course as fast as possible. Record your best time!',
     'rules' => 'Any route is valid. No glitches. Time stops when you cross the finish line.',
     'difficulty' => 'hard', 'type' => 'solo', 'duration_seconds' => 300, 'xp_reward' => 400,
     'status' => 'completed', 'is_featured' => 0],

    ['user_id' => $TS, 'category_id' => $PUZ, 'title' => 'Treasure Hunt',
     'description' => 'Follow clues around the map to find the hidden treasure. First to find it wins!',
     'rules' => 'Clues are revealed every 5 minutes. Work together or compete — your choice.',
     'difficulty' => 'medium', 'type' => 'team', 'duration_seconds' => 3600, 'xp_reward' => 350,
     'status' => 'completed', 'is_featured' => 0],

    ['user_id' => $LU, 'category_id' => $CRE, 'title' => 'Dance-Off Duel',
     'description' => 'Two contestants battle in a dance-off. Viewers vote on the winner in real-time.',
     'rules' => 'Each round lasts 60 seconds. Most creative moves win. Audience decides the champion.',
     'difficulty' => 'easy', 'type' => 'solo', 'duration_seconds' => 180, 'xp_reward' => 100,
     'status' => 'cancelled', 'is_featured' => 0],

    ['user_id' => $NE, 'category_id' => $CRE, 'title' => 'Blindfolded Cooking Challenge',
     'description' => 'Cook a complete meal while blindfolded! Viewers guide you with their instructions.',
     'rules' => 'No peeking! Ingredients are pre-measured. Use only the tools provided.',
     'difficulty' => 'extreme', 'type' => 'viewer', 'duration_seconds' => 1800, 'xp_reward' => 600,
     'status' => 'active', 'is_featured' => 1],
];

$insertChallenge = $pdo->prepare("
    INSERT IGNORE INTO challenges (user_id, category_id, title, description, rules, difficulty, type, duration_seconds, xp_reward, status, is_featured)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$challengeIds = [];
foreach ($challenges as $c) {
    try {
        $insertChallenge->execute([
            $c['user_id'], $c['category_id'], $c['title'], $c['description'],
            $c['rules'], $c['difficulty'], $c['type'],
            $c['duration_seconds'], $c['xp_reward'], $c['status'], $c['is_featured']
        ]);
        $cid = $pdo->lastInsertId();
        if ($cid && $cid !== '0') {
            $challengeIds[] = (int)$cid;
            echo "[✓] {$c['title']} ({$c['difficulty']}, {$c['status']})\n";
        }
    } catch (\PDOException $e) {
        echo "[i] {$c['title']}: {$e->getMessage()}\n";
    }
}

function challengeIdByTitle(PDO $pdo, string $title): ?int {
    $stmt = $pdo->prepare("SELECT id FROM challenges WHERE title LIKE ? ORDER BY id DESC LIMIT 1");
    $stmt->execute(["$title%"]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['id'] : null;
}

$C_GLOW_ART     = challengeIdByTitle($pdo, "Glow Art Battle");
$C_PRECISION    = challengeIdByTitle($pdo, "Precision Shot Challenge");
$C_ESCAPE       = challengeIdByTitle($pdo, "Team Escape Room");
$C_TRIVIA       = challengeIdByTitle($pdo, "Viewer Trivia Takeover");
$C_SPEEDRUN     = challengeIdByTitle($pdo, "Speedrun Showdown");
$C_TREASURE     = challengeIdByTitle($pdo, "Treasure Hunt");
$C_DANCE        = challengeIdByTitle($pdo, "Dance-Off Duel");
$C_COOKING      = challengeIdByTitle($pdo, "Blindfolded Cooking Challenge");

// ──────────────────────────────────────────────────────────────────
// STEP 7: Stream-Challenge associations
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 7: Stream-Challenge associations ───\n";

$streamChallenges = [
    // Active challenges on live streams
    [$S_LUNA_LIVE, $C_GLOW_ART,  1, '2026-05-24 14:05:00', null],
    [$S_NEO_LIVE,  $C_PRECISION, 1, '2026-05-24 15:35:00', null],
    [$S_TS_LIVE,   $C_ESCAPE,    1, '2026-05-24 16:05:00', null],
    // Completed challenges (on ended streams)
    [$S_STRATEGY,  $C_ESCAPE,    0, '2026-05-22 18:05:00', '2026-05-22 18:35:00'],
    [$S_GLOW_ART,  $C_GLOW_ART,  0, '2026-05-21 23:30:00', '2026-05-21 23:40:00'],
    // Active challenge on scheduled stream (prepared)
    [$S_SCHEDULED, $C_TRIVIA,    1, null, null],
];

$pdo->exec("DELETE FROM stream_challenges");

$insertSC = $pdo->prepare("
    INSERT INTO stream_challenges (stream_id, challenge_id, is_active, started_at, ended_at)
    VALUES (?, ?, ?, ?, ?)
");

foreach ($streamChallenges as $sc) {
    try {
        $insertSC->execute($sc);
        echo "[✓] Stream {$sc[0]} ↔ Challenge {$sc[1]} (active: {$sc[2]})\n";
    } catch (\PDOException $e) {
        echo "[i] Stream {$sc[0]} ↔ Challenge {$sc[1]}: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 8: Replays (from ended streams)
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 8: Replays ───\n";

$replays = [
    ['stream_id' => $S_STRATEGY, 'title' => 'Strategy Showdown — Full VOD',
     'description' => 'Complete replay of the Strategy Showdown chess challenge. Watch the full match!',
     'video_url' => 'https://placehold.co/640x360/1E1E2F/F15BB5?text=Replay+Strategy',
     'thumbnail_url' => 'https://placehold.co/400x225/1E1E2F/9B5DE5?text=Strategy+Showdown',
     'duration_seconds' => 9000, 'view_count' => 1245, 'is_published' => 1],

    ['stream_id' => $S_GLOW_ART, 'title' => 'Glow Art — Midnight Special',
     'description' => 'Watch the amazing glow-in-the-dark art created during the midnight stream.',
     'video_url' => 'https://placehold.co/640x360/1E1E2F/F15BB5?text=Replay+Glow+Art',
     'thumbnail_url' => 'https://placehold.co/400x225/1E1E2F/F15BB5?text=Glow+Art',
     'duration_seconds' => 9900, 'view_count' => 3210, 'is_published' => 1],

    ['stream_id' => $S_RACING, 'title' => 'Racing Night — Best Moments',
     'description' => 'Full replay of the viewer-choice racing night. See the closest finishes!',
     'video_url' => 'https://placehold.co/640x360/1E1E2F/F15BB5?text=Replay+Racing',
     'thumbnail_url' => 'https://placehold.co/400x225/1E1E2F/FF9800?text=Racing+Night',
     'duration_seconds' => 8100, 'view_count' => 876, 'is_published' => 1],

    ['stream_id' => $S_STRATEGY, 'title' => 'Strategy Post-Game Analysis',
     'description' => 'Deep dive analysis of the key moments from the Strategy Showdown.',
     'video_url' => 'https://placehold.co/640x360/1E1E2F/F15BB5?text=Replay+Analysis',
     'thumbnail_url' => 'https://placehold.co/400x225/1E1E2F/00BCD4?text=Strategy+Analysis',
     'duration_seconds' => 3600, 'view_count' => 543, 'is_published' => 0], // unpublished — edge case
];

$insertReplay = $pdo->prepare("
    INSERT IGNORE INTO replays (stream_id, title, description, video_url, thumbnail_url, duration_seconds, view_count, is_published, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, DATE_SUB(NOW(), INTERVAL ? DAY))
");

foreach ($replays as $i => $r) {
    try {
        $insertReplay->execute([
            $r['stream_id'], $r['title'], $r['description'], $r['video_url'],
            $r['thumbnail_url'], $r['duration_seconds'], $r['view_count'], $r['is_published'],
            $i + 1
        ]);
        echo "[✓] {$r['title']}\n";
    } catch (\PDOException $e) {
        echo "[i] {$r['title']}: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 9: Highlights
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 9: Highlights ───\n";

$highlights = [
    ['stream_id' => $S_LUNA_LIVE, 'title' => 'Luna Creates an Epic Glow Dragon',
     'description' => 'Watch Luna create her most ambitious glow art piece — a dragon!',
     'video_url' => 'https://placehold.co/640x360/1E1E2F/F15BB5?text=Highlight+Dragon',
     'thumbnail_url' => 'https://placehold.co/400x225/1E1E2F/9B5DE5?text=Epic+Dragon',
     'start_time_seconds' => 1200, 'end_time_seconds' => 1500, 'view_count' => 892],

    ['stream_id' => $S_NEO_LIVE, 'title' => 'Neo Beats His Own Record!',
     'description' => 'Incredible moment — Neo breaks his personal speedrun record by 2 seconds!',
     'video_url' => 'https://placehold.co/640x360/1E1E2F/F15BB5?text=Highlight+Record',
     'thumbnail_url' => 'https://placehold.co/400x225/1E1E2F/4CAF50?text=New+Record',
     'start_time_seconds' => 2400, 'end_time_seconds' => 2700, 'view_count' => 1567],

    ['stream_id' => $S_GLOW_ART, 'title' => 'Glow Art Reveal — Audience Reaction',
     'description' => 'The moment the lights go out and the glow art is revealed. Amazing audience reaction!',
     'video_url' => 'https://placehold.co/640x360/1E1E2F/F15BB5?text=Highlight+Reveal',
     'thumbnail_url' => 'https://placehold.co/400x225/1E1E2F/F15BB5?text=Glow+Reveal',
     'start_time_seconds' => 8000, 'end_time_seconds' => 8300, 'view_count' => 2340],
];

$insertHighlight = $pdo->prepare("
    INSERT IGNORE INTO highlights (stream_id, title, description, video_url, thumbnail_url, start_time_seconds, end_time_seconds, view_count)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

foreach ($highlights as $h) {
    try {
        $insertHighlight->execute([$h['stream_id'], $h['title'], $h['description'], $h['video_url'],
                                    $h['thumbnail_url'], $h['start_time_seconds'], $h['end_time_seconds'], $h['view_count']]);
        echo "[✓] {$h['title']}\n";
    } catch (\PDOException $e) {
        echo "[i] {$h['title']}: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 10: Chat messages (for live streams)
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 10: Chat messages ───\n";

$chatMessages = [
    // Luna's creative live stream chat
    [$S_LUNA_LIVE, $LU, 'Welcome everyone to the creative stream! 🎨'],
    [$S_LUNA_LIVE, $CA, 'Luna you are so talented!'],
    [$S_LUNA_LIVE, $LE, 'What colors are you using today?'],
    [$S_LUNA_LIVE, $SA, 'First time watching a creative stream, this is amazing!'],
    [$S_LUNA_LIVE, $LU, 'We are doing a glow art battle today. Who wants to vote for the winner?'],
    [$S_LUNA_LIVE, $CA, 'I vote for the dragon design!'],
    [$S_LUNA_LIVE, $LE, 'The galaxy pattern looks incredible too'],
    // Neo's speedrun marathon chat
    [$S_NEO_LIVE, $NE, 'Let us gooo! Speedrun time! 🚀'],
    [$S_NEO_LIVE, $LE, 'Beat that record Neo!'],
    [$S_NEO_LIVE, $CA, 'Current record is 45.2s right?'],
    [$S_NEO_LIVE, $NE, 'Yes, 45.2 seconds. Let us see if we can break 44!'],
    [$S_NEO_LIVE, $LE, 'That would be insane!'],
    [$S_NEO_LIVE, $SA, 'GO NEO GO! 🔥'],
    // Test streamer chat
    [$S_TS_LIVE, $TS, 'Test stream is live! Testing all the features.'],
    [$S_TS_LIVE, $TA, 'System looks good. Chat is working.'],
    [$S_TS_LIVE, $TS, 'Let me check the challenge integration...'],
];

$pdo->exec("DELETE FROM chat_messages");

$insertChat = $pdo->prepare("
    INSERT INTO chat_messages (stream_id, user_id, message, created_at)
    VALUES (?, ?, ?, DATE_SUB(NOW(), INTERVAL ? MINUTE))
");

foreach ($chatMessages as $i => $m) {
    try {
        $insertChat->execute([$m[0], $m[1], $m[2], count($chatMessages) - $i]);
    } catch (\PDOException $e) {
        // skip
    }
}
echo "[✓] " . count($chatMessages) . " chat messages inserted.\n";

// ──────────────────────────────────────────────────────────────────
// STEP 11: Follows
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 11: Follows ───\n";

$follows = [
    // Users follow streamers
    [$CA, $LU], [$CA, $NE], [$CA, $TS],
    [$LE, $LU], [$LE, $NE],
    [$SA, $LU],
    [$TU, $TS], [$TU, $LU],
    // Streamer follows another streamer
    [$LU, $NE], [$NE, $LU],
    // Admin follows nobody (but follows can go either way)
    [$TA, $TS],
    // Inactive user follows
    [$IU, $LU],
    // Banned user follows (banned but follow relation may still exist)
    [$BU, $NE],
];

$insertFollow = $pdo->prepare("INSERT IGNORE INTO follows (follower_id, following_id) VALUES (?, ?)");
$followCount = 0;
foreach ($follows as $f) {
    try {
        $insertFollow->execute([$f[0], $f[1]]);
        $followCount++;
    } catch (\PDOException $e) {
        // skip
    }
}
echo "[✓] $followCount follow relationships.\n";

// Update user_profiles total_followers (denormalized)
$pdo->exec("UPDATE user_profiles SET total_followers = (SELECT COUNT(*) FROM follows WHERE following_id = user_profiles.user_id)");
echo "[✓] Follower counts updated.\n";

// ──────────────────────────────────────────────────────────────────
// STEP 12: User badges
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 12: User badges ───\n";

$userBadges = [
    // Luna — Rising Star, Social Butterfly
    [$LU, $RS, 1], [$LU, $SB, 1],
    // Neo — Rising Star, Veteran, Dedicated
    [$NE, $RS, 1], [$NE, $VET, 1], [$NE, $DED, 1],
    // Test Streamer — all badges
    [$TS, $RS, 1], [$TS, $VET, 1], [$TS, $SB, 1], [$TS, $DED, 1], [$TS, $CON, 1], [$TS, $LEG, 1],
    // Leo — Rising Star, Consistent
    [$LE, $RS, 1], [$LE, $CON, 1],
    // Camille — Rising Star
    [$CA, $RS, 1],
    // Admin — Legend
    [$TA, $LEG, 1],
];

$insertUB = $pdo->prepare("INSERT IGNORE INTO user_badges (user_id, badge_id, is_displayed) VALUES (?, ?, ?)");
$ubCount = 0;
foreach ($userBadges as $ub) {
    try {
        $insertUB->execute([$ub[0], $ub[1], $ub[2]]);
        $ubCount++;
    } catch (\PDOException $e) {
        // skip duplicates
    }
}
echo "[✓] $ubCount badge assignments.\n";

// ──────────────────────────────────────────────────────────────────
// STEP 13: Challenge attempts
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 13: Challenge attempts ───\n";

$attempts = [
    // Leo completed the Speedrun Showdown (completed challenge)
    ['user_id' => $LE, 'challenge_id' => $C_SPEEDRUN, 'stream_id' => null, 'score' => 85, 'completed' => 1, 'time_taken_seconds' => 240, 'details' => '{"attempts":3,"best_route":"shortcut_a"}'],
    // Leo completed Treasure Hunt
    ['user_id' => $LE, 'challenge_id' => $C_TREASURE, 'stream_id' => null, 'score' => 92, 'completed' => 1, 'time_taken_seconds' => 2800, 'details' => '{"hints_used":2,"treasure_found":true}'],
    // Camille attempted but didn't complete Precision Shot
    ['user_id' => $CA, 'challenge_id' => $C_PRECISION, 'stream_id' => $S_NEO_LIVE, 'score' => 45, 'completed' => 0, 'time_taken_seconds' => null, 'details' => '{"hits":4,"misses":6}'],
    // Test User completed Trivia Takeover
    ['user_id' => $TU, 'challenge_id' => $C_TRIVIA, 'stream_id' => $S_LUNA_LIVE, 'score' => 70, 'completed' => 1, 'time_taken_seconds' => 800, 'details' => '{"correct":7,"wrong":3,"fastest_answer":3}'],
    // Sarah's first attempt — Glow Art Battle (in progress, not completed)
    ['user_id' => $SA, 'challenge_id' => $C_GLOW_ART, 'stream_id' => $S_LUNA_LIVE, 'score' => null, 'completed' => 0, 'time_taken_seconds' => null, 'details' => null],
];

$insertAttempt = $pdo->prepare("
    INSERT IGNORE INTO challenge_attempts (user_id, challenge_id, stream_id, score, completed, time_taken_seconds, details, started_at, ended_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, DATE_SUB(NOW(), INTERVAL ? DAY), CASE WHEN ? = 1 THEN DATE_SUB(NOW(), INTERVAL ? DAY) END)
");

foreach ($attempts as $i => $a) {
    try {
        $insertAttempt->execute([
            $a['user_id'], $a['challenge_id'], $a['stream_id'], $a['score'],
            $a['completed'], $a['time_taken_seconds'],
            $a['details'] ? json_encode($a['details']) : null,
            $i + 1, $a['completed'], $i + 1
        ]);
        echo "[✓] User {$a['user_id']} → Challenge {$a['challenge_id']} (completed: {$a['completed']})\n";
    } catch (\PDOException $e) {
        echo "[i] User {$a['user_id']} → Challenge {$a['challenge_id']}: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 14: Viewer interactions (on challenge attempts)
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 14: Viewer interactions ───\n";

// Get the challenge_attempt IDs we just created
$attemptStmt = $pdo->query("SELECT id, user_id, challenge_id FROM challenge_attempts ORDER BY id DESC LIMIT " . count($attempts));
$attemptRows = $attemptStmt->fetchAll(PDO::FETCH_ASSOC);
$attemptIds = array_reverse($attemptRows); // reverse so they match our insert order

$interactions = [];
// If we have the first attempt (Leo, Speedrun)
if (isset($attemptIds[0])) {
    $interactions[] = ['user_id' => $CA, 'challenge_attempt_id' => $attemptIds[0]['id'], 'interaction_type' => 'vote', 'interaction_data' => '{"vote":"speed","reason":"fastest_route"}'];
    $interactions[] = ['user_id' => $SA, 'challenge_attempt_id' => $attemptIds[0]['id'], 'interaction_type' => 'clue', 'interaction_data' => '{"clue":"try_the_shortcut","cost":2}'];
}
// Camille's attempt on Precision Shot — viewer gave time_add
if (isset($attemptIds[2])) {
    $interactions[] = ['user_id' => $LE, 'challenge_attempt_id' => $attemptIds[2]['id'], 'interaction_type' => 'time_add', 'interaction_data' => '{"seconds_added":30,"reason":"encouragement"}'];
}

$pdo->exec("DELETE FROM viewer_interactions");

$insertInteraction = $pdo->prepare("INSERT INTO viewer_interactions (user_id, challenge_attempt_id, interaction_type, interaction_data) VALUES (?, ?, ?, ?)");
foreach ($interactions as $int) {
    try {
        $insertInteraction->execute([$int['user_id'], $int['challenge_attempt_id'], $int['interaction_type'], $int['interaction_data']]);
        echo "[✓] Interaction: {$int['interaction_type']}\n";
    } catch (\PDOException $e) {
        // skip
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 15: Notifications
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 15: Notifications ───\n";

$notifications = [
    // For testuser — unread notifications
    ['user_id' => $TU, 'type' => 'follow',    'title' => 'Nouvel abonné',          'message' => 'Camille Rose a commencé à vous suivre !',                  'link' => '/profile/' . $CA, 'is_read' => 0],
    ['user_id' => $TU, 'type' => 'challenge', 'title' => 'Défi terminé',           'message' => 'Félicitations ! Vous avez terminé le Viewer Trivia Takeover !', 'link' => '/dashboard/challenges', 'is_read' => 0],
    ['user_id' => $TU, 'type' => 'system',    'title' => 'Badge débloqué',         'message' => 'Vous avez débloqué le badge Rising Star !',                'link' => '/profile/' . $TU, 'is_read' => 1],
    // For teststreamer — mix of read/unread
    ['user_id' => $TS, 'type' => 'follow',    'title' => 'Nouvel abonné',          'message' => 'testuser vous suit maintenant !',                          'link' => '/profile/' . $TU, 'is_read' => 0],
    ['user_id' => $TS, 'type' => 'stream',    'title' => 'Stream en ligne',        'message' => 'Votre stream est maintenant en direct !',                  'link' => '/streamer/live/' . $S_TS_LIVE, 'is_read' => 1],
    ['user_id' => $TS, 'type' => 'report',    'title' => 'Signalement reçu',       'message' => 'Un signalement a été traité par l\'administration.',       'link' => '/admin/reports', 'is_read' => 1],
    // For Luna
    ['user_id' => $LU, 'type' => 'follow',    'title' => 'Nouveaux abonnés',       'message' => 'Vous avez 3 nouveaux abonnés cette semaine !',              'link' => '/profile/' . $LU, 'is_read' => 0],
    ['user_id' => $LU, 'type' => 'challenge', 'title' => 'Défi recommandé',        'message' => 'Un nouveau défi "Blindfolded Cooking" est disponible !',      'link' => '/dashboard/challenges', 'is_read' => 0],
    // For Neo
    ['user_id' => $NE, 'type' => 'stream',    'title' => 'Pic d\'audience',        'message' => 'Nouveau record d\'audience : 341 spectateurs !',             'link' => '/streamer/live/' . $S_NEO_LIVE, 'is_read' => 0],
    // For Camille
    ['user_id' => $CA, 'type' => 'system',    'title' => 'Bienvenue sur SENEX',    'message' => 'Bienvenue parmi nous ! Explorez les défis et amusez-vous !', 'link' => '/', 'is_read' => 0],
];

$insertNotif = $pdo->prepare("
    INSERT IGNORE INTO notifications (user_id, type, title, message, link, is_read, created_at)
    VALUES (?, ?, ?, ?, ?, ?, DATE_SUB(NOW(), INTERVAL ? HOUR))
");

foreach ($notifications as $i => $n) {
    try {
        $insertNotif->execute([$n['user_id'], $n['type'], $n['title'], $n['message'], $n['link'], $n['is_read'], $i + 1]);
        echo "[✓] Notification for user #{$n['user_id']}: {$n['title']}\n";
    } catch (\PDOException $e) {
        // skip
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 16: Reports
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 16: Reports ───\n";

$reports = [
    // Pending report — user reports another user for harassment
    ['reporter_id' => $CA, 'reported_user_id' => $BU, 'stream_id' => null, 'challenge_id' => null,
     'reason' => 'harassment', 'description' => 'This user sent inappropriate messages in chat during the creative stream.', 'status' => 'pending', 'reviewed_by' => null],
    // Reviewed report — spam
    ['reporter_id' => $LE, 'reported_user_id' => $BU, 'stream_id' => null, 'challenge_id' => null,
     'reason' => 'spam', 'description' => 'Spamming links in the chat.', 'status' => 'reviewed', 'reviewed_by' => $TA],
    // Action taken — cheating on a challenge
    ['reporter_id' => $TS, 'reported_user_id' => $TU, 'stream_id' => $S_TS_LIVE, 'challenge_id' => $C_ESCAPE,
     'reason' => 'cheating', 'description' => 'User was found using unauthorized tools during the escape room challenge.', 'status' => 'action_taken', 'reviewed_by' => $TA],
];

$insertReport = $pdo->prepare("
    INSERT IGNORE INTO reports (reporter_id, reported_user_id, stream_id, challenge_id, reason, description, status, reviewed_by, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, DATE_SUB(NOW(), INTERVAL ? DAY))
");

foreach ($reports as $i => $r) {
    try {
        $insertReport->execute([$r['reporter_id'], $r['reported_user_id'], $r['stream_id'], $r['challenge_id'],
                                $r['reason'], $r['description'], $r['status'], $r['reviewed_by'], $i + 1]);
        echo "[✓] Report #{$r['reason']} ({$r['status']})\n";
    } catch (\PDOException $e) {
        echo "[i] Report: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 17: AI suggestions
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 17: AI suggestions ───\n";

$suggestions = [
    ['type' => 'highlight', 'content' => '{"title":"Best Moments Compilation","description":"Auto-generated highlight reel from recent streams","duration_seconds":180}', 'source_stream_id' => $S_GLOW_ART, 'target_user_id' => $LU, 'status' => 'pending'],
    ['type' => 'challenge', 'content' => '{"title":"Speedrun Showdown 2.0","description":"AI-suggested follow-up challenge with harder obstacles","difficulty":"extreme","xp_reward":600}', 'source_stream_id' => $S_NEO_LIVE, 'target_user_id' => $NE, 'status' => 'approved'],
];

$insertSuggestion = $pdo->prepare("INSERT IGNORE INTO ai_suggestions (type, content, source_stream_id, target_user_id, status) VALUES (?, ?, ?, ?, ?)");
foreach ($suggestions as $s) {
    try {
        $insertSuggestion->execute([$s['type'], json_encode($s['content']), $s['source_stream_id'], $s['target_user_id'], $s['status']]);
        echo "[✓] AI suggestion: {$s['type']}\n";
    } catch (\PDOException $e) {
        echo "[i] AI suggestion: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// STEP 18: Subtitles (for live streams)
// ──────────────────────────────────────────────────────────────────
echo "\n─── Step 18: Subtitles ───\n";

$subtitles = [
    ['stream_id' => $S_LUNA_LIVE, 'language' => 'en', 'content' => '[{"start":0,"end":5,"text":"Welcome everyone to the creative stream!"},{"start":6,"end":12,"text":"Today we are doing a glow art battle."},{"start":13,"end":18,"text":"Viewers will vote on the winner!"}]'],
    ['stream_id' => $S_NEO_LIVE, 'language' => 'fr', 'content' => '[{"start":0,"end":4,"text":"Bienvenue sur le marathon speedrun !"},{"start":5,"end":10,"text":"On va battre des records aujourd\'hui."}]'],
];

$insertSubtitle = $pdo->prepare("INSERT IGNORE INTO subtitles (stream_id, language, content, is_ai_generated) VALUES (?, ?, ?, 1)");
foreach ($subtitles as $st) {
    try {
        $insertSubtitle->execute([$st['stream_id'], $st['language'], $st['content']]);
        echo "[✓] Subtitles ({$st['language']}) for stream {$st['stream_id']}\n";
    } catch (\PDOException $e) {
        echo "[i] Subtitles: {$e->getMessage()}\n";
    }
}

// ──────────────────────────────────────────────────────────────────
// FINAL: Summary
// ──────────────────────────────────────────────────────────────────
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

echo "\n========================================\n";
echo "   Seeding complete!\n";
echo "========================================\n\n";
echo "   All 10 test accounts:\n";
echo "   ┌──────────────────┬──────────────────────────────┬──────────────┐\n";
echo "   │ Username          │ Email                        │ Password     │\n";
echo "   ├──────────────────┼──────────────────────────────┼──────────────┤\n";
echo "   │ testuser         │ user@senex.test               │ password123  │\n";
echo "   │ teststreamer     │ streamer@senex.test           │ stream123    │\n";
echo "   │ testadmin        │ admin@senex.test              │ admin123     │\n";
echo "   │ streamer_luna    │ streamer_luna@senex.test      │ password123  │\n";
echo "   │ streamer_neo     │ streamer_neo@senex.test       │ password123  │\n";
echo "   │ user_camille     │ user_camille@senex.test       │ password123  │\n";
echo "   │ user_leo         │ user_leo@senex.test           │ password123  │\n";
echo "   │ user_sarah       │ user_sarah@senex.test         │ password123  │\n";
echo "   │ banned_user      │ banned_user@senex.test        │ password123  │\n";
echo "   │ inactive_user    │ inactive_user@senex.test      │ password123  │\n";
echo "   └──────────────────┴──────────────────────────────┴──────────────┘\n\n";
echo "   Edge cases seeded:\n";
echo "   - banned_user: is_banned=1 → should fail login/auth\n";
echo "   - inactive_user: is_active=0 → should fail login/auth\n";
echo "   - 1 unpublished replay (is_published=0) → hidden from /replays\n";
echo "   - 1 cancelled stream → not shown on public streams page\n";
echo "   - 1 scheduled stream → shown as upcoming\n";
echo "   - 0-viewer streams → edge case for empty state display\n\n";
echo "   Total data inserted:\n";

$tables = ['users','user_profiles','streams','challenges','stream_challenges','replays','highlights',
           'chat_messages','follows','user_badges','challenge_attempts','viewer_interactions',
           'notifications','reports','ai_suggestions','subtitles'];
foreach ($tables as $table) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
    echo "   - $table: {$stmt->fetchColumn()}\n";
}

echo "\n   Run: php seed.php (first time) then php seed_full.php\n\n";
