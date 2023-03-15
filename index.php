<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Cheat Sheet for Programmers</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 2.5rem;
            margin: 30px 0;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 40px;
            justify-items: center;
            align-items: center;
            max-width: 1200px;
            padding: 40px;
            box-sizing: border-box;
            width: 100%;
        }
        .grid-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 250px;
            border-radius: 10px;
            background-color: #484848;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }
        .grid-item:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
        }
        .grid-item i {
            font-size: 4rem;
            color: #f0f0f0;
            margin-bottom: 20px;
        }
        .grid-item p {
            margin: 0;
            font-size: 1.8rem;
            text-align: center;
            color: #f0f0f0;
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
                margin: 20px 0;
                text-align: center;
            }
            .grid {
                grid-gap: 20px;
                padding: 20px;
            }
            .grid-item {
                height: 200px;
            }
            .grid-item i {
                font-size: 3rem;
            }
            .grid-item p {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <h1>Official Cheat Sheet for Programmers</h1>
    <div class="grid">
        <a href="language.php?name=HTML" class="grid-item">
            <i class="material-icons">html5</i>
            <p>HTML</p>
        </a>
        <a href="language.php?name=CSS" class="grid-item">
            <i class="material-icons">css3</i>
            <p>CSS</p>
        </a>
        <a href="language.php?name=JavaScript" class="grid-item">
            <i class="material-icons">javascript</i>
            <p>JavaScript</p>
        </a>
        <!-- Add more programming languages here -->
    </div>
</body>
</html>