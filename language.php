<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_GET['name']; ?> Cheat Sheet</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: #f0f0f0;
            margin: 0;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .cheat-sheet-item {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #363636;
        }
        .cheat-sheet-item h2 {
            margin-top: 0;
        }
        .cheat-sheet-item button {
            margin-top: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .cheat-sheet-item button:hover {
            background-color: #3e8e41;
        }
        .cheat-sheet-item pre {
            margin: 0;
            background-color: #2d2d2d;
            color: #f0f0f0;
            padding: 10px;
            overflow-x: auto;
            border-radius: 5px;
        }
        .cheat-sheet-item .expanded-content {
            display: none;
        }
        .cheat-sheet-item.expanded .expanded-content {
            display: block;
        }
        .search-bar {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .search-input {
            width: 80%;
            max-width: 400px;
            margin-right: 20px;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }
        .sort-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .sort-button {
            background-color: #4caf50;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .sort-button:hover {
            background-color: #3e8e41;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #fff;
            text-decoration: none;
        }

        .back-link i {
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <?php
        require_once("config.php");

        try {
            $stmt = $conn->prepare("SELECT * FROM languages WHERE name = ?");
            $stmt->execute(array($_GET['name']));
            $language = $stmt->fetch();

            if (!$language) {
                echo "<div class='container'><p>Language not found.</p></div>";
                exit();
            }

            $stmt = $conn->prepare("SELECT * FROM cheat_sheet_items WHERE language_id = ?");
            $stmt->execute(array($language['id']));
            $cheat_sheet_items = $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "<div class='container'><p>Error: " . $e->getMessage() . "</p></div>";
            exit();
        }
    ?>

    <div class="search-bar">
        <input type="text" placeholder="Search..." class="search-input">
    </div>

    <div class="sort-buttons">
        <button class="sort-button" data-type="All">All</button>
        <?php
            $stmt = $conn->prepare("SELECT DISTINCT type FROM cheat_sheet_items WHERE language_id = ?");
            $stmt->execute(array($language['id']));
            $types = $stmt->fetchAll();

            foreach ($types as $type) {
                echo "<button class='sort-button' data-type='" . $type['type'] . "'>" . $type['type'] . "</button>";
            }
        ?>
    </div>
    <a href="index.php" class="back-link"><i class="material-icons">arrow_back</i>Back to main menu</a>
    
    <div class="container">
        <h1><?php echo $language['name'] ?></h1>
        <p>Showing information about <?php echo $language['name']; ?></p>

        <?php foreach ($cheat_sheet_items as $item) { ?>
            <div class="cheat-sheet-item" data-type="<?php echo $item['type']; ?>">
                <h2><?php echo $item['type'] . " - " . $item['name']; ?></h2>
                <p><?php echo $item['short_description']; ?></p>
                <button class="expand-button">See more</button>
                <div class="expanded-content">
                    <h3>Long Description:</h3>
                    <p><?php echo $item['long_description']; ?></p>
                    <h3>Example 1: <?php echo $item['example_1_description']; ?></h3>
                    <pre><code><?php echo $item['example_1_code']; ?></code></pre>
                    <h3>Example 2: <?php echo $item['example_2_description']; ?></h3>
                    <pre><code><?php echo $item['example_2_code']; ?></code></pre>
                </div>
            </div>
        <?php } ?>
    </div>
    <script>
        const expandButtons = document.querySelectorAll('.expand-button');
        expandButtons.forEach(button => {
            button.addEventListener('click', () => {
                const cheatSheetItem = button.parentElement;
                cheatSheetItem.classList.toggle('expanded');
                button.innerHTML = cheatSheetItem.classList.contains('expanded') ? 'Collapse' : 'See more';
            });
        });

        const sortButtons = document.querySelectorAll('.sort-button');
        sortButtons.forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-type');
                const cheatSheetItems = document.querySelectorAll('.cheat-sheet-item');

                cheatSheetItems.forEach(item => {
                    const shouldShow = type === 'All' || item.getAttribute('data-type') === type;
                    item.style.display = shouldShow ? 'block' : 'none';
                });
            });
        });

        const cheatSheetItems = document.querySelectorAll('.cheat-sheet-item');
        const filterItems = () => {
            const searchText = document.querySelector('.search-input').value.toLowerCase();
            let results = [];

            cheatSheetItems.forEach(item => {
                const type = item.getAttribute('data-type').toLowerCase();
                const name = item.querySelector('h2').innerHTML.toLowerCase();
                const shortDescription = item.querySelector('p').innerHTML.toLowerCase();

                if (type.includes(searchText) || name.includes(searchText) || shortDescription.includes(searchText)) {
                    item.style.display = 'block';
                    results.push(item);
                } else {
                    item.style.display = 'none';
                }
            });

            return resultsM
        };

        document.querySelector('.search-input').addEventListener('input', () => {
            const results = filterItems();

            if (results.length > 0) {
                window.scrollTo({top: results[0].offsetTop - 20, behavior: 'smooth'});
            }
        });
    </script>
</body>
</html>