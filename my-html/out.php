<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8d7da;
            font-family: Arial, sans-serif;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h1 {
            color: #d62828;
            margin-bottom: 15px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: #457b9d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        a:hover {
            background: #1d3557;
        }
        .watermark {
    position: fixed;
    bottom: 15px;
    right: 20px;
    font-size: 0.9rem;
    color: rgba(0, 0, 0, 0.25);
    pointer-events: none;
    user-select: none;
}

    </style>
</head>
<body>

<div class="box">
    <h1>You are logged out ❌</h1>
    <a href="login.php">Log in again</a>
</div>

</body>
</html>
