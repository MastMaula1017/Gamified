<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges - FitQuest</title>
    <link rel="stylesheet" href="css/challenges.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <header>
        <div class="logo">
            <span class="material-symbols-outlined">fitness_center</span>
            <h1>FitQuest</h1>
        </div>
        <nav class="desktop-nav">
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li class="active"><a href="challenges.php">Challenges</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="rewards.php">Rewards</a></li>
            </ul>
        </nav>
        <div class="user-menu">
            <button id="notifications-btn" class="icon-btn">
                <span class="material-symbols-outlined">notifications</span>
                <span class="notification-badge"></span>
            </button>
            <div class="user-avatar" id="user-menu-btn">
                <img src="https://via.placeholder.com/40" alt="User avatar">
            </div>
            <div class="user-dropdown" id="user-dropdown">
                <ul>
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="settings.html">Settings</a></li>
                    <li><a href="api/logout.php" id="logout-btn">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <section class="page-header">
            <h2>Challenges</h2>
            <div class="filter-controls">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="active">Active</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
                <button class="filter-btn" data-filter="available">Available</button>
            </div>
        </section>

        <section class="challenges-grid full-grid" id="challenges-container">
            <!-- Challenges will be populated by JavaScript -->
        </section>
    </main>

    <nav class="mobile-nav">
        <a href="index.php">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="challenges.php" class="active">
            <span class="material-symbols-outlined">emoji_events</span>
            <span>Challenges</span>
        </a>
        <a href="leaderboard.php">
            <span class="material-symbols-outlined">leaderboard</span>
            <span>Leaderboard</span>
        </a>
        <a href="rewards.php">
            <span class="material-symbols-outlined">redeem</span>
            <span>Rewards</span>
        </a>
    </nav>

    <script src="js/script.js"></script>
    <script src="js/s.js"></script>
    <script src="js/challenges.js"></script>
</body>
</html>