<?php
http_response_code(404);
echo '<div style="text-align:center; margin-top:50px;">';
echo '<h1 style="color:#e74c3c;">404 - Page Not Found</h1>';
echo '<p>The page you are looking for does not exist.</p>';
echo '<a href="/index.php" style="color:#3498db; text-decoration:underline;">Go back to Home</a>';
echo '</div>';
