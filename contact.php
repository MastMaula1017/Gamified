<?php
// Start session
session_start();

// Initialize variables
$success_message = "";
$error_message = "";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    // Connect to database
    require_once('includes/db_connect.php');
    
    // Get form data and sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Validate inputs
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        if ($stmt->execute()) {
            $success_message = "Thank you for your message! We'll get back to you soon.";
            // Clear form data after successful submission
            $name = $email = $subject = $message = "";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        $error_message = implode("<br>", $errors);
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - FitQuest</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        /* Contact Form Specific Styles */
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-xl);
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--spacing-xl);
        }
        
        @media (max-width: 768px) {
            .contact-container {
                grid-template-columns: 1fr;
            }
        }
        
        .contact-form {
            background-color: var(--background-color);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: var(--spacing-xl);
        }
        
        .contact-info {
            background-color: var(--primary-color);
            color: white;
            border-radius: var(--border-radius);
            padding: var(--spacing-xl);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .contact-info h3 {
            font-size: 1.5rem;
            margin-bottom: var(--spacing-md);
        }
        
        .contact-info p {
            margin-bottom: var(--spacing-lg);
            line-height: 1.6;
        }
        
        .contact-methods {
            margin-top: var(--spacing-xl);
        }
        
        .contact-method {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-md);
        }
        
        .contact-method .icon {
            margin-right: var(--spacing-md);
            font-size: 1.5rem;
        }
        
        .social-links {
            display: flex;
            gap: var(--spacing-md);
            margin-top: var(--spacing-xl);
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        
        .social-link:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px);
        }
        
        .form-group {
            margin-bottom: var(--spacing-md);
        }
        
        .form-group label {
            display: block;
            margin-bottom: var(--spacing-xs);
            font-weight: 500;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: var(--spacing-sm);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-family: inherit;
            font-size: 1rem;
        }
        
        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }
        
        .form-group.error input,
        .form-group.error textarea {
            border-color: var(--danger-color);
        }
        
        .error-text {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: var(--spacing-xs);
            display: none;
        }
        
        .form-group.error .error-text {
            display: block;
        }
        
        .contact-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: var(--spacing-sm) var(--spacing-lg);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .contact-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .contact-map {
            margin-top: var(--spacing-xl);
            border-radius: var(--border-radius);
            overflow: hidden;
            height: 200px;
        }
        
        .contact-map iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
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
                <li><a href="quiz.php">Quiz</a></li>
                <li class="active"><a href="contact.php">Contact Us</a></li>
                <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
            <li><a href="admin/index.php">Admin Panel</a></li>
            <?php endif; ?>
            </ul>
        </nav>
        <div class="user-menu">
            <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
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
            <?php else: ?>
                <a href="login.php" class="auth-link">Login</a>
                <a href="register.php" class="auth-link">Register</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <section class="page-header">
            <h2>Contact Us</h2>
            <p>Have questions or feedback? We'd love to hear from you!</p>
        </section>

        <?php if (!empty($success_message)): ?>
            <div class="auth-message success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="auth-message error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="contact-container">
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <form id="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group" id="name-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
                        <span class="error-text">Please enter your name</span>
                    </div>
                    
                    <div class="form-group" id="email-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                        <span class="error-text">Please enter a valid email address</span>
                    </div>
                    
                    <div class="form-group" id="subject-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" value="<?php echo isset($subject) ? $subject : ''; ?>" required>
                        <span class="error-text">Please enter a subject</span>
                    </div>
                    
                    <div class="form-group" id="message-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" required><?php echo isset($message) ? $message : ''; ?></textarea>
                        <span class="error-text">Please enter your message</span>
                    </div>
                    
                    <button type="submit" name="submit_contact" class="contact-btn">Send Message</button>
                </form>
            </div>
            
            <div class="contact-info">
                <div>
                    <h3>Get in Touch</h3>
                    <p>Have questions about our health gamification platform? Want to provide feedback or report an issue? We're here to help! Fill out the form or contact us directly using the information below.</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <span class="material-symbols-outlined icon">location_on</span>
                            <span>123 Health Street, Fitness City, FC 12345</span>
                        </div>
                        
                        <div class="contact-method">
                            <span class="material-symbols-outlined icon">call</span>
                            <span>(123) 456-7890</span>
                        </div>
                        
                        <div class="contact-method">
                            <span class="material-symbols-outlined icon">mail</span>
                            <span>contact@fitquest.com</span>
                        </div>
                        
                        <div class="contact-method">
                            <span class="material-symbols-outlined icon">schedule</span>
                            <span>Monday - Friday: 9am - 5pm</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <span class="material-symbols-outlined">language</span>
                        </a>
                        <a href="#" class="social-link">
                            <span class="material-symbols-outlined">alternate_email</span>
                        </a>
                        <a href="#" class="social-link">
                            <span class="material-symbols-outlined">forum</span>
                        </a>
                        <a href="#" class="social-link">
                            <span class="material-symbols-outlined">share</span>
                        </a>
                    </div>
                    
                    <div class="contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a23e28c1191%3A0x49f75d3281df052a!2s150%20Park%20Row%2C%20New%20York%2C%20NY%2010007%2C%20USA!5e0!3m2!1sen!2sus!4v1679869181584!5m2!1sen!2sus" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
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
        <a href="activity_tracker.php">
            <span class="material-symbols-outlined">monitor_heart</span>
            <span>Activity</span>
        </a>
    </nav>

    <script>
        // Setup user dropdown if logged in
        const userMenuBtn = document.getElementById('user-menu-btn');
        if (userMenuBtn) {
            userMenuBtn.addEventListener('click', function() {
                document.getElementById('user-dropdown').classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const userDropdown = document.getElementById('user-dropdown');
                
                if (!userMenuBtn.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.remove('active');
                }
            });
        }
        
        // Form validation
        const contactForm = document.getElementById('contact-form');
        
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validate name
                const nameInput = document.getElementById('name');
                const nameGroup = document.getElementById('name-group');
                
                if (!nameInput.value.trim()) {
                    nameGroup.classList.add('error');
                    isValid = false;
                } else {
                    nameGroup.classList.remove('error');
                }
                
                // Validate email
                const emailInput = document.getElementById('email');
                const emailGroup = document.getElementById('email-group');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!emailInput.value.trim() || !emailPattern.test(emailInput.value)) {
                    emailGroup.classList.add('error');
                    isValid = false;
                } else {
                    emailGroup.classList.remove('error');
                }
                
                // Validate subject
                const subjectInput = document.getElementById('subject');
                const subjectGroup = document.getElementById('subject-group');
                
                if (!subjectInput.value.trim()) {
                    subjectGroup.classList.add('error');
                    isValid = false;
                } else {
                    subjectGroup.classList.remove('error');
                }
                
                // Validate message
                const messageInput = document.getElementById('message');
                const messageGroup = document.getElementById('message-group');
                
                if (!messageInput.value.trim()) {
                    messageGroup.classList.add('error');
                    isValid = false;
                } else {
                    messageGroup.classList.remove('error');
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
            
            // Real-time validation
            const inputs = contactForm.querySelectorAll('input, textarea');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateInput(this);
                });
                
                input.addEventListener('input', function() {
                    validateInput(this);
                });
            });
            
            function validateInput(input) {
                const formGroup = input.closest('.form-group');
                
                if (input.id === 'email') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    
                    if (!input.value.trim() || !emailPattern.test(input.value)) {
                        formGroup.classList.add('error');
                    } else {
                        formGroup.classList.remove('error');
                    }
                } else {
                    if (!input.value.trim()) {
                        formGroup.classList.add('error');
                    } else {
                        formGroup.classList.remove('error');
                    }
                }
            }
        }
    </script>
</body>
</html>