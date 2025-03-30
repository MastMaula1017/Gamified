<?php
// Start session
session_start();

// Redirect if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - FitQuest</title>
    <link rel="stylesheet" href="css/leaderb.css">
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
                <li class="active"><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="rewards.php">Rewards</a></li>
                <li><a href="quiz.php">Health Quiz</a></li>
            </ul>
        </nav>
        <div class="user-menu">
            <div class="points-display small">
                <span class="points-value"><?php echo $_SESSION['points']; ?></span>
                <span class="points-label">Points</span>
            </div>
            <div class="user-avatar" id="user-menu-btn">
                <img src="https://via.placeholder.com/40" alt="User avatar">
            </div>
            <div class="user-dropdown" id="user-dropdown">
                <ul>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="api/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <section class="page-header">
            <h2>Leaderboard</h2>
            <p>See how you rank against other health enthusiasts!</p>
        </section>

        <section class="leaderboard-full">
            <div class="top-performers" id="top-performers">
                <!-- Top 3 performers will be populated by JavaScript -->
            </div>

            <div class="leaderboard-table">
                <div class="leaderboard-header">
                    <span>Rank</span>
                    <span>User</span>
                    <span>Points</span>
                </div>
                <div class="leaderboard-body" id="full-leaderboard">
                    <!-- Leaderboard entries will be populated by JavaScript -->
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
        <a href="leaderboard.php" class="active">
            <span class="material-symbols-outlined">leaderboard</span>
            <span>Leaderboard</span>
        </a>
        <a href="rewards.php">
            <span class="material-symbols-outlined">redeem</span>
            <span>Rewards</span>
        </a>
    </nav>

    <script>
        // Setup user dropdown
        document.getElementById('user-menu-btn').addEventListener('click', function() {
            document.getElementById('user-dropdown').classList.toggle('active');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userDropdown = document.getElementById('user-dropdown');
            
            if (!userMenuBtn.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.remove('active');
            }
        });
        
        // Fetch leaderboard data
        document.addEventListener('DOMContentLoaded', function() {
            fetch('api/get_leaderboard.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Populate top performers
                        const topPerformers = document.getElementById('top-performers');
                        const top3 = data.leaderboard.slice(0, 3);
                        
                        if (top3.length >= 3) {
                            topPerformers.innerHTML = `
                                <div class="performer second-place">
                                    <div class="rank">2</div>
                                    <div class="user-avatar">
                                        <img src="https://via.placeholder.com/80" alt="Second place">
                                    </div>
                                    <div class="user-name">${top3[1].username}</div>
                                    <div class="user-points">${top3[1].points} pts</div>
                                </div>
                                <div class="performer first-place">
                                    <div class="rank">1</div>
                                    <div class="user-avatar">
                                        <img src="https://via.placeholder.com/100" alt="First place">
                                    </div>
                                    <div class="user-name">${top3[0].username}</div>
                                    <div class="user-points">${top3[0].points} pts</div>
                                </div>
                                <div class="performer third-place">
                                    <div class="rank">3</div>
                                    <div class="user-avatar">
                                        <img src="https://via.placeholder.com/80" alt="Third place">
                                    </div>
                                    <div class="user-name">${top3[2].username}</div>
                                    <div class="user-points">${top3[2].points} pts</div>
                                </div>
                            `;
                        }
                        
                        // Populate leaderboard
                        const leaderboardBody = document.getElementById('full-leaderboard');
                        leaderboardBody.innerHTML = '';
                        
                        data.leaderboard.forEach(user => {
                            const row = document.createElement('div');
                            row.className = `leaderboard-row ${user.id == <?php echo $_SESSION['user_id']; ?> ? 'current-user' : ''}`;
                            
                            row.innerHTML = `
                                <div class="leaderboard-rank">${user.rank}</div>
                                <div class="leaderboard-user">
                                    <img src="https://via.placeholder.com/40" alt="${user.username}">
                                    <span>${user.username} ${user.id == <?php echo $_SESSION['user_id']; ?> ? '<span style="background-color: rgba(79, 70, 229, 0.1); color: var(--primary-color); padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; margin-left: 8px;">You</span>' : ''}</span>
                                </div>
                                <div class="leaderboard-points">${user.points}</div>
                            `;
                            
                            leaderboardBody.appendChild(row);
                        });
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        // Initialize theme toggle
function initializeThemeToggle() {
  const themeToggleContainer = document.createElement('div');
  themeToggleContainer.className = 'theme-toggle-container';
  themeToggleContainer.innerHTML = `
    <label class="theme-toggle">
      <input type="checkbox" id="theme-checkbox">
      <span class="toggle-slider"></span>
      <span class="toggle-icon sun material-symbols-outlined">light_mode</span>
      <span class="toggle-icon moon material-symbols-outlined">dark_mode</span>
    </label>
  `;

  // Add the toggle to the header before user menu
  const header = document.querySelector('header');
  const userMenu = document.querySelector('.user-menu');
  header.insertBefore(themeToggleContainer, userMenu);

  // Check for saved theme preference or use preferred color scheme
  const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
  const currentTheme = localStorage.getItem('theme') || 
                      (prefersDarkScheme.matches ? 'dark' : 'light');

  // Apply the current theme
  document.documentElement.setAttribute('data-theme', currentTheme);

  // Set the checkbox state
  const checkbox = document.getElementById('theme-checkbox');
  if (currentTheme === 'light') {
    checkbox.checked = true;
  }

  // Theme toggle functionality
  checkbox.addEventListener('change', function() {
    if (this.checked) {
      document.documentElement.setAttribute('data-theme', 'light');
      localStorage.setItem('theme', 'light');
    } else {
      document.documentElement.setAttribute('data-theme', 'dark');
      localStorage.setItem('theme', 'dark');
    }
  });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  initializeThemeToggle();
  
  // Your existing leaderboard initialization code
  // Setup user dropdown
  document.getElementById('user-menu-btn').addEventListener('click', function() {
    document.getElementById('user-dropdown').classList.toggle('active');
  });
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(event) {
    const userMenuBtn = document.getElementById('user-menu-btn');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (!userMenuBtn.contains(event.target) && !userDropdown.contains(event.target)) {
      userDropdown.classList.remove('active');
    }
  });
  
  // ... rest of your existing JavaScript ...
});
document.addEventListener("DOMContentLoaded", function () {
    const userAvatar = document.querySelector(".user-avatar");
    const userDropdown = document.querySelector(".user-dropdown");

    if (userAvatar && userDropdown) {
        userAvatar.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents click from bubbling to document
            userDropdown.classList.toggle("active");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!userAvatar.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.remove("active");
            }
        });
    }
});

    </script>
</body>
</html>