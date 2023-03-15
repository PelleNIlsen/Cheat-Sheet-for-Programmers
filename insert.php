<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 400px;
        }
        label, textarea, input, select, button {
            margin-bottom: 10px;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="insert.php" method="post">
        <label for="language">Language:</label>
        <input type="text" name="language" required>

        <label for="type">Type:</label>
        <input type="text" name="type" required>

        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="short_description">Short Description:</label>
        <textarea name="short_description" rows="3" required></textarea>

        <label for="long_description">Long Description:</label>
        <textarea name="long_description" rows="5" required></textarea>

        <label for="example_1_description">Example 1 Description:</label>
        <textarea name="example_1_description" rows="3" required></textarea>

        <label for="example_1_code">Example 1 Code:</label>
        <textarea name="example_1_code" rows="5" required></textarea>

        <label for="example_2_description">Example 2 Description:</label>
        <textarea name="example_2_description" rows="3" required></textarea>

        <label for="example_2_code">Example 2 Code:</label>
        <textarea name="example_2_code" rows="5" required></textarea>

        <button type="submit" name="submit">Insert</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        require_once("config.php");

        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // First query: insert or update the language
            $sql = "INSERT INTO languages (name) VALUES (:language) ON DUPLICATE KEY UPDATE id = id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':language', $_POST['language']);
            $stmt->execute();

            // Second query: insert the cheat sheet item
            $sql = "INSERT INTO cheat_sheet_items (
                language_id, type, name, short_description, long_description,
                example_1_description, example_1_code,
                example_2_description, example_2_code
                ) VALUES (
                (SELECT id FROM languages WHERE name = :language),
                :type, :name, :short_description, :long_description,
                :example_1_description, :example_1_code,
                :example_2_description, :example_2_code
            )";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':language', $_POST['language']);
            $stmt->bindParam(':type', $_POST['type']);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':short_description', $_POST['short_description']);
            $stmt->bindParam(':long_description', $_POST['long_description']);
            $stmt->bindParam(':example_1_code', $_POST['example_1_description']);
            $stmt->bindParam(':example_1_description', $_POST['example_1_code']);
            $stmt->bindParam(':example_2_code', $_POST['example_2_description']);
            $stmt->bindParam(':example_2_description', $_POST['example_2_code']);
            
            $stmt->execute();

            echo "<p style='color: #00ff00;'>Data inserted successfully!</p>";
        } catch (PDOException $e) {
            echo "<p style='color: #ff0000;'>Error: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>
</html>