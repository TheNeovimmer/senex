# 🎮 SENEX — Live Streaming & Challenge Platform

SENEX is a full-stack live streaming platform where users create accounts, streamers broadcast live content with interactive challenges, and admins moderate everything through a dark neon-themed dashboard suite.

Built with **PHP MVC**, **MySQL/MariaDB**, **Bootstrap 5**, and **FontAwesome**.

---

## ✨ Features

- **3 Dashboards** — User, Streamer, and Admin with role-based access
- **Live Streaming** — RTMP/WebRTC ingest with unique stream keys (OBS-ready)
- **Interactive Challenges** — Streamer-created dares with viewer voting, timers, and XP rewards
- **AI Integration** — OpenAI-powered challenge generation, auto-highlights, recommendations, moderation, and subtitles/translation
- **XP & Badge System** — Level progression with earnable badges
- **Live Chat** — Real-time chat with moderation
- **Reports & Moderation** — User flagging with admin review workflow
- **Replays & Highlights** — Archived stream content with view tracking

---

## 🖥️ System Requirements

| Requirement | Version |
|-------------|---------|
| **PHP** | 8.1+ |
| **MySQL / MariaDB** | 5.7+ / 10.4+ |
| **Composer** | 2.x |
| **Node.js** (optional) | 18+ (for asset building) |
| **Web Server** | Apache with `mod_rewrite` or nginx |

---

## ⚙️ Installation

### Option A: DDEV (Recommended — Linux / macOS / WSL2)

```bash
# 1. Clone the project
git clone https://github.com/YOUR_USERNAME/senex-pfe.git
cd senex-pfe

# 2. Start DDEV
ddev start

# 3. Install dependencies
ddev composer install

# 4. Configure environment
cp .env.example .env

# Edit .env with DDEV's default credentials:
# DB_HOST=db
# DB_NAME=senex_pfe
# DB_USER=root
# DB_PASSWORD=root

# 5. Run migrations & seed data
ddev php seed.php       # Basic seed (tables + categories + badges + 3 users)
ddev php seed_full.php  # Comprehensive seed (10 users, streams, challenges, etc.)

# 6. Access the application
# → https://senex-pfe.ddev.site
```

### Option B: Laragon (Windows)

1. Install [Laragon](https://laragon.org/download/) (Full edition) → **Start All**
2. Clone into `C:\laragon\www\senex-pfe`
3. Open Laragon Terminal:
   ```bash
   cd C:\laragon\www\senex-pfe
   composer install
   copy .env.example .env
   ```
4. Edit `.env`:
   ```env
   DB_HOST=127.0.0.1
   DB_NAME=senex_pfe
   DB_USER=root
   DB_PASSWORD=
   ```
5. Create database via **HeidiSQL** (included) or MySQL console:
   ```sql
   CREATE DATABASE IF NOT EXISTS senex_pfe CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```
6. Enable Apache rewrite: **Menu → Apache → httpd.conf** → uncomment `LoadModule rewrite_module modules/mod_rewrite.so` → **Restart → Apache**
7. Seed:
   ```bash
   php seed.php
   php seed_full.php
   ```
8. Open `http://localhost/senex-pfe/`

> **Note:** Ensure the document root points to `public/` (set in Laragon's Apache config).

---

## 🔐 Test Accounts

### Basic (from `seed.php`)

| Role | Username | Email | Password | Dashboard URL |
|------|----------|-------|----------|---------------|
| User | `testuser` | `user@senex.test` | `password123` | [/dashboard](/dashboard) |
| Streamer | `teststreamer` | `streamer@senex.test` | `stream123` | [/streamer](/streamer) |
| Admin | `testadmin` | `admin@senex.test` | `admin123` | [/admin](/admin) |

### Extra (from `seed_full.php`)

| Role | Username | Email | Password | Notes |
|------|----------|-------|----------|-------|
| Streamer | `streamer_luna` | `streamer_luna@senex.test` | `password123` | Creative streamer with badges |
| Streamer | `streamer_neo` | `streamer_neo@senex.test` | `password123` | Speedrunner, high XP |
| User | `user_camille` | `user_camille@senex.test` | `password123` | Active viewer/follower |
| User | `user_leo` | `user_leo@senex.test` | `password123` | Challenge completer |
| User | `user_sarah` | `user_sarah@senex.test` | `password123` | New user, level 1 |
| *(banned)* | `banned_user` | `banned_user@senex.test` | `password123` | `is_banned=1` → login rejected |
| *(inactive)* | `inactive_user` | `inactive_user@senex.test` | `password123` | `is_active=0` → login rejected |

---

## 🗂️ Project Structure

```
senex-pfe/
├── Config/              # Configuration files
│   ├── app.php          # Error reporting & logging
│   ├── Database.php     # PDO database connection singleton
│   └── routes.php       # Route definitions (~70 routes with middleware)
├── migrations/          # SQL migration files (11 files)
├── public/              # Web root (document root)
│   ├── index.php        # Application entry point
│   ├── assets/
│   │   ├── css/
│   │   │   ├── style.css        # Public pages (1,529 lines)
│   │   │   └── dashboard.css    # Dashboard theme (254 lines)
│   │   └── js/
│   │       ├── dashboard.js     # Dashboard interactions
│   │       ├── chat.js          # Live chat client
│   │       └── player.js        # Stream/Replay player
│   └── .htaccess        # Rewrite rules (if needed)
├── src/
│   ├── Controllers/     # 11 controllers (Auth, Home, Contact, Chat, Search, Results, Profile, 5 dashboard)
│   ├── Core/            # Router (with middleware), Helpers
│   ├── Models/          # 19 models (BaseModel + 18 entity models)
│   ├── Services/        # 8 services (Auth, Stream, Challenge, AI, etc.)
│   └── Views/           # View templates
│       ├── base.php             # Public layout
│       ├── dashboard/           # Dashboard layout (base, sidebar, topbar)
│       │   ├── user/            # 4 user dashboard views
│       │   ├── streamer/        # 6 streamer dashboard views
│       │   └── admin/           # 8 admin dashboard views
│       ├── home.php, login.php, contact.php, ...
│       └── header.php, footer.php
├── seed.php             # Basic seeder (tables + categories + badges + 3 users)
├── seed_full.php        # Comprehensive seeder (10 users, streams, challenges, replays)
├── .env                 # Environment configuration
├── composer.json        # PHP dependencies
└── README.md            # You're reading it!
```

---

## 🧭 Route Map

### Public Pages
| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Home page (live streams, active challenges, replays) |
| `/login` | GET/POST | Login form & submission |
| `/signin` | GET/POST | Registration form & submission |
| `/logout` | GET | Logout & redirect |
| `/contact` | GET/POST | Contact form |
| `/next` | GET | Upcoming challenges |
| `/streams` | GET | Public streams listing (live + upcoming) |
| `/stream/:id` | GET | Stream detail with live chat |
| `/replays` | GET | Published replays listing |
| `/replay/:id` | GET | Replay detail (video player) |
| `/search` | GET | Cross-entity search (users, streams, challenges) |
| `/leaderboard/:challengeId` | GET | Challenge ranking table |
| `/profile/:userId` | GET | Public user profile with badges |
| `/aboutus` | GET | About page |

### User Dashboard (`/dashboard/*`)
| Route | Method | Description |
|-------|--------|-------------|
| `/dashboard` | GET | Overview with stats, active challenges, live streams |
| `/dashboard/profile` | GET | View & edit profile (bio, skills, social links) |
| `/dashboard/profile/update` | POST | Update profile |
| `/dashboard/challenges` | GET | Browse challenges & participation history |
| `/dashboard/challenge/start/:id` | GET | Start a challenge |
| `/dashboard/settings` | GET | Change password & notification preferences |
| `/dashboard/settings/update` | POST | Update settings |
| `/dashboard/follow/:id` | GET | Follow a user |
| `/dashboard/unfollow/:id` | GET | Unfollow a user |
| `/dashboard/notifications/read-all` | GET | Mark all notifications read |
| `/dashboard/notifications/mark/:id` | GET | Mark single notification read |
| `/dashboard/report` | POST | Submit a report |

### Streamer Dashboard (`/streamer/*`)
| Route | Method | Description |
|-------|--------|-------------|
| `/streamer` | GET | Studio overview with quick actions |
| `/streamer/create` | POST | Create a new stream |
| `/streamer/streams` | GET | List all streams |
| `/streamer/go-live/:id` | GET | Start streaming |
| `/streamer/end-live/:id` | GET | Stop streaming |
| `/streamer/live/:id` | GET | Live studio with chat + challenge controls |
| `/streamer/live/stop-challenge/:streamId` | GET | Stop active challenge on stream |
| `/streamer/challenges` | GET | Manage challenges |
| `/streamer/challenges/create` | POST | Create a challenge |
| `/streamer/challenges/activate/:id` | GET | Activate a challenge |
| `/streamer/challenges/start/:streamId/:challengeId` | GET | Start challenge on stream |
| `/streamer/replays` | GET | Archived replays |
| `/streamer/highlights` | GET | Generated highlights |

### Admin Dashboard (`/admin/*`)
| Route | Method | Description |
|-------|--------|-------------|
| `/admin` | GET | Admin overview with platform stats |
| `/admin/users` | GET | User list |
| `/admin/users/search` | GET | Search users |
| `/admin/users/toggle/:id` | GET | Suspend/unsuspend user |
| `/admin/streams` | GET | All platform streams (with streamer name) |
| `/admin/challenges` | GET | All challenges (with creator name) |
| `/admin/reports` | GET | Review & process user reports |
| `/admin/reports/handle/:id` | POST | Handle a report |
| `/admin/categories` | GET | CRUD game categories |
| `/admin/categories/create` | POST | Create category |
| `/admin/categories/delete/:id` | POST | Delete category |
| `/admin/badges` | GET | CRUD achievement badges |
| `/admin/badges/create` | POST | Create badge |
| `/admin/badges/delete/:id` | POST | Delete badge |
| `/admin/ai` | GET | AI settings & suggestion management |
| `/admin/ai/generate` | POST | Generate AI suggestion |

### API & Misc
| Route | Method | Description |
|-------|--------|-------------|
| `/api/chat/messages` | GET | Poll chat messages (JSON) |
| `/api/chat/send` | POST | Send chat message (JSON) |

---

## 🎨 Design System

| Token | Value | Usage |
|-------|-------|-------|
| `--primary` | `#F15BB5` | Actions, highlights, active states |
| `--secondary` | `#9B5DE5` | Secondary elements, challenges |
| `--dark` | `#1E1E2F` | Background base |
| `--card-bg` | `rgba(26,26,62,0.9)` | Glass card backgrounds |
| Font | `Space Grotesk` | All text (via Google Fonts) |

---

## 🔧 Troubleshooting

### "Class not found" errors
```bash
composer dump-autoload
ddev composer dump-autoload  # if using DDEV
```

### "Column not found" errors
Make sure you ran `php seed.php` (migrations) then `php seed_full.php` (comprehensive data).

### Blank page / 500 error
Check `logs/error.log` for the actual error message.

### Login redirects back to login page
Make sure `session_start()` is in `public/index.php` (it should be there).

### Apache mod_rewrite not working
In Laragon: **Menu → Apache → httpd.conf** → uncomment `LoadModule rewrite_module modules/mod_rewrite.so` → restart Apache.

---

## 🧪 Resetting Everything

```bash
# Drop and recreate the database
ddev mysql -e "DROP DATABASE IF EXISTS senex_pfe; CREATE DATABASE senex_pfe;"   # DDEV
# OR via Laragon MySQL console / HeidiSQL

# Re-run seeders
php seed.php
php seed_full.php
```

---

## 📄 License

MIT — free to use, modify, and distribute.
