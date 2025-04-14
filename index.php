<?php
session_start();
// If user is not logged in, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Include database connection
require_once('includes/db_connect.php');
?>
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
    <?php include 'includes/header.php'; ?>

    <main>
        <section class="welcome-section">
            <div class="welcome-text">
                <h2>Welcome back, <span id="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h2>
                <p>You're making great progress. Keep it up!</p>
            </div>
            <div class="points-display">
                <span class="points-value" id="user-points"><?php echo number_format($_SESSION['points']); ?></span>
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
                <a href="challenges.php" class="view-all">View All</a>
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
                <a href="leaderboard.php" class="view-all">View All</a>
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
        <a href="index.php" class="active">
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
        <a href="rewards.php">
            <span class="material-symbols-outlined">redeem</span>
            <span>Rewards</span>
        </a>
        <a href="quiz.php">
            <span class="material-symbols-outlined">quiz</span>
            <span>Quiz</span>
        </a>
    </nav>
<script>
// Pass PHP session data to JavaScript
const userData = {
    name: '<?php echo htmlspecialchars($_SESSION['username']); ?>',
    points: <?php echo isset($_SESSION['points']) ? (int)$_SESSION['points'] : 0; ?>,
    steps: 7500,
    calories: 1200,
    activeMinutes: 30
};
</script>
<script src="js/script.js"></script>
<!-- <script src="js/s.js"></script> -->
    <script src="js/dropdark.js"></script>
</body>
</html>