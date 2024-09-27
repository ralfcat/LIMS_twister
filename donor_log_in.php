<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blood Donor Log in</title>
    <link rel="stylesheet" href="stylesheet/styles.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap">
</head>

<body>
    <div class="box">
        <h1>Donor Log in</h1>
        <form action="my_donations.php" method="GET">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Type email" />
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Type password" />
            </div>
            <button type="submit">Log in</button>
        </form>

        <!-- New user link on the same line -->
        <div class="new-user">
            <p>New user? <a href="create_account.php">Create an account here</a></p>
        </div>
    </div>
</body>
</html>

