<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards - FitQuest</title>
    <link rel="stylesheet" href="css/r.css">
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
                <li><a href="challenges.php">Challenges</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li class="active"><a href="rewards.php">Rewards</a></li>
            </ul>
        </nav>
        <div class="user-menu">
            <button id="notifications-btn" class="icon-btn">
                <span class="material-symbols-outlined">notifications</span>
                <span class="notification-badge"></span>
            </button>
            <div class="user-avatar" id="user-menu-btn">
                <img  id="img10" src="img/bg.jpg" alt="User avatar">
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
            <h2>Rewards</h2>
            <div class="points-display">
                <span class="points-value" id="rewards-points">1,250</span>
                <span class="points-label">Points Available</span>
            </div>
        </section>

        <section class="rewards-tabs">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="shop">Rewards Shop</button>
                <button class="tab-btn" data-tab="achievements">Achievements</button>
            </div>
            
            <div class="tab-content active" id="shop-tab">
                <div class="rewards-grid" id="rewards-container">
                    <!-- Rewards will be populated by JavaScript -->
                </div>
            </div>
            
            <div class="tab-content" id="achievements-tab">
                <div class="achievements-grid" id="achievements-container">
                    <!-- Achievements will be populated by JavaScript -->
                </div>
            </div>
        </section>
    </main>

    <nav class="mobile-nav">
        <a href="index.php">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="challenges.php">
            <span class="material-symbols-outlined">emoji_events</span>
            <span>Challenges</span>
        </a>
        <a href="leaderboard.php">
            <span class="material-symbols-outlined">leaderboard</span>
            <span>Leaderboard</span>
        </a>
        <a href="rewards.php" class="active">
            <span class="material-symbols-outlined">redeem</span>
            <span>Rewards</span>
        </a>
    </nav>

    <script src="js/script.js"></script>
    <script src="js/s.js"></script>
    <script src="js/r.js"></script>
    <script src="js/rewards.js"></script>
</body>
</html>