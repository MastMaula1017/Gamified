<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Connect to database
require_once('includes/db_connect.php');

$message = '';
$error = '';

// Get current user data
$stmt = $conn->prepare("SELECT username, email, display_name, bio, profile_image, dark_mode FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $display_name = trim($_POST['display_name']);
        $bio = trim($_POST['bio']);
        $dark_mode = isset($_POST['dark_mode']) ? 1 : 0;

        // Validate inputs
        if (empty($username) || empty($email)) {
            $error = "Username and email are required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format";
        } else {
            // Check if username is taken by another user
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->bind_param("si", $username, $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $error = "Username is already taken";
            } else {
                // Handle profile image upload
                $profile_image = $user['profile_image']; // Keep existing image by default
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
                    $target_dir = "img/profile_images/";
                    $file_extension = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));
                    $new_filename = uniqid('profile_') . '.' . $file_extension;
                    $target_file = $target_dir . $new_filename;

                    // Check file type
                    if ($file_extension != "jpg" && $file_extension != "jpeg" && $file_extension != "png") {
                        $error = "Only JPG, JPEG, PNG files are allowed";
                    } else if ($_FILES["profile_image"]["size"] > 5000000) { // 5MB max
                        $error = "File is too large (max 5MB)";
                    } else if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                        // Delete old profile image if it exists and is not the default
                        if ($profile_image && $profile_image != "default.jpg" && file_exists($target_dir . $profile_image)) {
                            unlink($target_dir . $profile_image);
                        }
                        $profile_image = $new_filename;
                    } else {
                        $error = "Error uploading file";
                    }
                }

                if (!$error) {
                    // Update user data
                    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, display_name = ?, bio = ?, profile_image = ?, dark_mode = ? WHERE id = ?");
                    $stmt->bind_param("sssssii", $username, $email, $display_name, $bio, $profile_image, $dark_mode, $_SESSION['user_id']);
                    
                    if ($stmt->execute()) {
                        $message = "Profile updated successfully";
                        // Update session variables
                        $_SESSION['username'] = $username;
                    } else {
                        $error = "Error updating profile";
                    }
                }
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - FitQuest</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        .settings-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: var(--background-color);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .settings-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .settings-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            color: var(--text-color);
            font-weight: 500;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group textarea {
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            background-color: var(--background-light);
            color: var(--text-color);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .profile-image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .switch-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .message {
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            text-align: center;
        }

        .success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <div class="settings-container">
            <div class="settings-header">
                <h2>User Settings</h2>
            </div>

            <?php if ($message): ?>
                <div class="message success">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="message error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="settings-form" enctype="multipart/form-data">
                <div class="profile-image-container">
                    <img class="profile-image" src="<?php echo htmlspecialchars($user['profile_image'] ? 'img/profile_images/' . $user['profile_image'] : 'https://via.placeholder.com/150'); ?>" alt="Profile picture" id="profile-preview">
                    <div class="form-group">
                        <label for="profile_image">Change Profile Picture</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/jpeg,image/png" onchange="previewImage(this);">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="display_name">Display Name</label>
                    <input type="text" id="display_name" name="display_name" value="<?php echo htmlspecialchars($user['display_name']); ?>">
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                </div>

                <div class="form-group">
                    <div class="switch-container">
                        <label for="dark_mode">Dark Mode</label>
                        <label class="switch">
                            <input type="checkbox" id="dark_mode" name="dark_mode" <?php echo $user['dark_mode'] ? 'checked' : ''; ?>>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <button type="submit" name="update_profile" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </main>

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

        // Preview profile image before upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>