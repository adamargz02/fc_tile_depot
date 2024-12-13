<?php
ob_start();
require_once('includes/load.php');

// Redirect logged-in users to the homepage
if ($session->isUserLoggedIn()) {
    redirect('home.php', false);
}

// Dynamically detect base URL
$host = $_SERVER['HTTP_HOST'];
if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
    $baseUrl = "http://localhost/Fc_Tile_Depot/";
} else {
    $baseUrl = "https://{$host}/fc_tile_depot/";
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="login-page">
    <div class="content-wrapper">
        <!-- Image Section -->
        <div class="image-section">
            <img src="uploads/logo/tile_logo.jpg" alt="Login Logo" class="login-image">
        </div>

        <!-- Login Form Section -->
        <div class="form-section">
            <div class="text-center">
                <h1>WELCOME</h1>
                <p>Sign in to start your session</p>
            </div>
            <?php echo display_msg($msg); ?>

            <!-- Login Form -->
            <form method="post" action="auth.php" class="clearfix" id="login-form">
                <div class="form-group">
                    <label for="username" class="control-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right">Login</button>
                    
                </div>
            </form>

            <!-- Status Notifications -->
            <div id="offline-warning" style="display: none; color: red; text-align: center; margin-top: 10px;">
                You are in Offline mode
            </div>
            <div id="online-notification" style="display: none; color: green; text-align: center; margin-top: 10px;">
                You are in Online mode
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get the current hostname
        const currentHost = window.location.hostname;

        // Get the notification elements
        const offlineWarning = document.getElementById("offline-warning");
        const onlineNotification = document.getElementById("online-notification");

        // Check if the hostname matches a local development or remote environment
        if (currentHost === "localhost" || currentHost.includes("127.0.0.1")) {
            // Display offline message
            offlineWarning.style.display = "block";
        } else if (currentHost.endsWith(".ngrok-free.app")) {
            // Display online message
            onlineNotification.style.display = "block";

            // Optionally hide the online message after 8 seconds
            setTimeout(() => {
                onlineNotification.style.display = "none";
            }, 8000);
        } else {
            // Handle unexpected URLs (optional)
            console.warn("Unrecognized environment: " + currentHost);
        }

        // Prevent form submission if offline
        document.getElementById("login-form").addEventListener("submit", function (e) {
            if (!navigator.onLine) {
                e.preventDefault(); // Stop form submission
                alert('You are offline. Please access the offline version at "http://localhost/Fc_Tile_Depot/index.php".');
                window.location.href = "http://localhost/Fc_Tile_Depot/index.php";
            }
        });
    });

    // Update connection status when online/offline state changes
    function updateConnectionStatus() {
        const offlineWarning = document.getElementById("offline-warning");
        const onlineNotification = document.getElementById("online-notification");

        if (navigator.onLine) {
            offlineWarning.style.display = "none";
            onlineNotification.style.display = "block";

            // Hide online notification after 3 seconds
            setTimeout(() => {
                onlineNotification.style.display = "none";
            }, 3000);
        } else {
            onlineNotification.style.display = "none";
            offlineWarning.style.display = "block";
        }
    }

    window.addEventListener("online", updateConnectionStatus);
    window.addEventListener("offline", updateConnectionStatus);
</script>

<?php include_once('layouts/footer.php'); ?>