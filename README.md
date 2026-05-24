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

## ⚙️ Installation (Windows + Laragon)

### 1. Install Laragon

1. Download [Laragon](https://laragon.org/download/) (Full edition recommended)
2. Run the installer — everything defaults are fine
3. Launch Laragon → **Start All** (Apache + MySQL will start)

### 2. Clone the project

```bash
# Open Laragon Terminal (Menu → Terminal) or CMD from laragon/www/
cd C:\laragon\www
git clone https://github.com/YOUR_USERNAME/senex-pfe.git
# OR unzip the project folder into C:\laragon\www\senex-pfe
```

### 3. Install dependencies

```bash
cd C:\laragon\www\senex-pfe
composer install
# If you don't have Composer globally, download from https://getcomposer.org
```

### 4. Configure environment

```bash
# Copy the example env file (create it if not present):
copy .env.example .env
```

Edit `.env` with Laragon's database credentials:

```env
DB_HOST=127.0.0.1
DB_NAME=senex_pfe
DB_USER=root
DB_PASSWORD=

# Optional (leave empty if not used):
OPENAI_API_KEY=
MAIL_ADMIN=admin@example.com
```

### 5. Create the database

Open Laragon's **MySQL** terminal (Menu → MySQL → MySQL Console) and run:

```sql
CREATE DATABASE IF NOT EXISTS senex_pfe CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

Or use **HeidiSQL** (included with Laragon): right-click → New → Database → `senex_pfe`

### 6. Configure Apache rewrite rules

Laragon uses `httpd-vhosts.conf`. Make sure **rewrite mode** is on:

1. **Menu → Apache → httpd.conf** — find and uncomment this line (remove the `#`):
   ```
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
2. Restart Apache: **Menu → Restart → Apache**

### 7. Run migrations & seed data

```bash
cd C:\laragon\www\senex-pfe
php seed.php
```

This will:
- Create all database tables (20 tables)
- Insert 8 game categories (Action, Strategy, RPG, FPS, etc.)
- Insert 6 badges (Rising Star, Veteran, Legend, etc.)
- Create 3 test accounts (see below)

### 8. Access the application

Open your browser and go to:

```
http://localhost/senex-pfe/
```

> **Note:** If you get a 404, make sure the document root points to `public/`. In Laragon's Apache config:
> ```
> DocumentRoot "C:/laragon/www/senex-pfe/public"
> ```

---

## 🔐 Test Accounts

| Role | Username | Email | Password | Dashboard URL |
|------|----------|-------|----------|---------------|
| **User** | `testuser` | `user@senex.test` | `password123` | [http://localhost/senex-pfe/dashboard](http://localhost/senex-pfe/dashboard) |
| **Streamer** | `teststreamer` | `streamer@senex.test` | `stream123` | [http://localhost/senex-pfe/streamer](http://localhost/senex-pfe/streamer) |
| **Admin** | `testadmin` | `admin@senex.test` | `admin123` | [http://localhost/senex-pfe/admin](http://localhost/senex-pfe/admin) |

---

## 🗂️ Project Structure

```
senex-pfe/
├── Config/              # Configuration files
│   ├── app.php          # Error reporting & logging
│   ├── Database.php     # PDO database connection singleton
│   └── routes.php       # Route definitions (55+ routes with middleware)
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
│   ├── Controllers/     # 8 controllers (Auth, Home, Contact, 5 dashboard)
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
├── seed.php             # Database seeder (run once)
├── .env                 # Environment configuration
├── composer.json        # PHP dependencies
└── README.md            # You're reading it!
```

---

## 🧭 Route Map

### Public Pages
| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Home page |
| `/login` | GET/POST | Login form & submission |
| `/signin` | GET/POST | Registration form & submission |
| `/logout` | GET | Logout & redirect |
| `/contact` | GET/POST | Contact form |
| `/next` | GET | Next dare page |
| `/replays` | GET | Public replays listing |
| `/aboutus` | GET | About page |

### User Dashboard (`/dashboard/*`)
| Route | Description |
|-------|-------------|
| `/dashboard` | Overview with stats, active challenges, live streams |
| `/dashboard/profile` | View & edit profile (bio, skills, social links) |
| `/dashboard/challenges` | Browse challenges & participation history |
| `/dashboard/settings` | Change password & notification preferences |
| `/dashboard/follow/:id` | Follow a user |
| `/dashboard/unfollow/:id` | Unfollow a user |

### Streamer Dashboard (`/streamer/*`)
| Route | Description |
|-------|-------------|
| `/streamer` | Studio overview with quick actions |
| `/streamer/create` | Create a new stream (POST) |
| `/streamer/streams` | List all streams |
| `/streamer/go-live/:id` | Start streaming |
| `/streamer/end-live/:id` | Stop streaming |
| `/streamer/live/:id` | Live studio with chat + challenge controls |
| `/streamer/challenges` | Manage challenges |
| `/streamer/replays` | Archived replays |
| `/streamer/highlights` | Generated highlights |

### Admin Dashboard (`/admin/*`)
| Route | Description |
|-------|-------------|
| `/admin` | Admin overview with platform stats |
| `/admin/users` | User list, search, suspend/unsuspend |
| `/admin/streams` | All platform streams |
| `/admin/challenges` | All challenges |
| `/admin/reports` | Review & process user reports |
| `/admin/categories` | CRUD game categories |
| `/admin/badges` | CRUD achievement badges |
| `/admin/ai` | AI settings & suggestion management |

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
```

### "Column not found" errors
Make sure you ran `php seed.php` to run all migrations.

### Blank page / 500 error
Check `logs/error.log` for the actual error message.

### Login redirects back to login page
Make sure `session_start()` is in `public/index.php` (it should be there).

### Apache mod_rewrite not working
In Laragon: **Menu → Apache → httpd.conf** → uncomment `LoadModule rewrite_module modules/mod_rewrite.so` → restart Apache.

---

## 🧪 Resetting Everything

```bash
# Drop and recreate the database (via MySQL console)
DROP DATABASE senex_pfe;
CREATE DATABASE senex_pfe;

# Re-run the seeder
php seed.php
```

---

## 📄 License

MIT — free to use, modify, and distribute.
