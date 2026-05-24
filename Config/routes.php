<?php

return [
    // ===== Public pages =====
    "home" => [
        "method" => "GET",
        "controller" => [\Controllers\HomeController::class, 'showhomepage'],
    ],
    "contact" => [
        "method" => "GET",
        "controller" => [\Controllers\ContactController::class, 'showcontactpage'],
    ],
    "contact.post" => [
        "method" => "POST",
        "controller" => [\Controllers\ContactController::class, 'sendMessageContact'],
    ],
    "next" => [
        "method" => "GET",
        "controller" => [\Controllers\ContactController::class, 'shownextpage'],
    ],
    "replays" => [
        "method" => "GET",
        "controller" => [\Controllers\ContactController::class, 'showreplayspage'],
    ],
    "aboutus" => [
        "method" => "GET",
        "controller" => [\Controllers\ContactController::class, 'showaboutuspage'],
    ],

    // ===== Auth =====
    "login" => [
        "method" => "GET",
        "controller" => [\Controllers\AuthController::class, 'showLogin'],
        "middleware" => "guest",
    ],
    "login.post" => [
        "method" => "POST",
        "controller" => [\Controllers\AuthController::class, 'loginPost'],
        "middleware" => "guest",
    ],
    "signin" => [
        "method" => "GET",
        "controller" => [\Controllers\AuthController::class, 'showSignin'],
        "middleware" => "guest",
    ],
    "signin.post" => [
        "method" => "POST",
        "controller" => [\Controllers\AuthController::class, 'signinPost'],
        "middleware" => "guest",
    ],
    "logout" => [
        "method" => "GET",
        "controller" => [\Controllers\AuthController::class, 'logout'],
    ],

    // ===== User Dashboard =====
    "dashboard" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'index'],
        "middleware" => "auth",
    ],
    "dashboard/profile" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'profile'],
        "middleware" => "auth",
    ],
    "dashboard/profile/update" => [
        "method" => "POST",
        "controller" => [\Controllers\UserDashboardController::class, 'updateProfile'],
        "middleware" => "auth",
    ],
    "dashboard/challenges" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'challenges'],
        "middleware" => "auth",
    ],
    "dashboard/settings" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'settings'],
        "middleware" => "auth",
    ],
    "dashboard/settings/update" => [
        "method" => "POST",
        "controller" => [\Controllers\UserDashboardController::class, 'updateSettings'],
        "middleware" => "auth",
    ],
    "dashboard/follow/:userId" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'follow'],
        "middleware" => "auth",
    ],
    "dashboard/unfollow/:userId" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'unfollow'],
        "middleware" => "auth",
    ],

    // ===== Streamer Dashboard =====
    "streamer" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'index'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/create" => [
        "method" => "POST",
        "controller" => [\Controllers\StreamerDashboardController::class, 'createStream'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/streams" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'streams'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/go-live/:streamId" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'goLive'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/end-live/:streamId" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'endLive'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/live/:streamId" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'liveView'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/challenges" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'challenges'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/challenges/create" => [
        "method" => "POST",
        "controller" => [\Controllers\StreamerDashboardController::class, 'createChallenge'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/challenges/activate/:challengeId" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'activateChallenge'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/challenges/start/:streamId/:challengeId" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'startChallengeOnStream'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/replays" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'replays'],
        "middleware" => "role:streamer,admin",
    ],
    "streamer/highlights" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'highlights'],
        "middleware" => "role:streamer,admin",
    ],

    // ===== Admin Dashboard =====
    "admin" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'index'],
        "middleware" => "role:admin",
    ],
    "admin/users" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'users'],
        "middleware" => "role:admin",
    ],
    "admin/users/search" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'searchUsers'],
        "middleware" => "role:admin",
    ],
    "admin/users/toggle/:userId" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'toggleUserStatus'],
        "middleware" => "role:admin",
    ],
    "admin/streams" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'streams'],
        "middleware" => "role:admin",
    ],
    "admin/challenges" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'challenges'],
        "middleware" => "role:admin",
    ],
    "admin/reports" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'reports'],
        "middleware" => "role:admin",
    ],
    "admin/reports/handle/:reportId" => [
        "method" => "POST",
        "controller" => [\Controllers\AdminDashboardController::class, 'handleReport'],
        "middleware" => "role:admin",
    ],
    "admin/categories" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'categories'],
        "middleware" => "role:admin",
    ],
    "admin/categories/create" => [
        "method" => "POST",
        "controller" => [\Controllers\AdminDashboardController::class, 'createCategory'],
        "middleware" => "role:admin",
    ],
    "admin/categories/delete/:id" => [
        "method" => "POST",
        "controller" => [\Controllers\AdminDashboardController::class, 'deleteCategory'],
        "middleware" => "role:admin",
    ],
    "admin/badges" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'badges'],
        "middleware" => "role:admin",
    ],
    "admin/badges/create" => [
        "method" => "POST",
        "controller" => [\Controllers\AdminDashboardController::class, 'createBadge'],
        "middleware" => "role:admin",
    ],
    "admin/badges/delete/:id" => [
        "method" => "POST",
        "controller" => [\Controllers\AdminDashboardController::class, 'deleteBadge'],
        "middleware" => "role:admin",
    ],
    "admin/ai" => [
        "method" => "GET",
        "controller" => [\Controllers\AdminDashboardController::class, 'aiSettings'],
        "middleware" => "role:admin",
    ],
    "admin/ai/generate" => [
        "method" => "POST",
        "controller" => [\Controllers\AdminDashboardController::class, 'generateSuggestion'],
        "middleware" => "role:admin",
    ],

    // ===== Chat API =====
    "api/chat/messages" => [
        "method" => "GET",
        "controller" => [\Controllers\ChatController::class, 'getMessages'],
    ],
    "api/chat/send" => [
        "method" => "POST",
        "controller" => [\Controllers\ChatController::class, 'sendMessage'],
    ],

    // ===== Notifications =====
    "dashboard/notifications/read-all" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'markAllNotificationsRead'],
        "middleware" => "auth",
    ],
    "dashboard/notifications/mark/:id" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'markNotificationRead'],
        "middleware" => "auth",
    ],

    // ===== Challenge participation =====
    "dashboard/challenge/start/:id" => [
        "method" => "GET",
        "controller" => [\Controllers\UserDashboardController::class, 'startChallenge'],
        "middleware" => "auth",
    ],

    // ===== Public pages (dynamic) =====
    "streams" => [
        "method" => "GET",
        "controller" => [\Controllers\HomeController::class, 'showStreams'],
    ],
    "stream/:id" => [
        "method" => "GET",
        "controller" => [\Controllers\HomeController::class, 'showStreamDetail'],
    ],
    "replay/:id" => [
        "method" => "GET",
        "controller" => [\Controllers\HomeController::class, 'showReplayDetail'],
    ],

    // ===== Search =====
    "search" => [
        "method" => "GET",
        "controller" => [\Controllers\SearchController::class, 'search'],
    ],

    // ===== Leaderboard =====
    "leaderboard/:challengeId" => [
        "method" => "GET",
        "controller" => [\Controllers\ResultsController::class, 'leaderboard'],
    ],

    // ===== Public profile =====
    "profile/:userId" => [
        "method" => "GET",
        "controller" => [\Controllers\ProfileController::class, 'showProfile'],
    ],

    // ===== Report =====
    "dashboard/report" => [
        "method" => "POST",
        "controller" => [\Controllers\UserDashboardController::class, 'submitReport'],
        "middleware" => "auth",
    ],

    // ===== Stop challenge on stream =====
    "streamer/live/stop-challenge/:streamId" => [
        "method" => "GET",
        "controller" => [\Controllers\StreamerDashboardController::class, 'stopChallengeOnStream'],
        "middleware" => "role:streamer,admin",
    ],
];
