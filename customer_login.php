<!DOCTYPE html>
<html lang="en">
<body>
    <div class="login-container">
        <h2>Customer Login</h2>
        <form action="customer_login_process.php" method="post">
            <label for="username">Email Address:</label>
            <input type="text" id="username" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>

</html>