# 🔴 SENEX Architecture Plan

## Goal
- Transform SENEX from partial backend structure into a fully integrated full-stack live streaming platform with all use cases wired end-to-end across User, Streamer, and Admin dashboards.

## Progress

### Done (Batch 1 — Core Structure)
- **7 bug fixes**: composer.json duplicate autoload merged & regenerated; FollowModel countFollowers/countFollowing crash fixed (chained execute→fetchColumn split); UserBadgeModel hasBadge() logic corrected (single query with both conditions); signin.php field `fullname`→`username`; users table got `is_active`, `is_banned`, `avatar_url`, `display_name`, `last_login` columns via ALTER TABLE; duplicate `model/contactmodel.php` deleted; `logs/` directory created.
- **15 new routes added**: API chat (messages/send), notifications (read-all, mark/:id), challenge start (`/dashboard/challenge/start/:id`), public pages (streams, stream/:id, replay/:id), search, leaderboard/:challengeId, profile/:userId, report submission (`POST /dashboard/report`), stop challenge on streamer live.
- **4 new controllers**: `ChatController` (JSON endpoints for polling + send), `SearchController` (cross-entity search), `ResultsController` (leaderboard), `ProfileController` (public user profile).
- **All controllers updated with complete logic**: `HomeController` (4 dynamic public methods — homepage with live streams/challenges/replays from DB, streams listing, stream detail with chat, replay detail), `UserDashboardController` (added startChallenge, markAllNotificationsRead, markNotificationRead, submitReport, updateSettings — all with CSRF validation), `StreamerDashboardController` (added stopChallengeOnStream, goLive, createChallenge with CSRF, startChallengeOnStream — all methods working), `AdminDashboardController` (CSRF validation on every POST handler, JOIN queries in streams() and challenges() to show real names, added deleteCategory/deleteBadge), `ContactController` (removed session_start(), uses AuthService CSRF, wraps pages in base layout).
- **AuthService updated**: `login()` now supports username OR email via `verifyPasswordByUsername()` on UserModel.
- **StreamService::notifyFollowers()** completed — actually queries follows table and inserts notifications.
- **6 new dynamic view files**: `streams.php`, `stream_detail.php` (with chat client), `replay_detail.php` (video player), `search.php` (cross-entity results), `leaderboard.php` (ranking table), `profile.php` (public user with badges).

### Done (Batch 2 — Dynamic Views + Layout Cleanup)
- **4 static public pages converted to dynamic**: `home.php` now shows live streams, active challenges, user count from DB; `next.php` shows upcoming challenges from DB; `replays.php` shows published replays from DB; `aboutus.php` shows real user/challenge/stream counts from DB.
- **All 5 alert() stubs replaced**: streamer/live.php (stop challenge button posts to /streamer/live/stop-challenge/:streamId), streamer/replays.php + highlights.php (play button links to `/replay/:id`), user challenges.php (relève button links to `/dashboard/challenge/start/:id`).
- **Admin dashboard data display fixed**: streams page shows `streamer_name` (JOIN with users), challenges page shows `creator_name` (JOIN with users).
- **Contact form**: action changed from `/contact/send` to `/contact` (matching route + POST mapping), CSRF token now passed from controller, `session_start()` removed.
- **ContactController expanded**: now receives PDO and uses ReplayModel, ChallengeModel, StreamModel, UserModel to pass dynamic data to public views.
- **Fixed double layout rendering**: All public views (`home.php`, `next.php`, `replays.php`, `aboutus.php`, `contact.php`, `login.php`, `signin.php`) no longer self-manage ob_start/base.php — controllers handle the layout.
- **Syntax validation**: All 8 edited files pass `php -l` syntax check.

### In Progress
- (none)

### Blocked
- Password reset flow — link on login page still points to `#`; no reset endpoint exists yet.

## Key Decisions
- Monolithic single-pass implementation: all bugs, missing routes, controllers, dynamic views, and frontend wiring done in one pass.
- Chat API returns JSON via REST endpoints (not WebSockets) — `ChatClient.js` polls every 2s.
- Public stream pages use placeholder player with stream key (no WebRTC server yet).
- Admin streams/challenges use manual JOIN queries in controller instead of modifying BaseModel paginate.
- DB column mismatch (`active` vs `is_active`) resolved by ALTER TABLE + backfill — both columns coexist.

## Design System
- Bootstrap 5 grid + AOS animations + FontAwesome icons.
- Dark neon theme: pink `#F15BB5`, purple `#9B5DE5`, dark background `#1E1E2F`.
- All images: placeholder (`https://placehold.co/...`).
- Dashboard layout: fixed 260px sidebar + sticky topbar + scrollable main.
- Session-based auth; all POST submissions use CSRF token from session.

## Critical Context
- Session started in `public/index.php` line 2 — controllers must NOT call `session_start()` (ContactController was fixed).
- Every POST handler now calls `$this->authService->verifyCsrf()` before processing.
- `ContactController::showContactPage()` now passes `$csrf` variable for the hidden input.
- Streamer live studio has active challenge display + stop challenge button + challenge start form.
- The `Render()` method in DashboardController uses `ob_start()` capture — standard for all dashboard views.
- Public pages (base.php layout) use direct `require` with `ob_start()` + `$content` variable.
- Admin streams page previously showed "Streamer #ID" — now shows `$s['streamer_name']` from JOIN.
- `users.active` column still exists (original migration) — `is_active` added alongside it; code now uses `is_active` everywhere.
- Public views no longer self-manage layout — all are pure HTML sections, controllers handle wrapping.

## Next Steps
1. Implement password reset flow — login page "Forget password" link (#) needs a working endpoint.
2. Add email confirmation flow for new signups.
3. Configure SMTP for contact form email delivery.
4. Test chat send/receive from stream_detail.php (public unauthenticated chat not shown).
5. Write `.env.example` with all required keys if not present.
6. Test all routes end-to-end — verify no 404s, 500s, or missing controller methods.
