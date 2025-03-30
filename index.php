<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitQuest - Gamified Health Platform</title>
    <link rel="stylesheet" href="css/index.css">
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
                <li class="active"><a href="index.php">Dashboard</a></li>
                <li><a href="challenges.php">Challenges</a></li>
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
        <section class="welcome-section">
            <div class="welcome-text">
                <h2>Welcome back, <span id="user-name">Alex</span>!</h2>
                <p>You're making great progress. Keep it up!</p>
            </div>
            <div class="points-display">
                <span class="points-value" id="user-points">1,250</span>
                <span class="points-label">Points</span>
            </div>
        </section>

        <section class="stats-section">
            <h2>Today's Progress</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="material-symbols-outlined">footprint</span>
                    </div>
                    <div class="stat-info">
                        <h3>Steps</h3>
                        <div class="stat-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%"></div>
                            </div>
                            <div class="progress-text">
                                <span id="steps-count">7,500</span>
                                <span class="progress-target">/ 10,000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="material-symbols-outlined">local_fire_department</span>
                    </div>
                    <div class="stat-info">
                        <h3>Calories</h3>
                        <div class="stat-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 60%"></div>
                            </div>
                            <div class="progress-text">
                                <span id="calories-count">1,200</span>
                                <span class="progress-target">/ 2,000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="material-symbols-outlined">timer</span>
                    </div>
                    <div class="stat-info">
                        <h3>Active Minutes</h3>
                        <div class="stat-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 40%"></div>
                            </div>
                            <div class="progress-text">
                                <span id="active-minutes">30</span>
                                <span class="progress-target">/ 60</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="challenges-section">
            <div class="section-header">
                <h2>Active Challenges</h2>
                <a href="challenges.html" class="view-all">View All</a>
            </div>
            <div class="challenges-grid">
                <div class="challenge-card">
                    <div class="challenge-header">
                        <h3>Morning Run Challenge</h3>
                        <span class="challenge-badge medium">Medium</span>
                    </div>
                    <p>Run 5km every morning for a week</p>
                    <div class="challenge-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 40%"></div>
                        </div>
                        <div class="progress-text">2/5 days</div>
                    </div>
                    <div class="challenge-meta">
                        <div class="challenge-reward">
                            <span class="material-symbols-outlined">emoji_events</span>
                            <span>50 points</span>
                        </div>
                        <div class="challenge-time">
                            <span class="material-symbols-outlined">schedule</span>
                            <span>3 days left</span>
                        </div>
                    </div>
                </div>
                <div class="challenge-card">
                    <div class="challenge-header">
                        <h3>10,000 Steps</h3>
                        <span class="challenge-badge easy">Easy</span>
                    </div>
                    <p>Reach 10,000 steps daily for 5 consecutive days</p>
                    <div class="challenge-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 60%"></div>
                        </div>
                        <div class="progress-text">3/5 days</div>
                    </div>
                    <div class="challenge-meta">
                        <div class="challenge-reward">
                            <span class="material-symbols-outlined">emoji_events</span>
                            <span>30 points</span>
                        </div>
                        <div class="challenge-time">
                            <span class="material-symbols-outlined">schedule</span>
                            <span>2 days left</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="leaderboard-section">
            <div class="section-header">
                <h2>Weekly Leaderboard</h2>
                <a href="leaderboard.html" class="view-all">View All</a>
            </div>
            <div class="leaderboard-container">
                <div class="leaderboard-header">
                    <span>Rank</span>
                    <span>User</span>
                    <span>Points</span>
                </div>
                <div class="leaderboard-body" id="leaderboard-list">
                    <!-- Leaderboard entries will be populated by JavaScript -->
                </div>
            </div>
        </section>
    </main>

    <nav class="mobile-nav">
        <a href="index.html" class="active">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="challenges.html">
            <span class="material-symbols-outlined">emoji_events</span>
            <span>Challenges</span>
        </a>
        <a href="leaderboard.html">
            <span class="material-symbols-outlined">leaderboard</span>
            <span>Leaderboard</span>
        </a>
        <a href="rewards.html">
            <span class="material-symbols-outlined">redeem</span>
            <span>Rewards</span>
        </a>
    </nav>

    <script src="js/script.js"></script>
    <script src="js/s.js"></script>
</body>
</html>