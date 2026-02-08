<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$timeLeft = $_SESSION['expire'] - time();

if ($timeLeft <= 0) {
    session_destroy();
    header("Location: out.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            margin: 1;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: Arial, sans-serif;
        }

        .card {
            background: white;
            padding: 30px;
            width: 320px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
        }

        .timer {
            font-size: 1.3rem;
            font-weight: bold;
            color: #e63946;
            margin: 15px 0;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: #e63946;
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background: #c92a2a;
        }
        .watermark {
    position: fixed;
    bottom: 15px;
    right: 20px;
    font-size: 0.9rem;
    color: rgba(0, 0, 0, 0.25);
    pointer-events: none;
    user-select: none
    </style>
</head>
<body>

<div class="card">
    <h1>Welcome, <?php echo $_SESSION['user']; ?> 👋</h1>
    <p>Session expires in</p>
    <div class="timer">
        <span id="countdown"><?php echo $timeLeft; ?></span> seconds
    </div>

    <form method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</div>

<script>
    let timeLeft = <?php echo $timeLeft; ?>;
    const countdown = document.getElementById("countdown");

    const timer = setInterval(() => {
        timeLeft--;
        if (timeLeft < 0) timeLeft = 0;
        countdown.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(timer);
            window.location.href = "out.php";
        }
    }, 1000);
</script>

</body>
</html>
