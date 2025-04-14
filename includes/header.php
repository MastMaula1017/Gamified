<?php
// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Connect to database if not already connected
if (!isset($conn)) {
    require_once(__DIR__ . '/db_connect.php');
}

// Get user data for the header
$user_query = $conn->prepare("SELECT profile_image, display_name FROM users WHERE id = ?");
$user_query->bind_param("i", $_SESSION['user_id']);
$user_query->execute();
$header_user = $user_query->get_result()->fetch_assoc();
$user_query->close();

// Use display name if set, otherwise use username
$display_name = $header_user['display_name'] ? $header_user['display_name'] : $_SESSION['username'];
?>
<header>
    <div class="logo">
        <span class="material-symbols-outlined">fitness_center</span>
        <h1>FitQuest</h1>
    </div>
    <nav class="desktop-nav">
        <ul>
            <li<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? ' class="active"' : ''; ?>><a href="index.php">Dashboard</a></li>
            <li<?php echo basename($_SERVER['PHP_SELF']) == 'challenges.php' ? ' class="active"' : ''; ?>><a href="challenges.php">Challenges</a></li>
            <li<?php echo basename($_SERVER['PHP_SELF']) == 'leaderboard.php' ? ' class="active"' : ''; ?>><a href="leaderboard.php">Leaderboard</a></li>
            <li<?php echo basename($_SERVER['PHP_SELF']) == 'rewards.php' ? ' class="active"' : ''; ?>><a href="rewards.php">Rewards</a></li>
            <li<?php echo basename($_SERVER['PHP_SELF']) == 'quiz.php' ? ' class="active"' : ''; ?>><a href="quiz.php">Quiz</a></li>
            <li<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? ' class="active"' : ''; ?>><a href="contact.php">Contact Us</a></li>
            <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                <li><a href="admin/index.php">Admin Panel</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="user-menu">
        <?php if (basename($_SERVER['PHP_SELF']) == 'quiz.php' || basename($_SERVER['PHP_SELF']) == 'leaderboard.php'): ?>
            <div class="points-display small">
                <span class="points-value"><?php echo htmlspecialchars($_SESSION['points']); ?></span>
                <span class="points-label">Points</span>
            </div>
        <?php else: ?>
            <button id="notifications-btn" class="icon-btn">
                <span class="material-symbols-outlined">notifications</span>
                <span class="notification-badge"></span>
            </button>
        <?php endif; ?>
        <div class="user-avatar" id="user-menu-btn">
            <img src="<?php echo htmlspecialchars($header_user['profile_image'] ? 'img/profile_images/' . $header_user['profile_image'] : 'https://via.placeholder.com/40'); ?>" alt="User avatar">
        </div>
        <div class="user-dropdown" id="user-dropdown">
            <ul>
                <li<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? ' class="active"' : ''; ?>><a href="profile.php">Profile</a></li>
                <li<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? ' class="active"' : ''; ?>><a href="settings.php">Settings</a></li>
                <li><a href="api/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</header>