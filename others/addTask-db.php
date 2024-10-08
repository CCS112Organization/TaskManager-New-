<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $date = $_POST["date"];

    if (trim($title) === "") {
        exit();
    }

    try {
        require_once "db.php";

        $query = "INSERT INTO ongoingTasks (`title`, `description`, `date`) VALUES (?, ?, ?);";
        $stmnt = $connection->prepare($query);

        if (!$stmnt) {
            die("Prepare failed: " . $connection->error);
        }

        $stmnt->bind_param("sss", $title, $description, $date);
        $stmnt->execute();

        $stmnt->close();
        $connection->close();

        header("Location: ../index.php");
        die();

    } catch (mysqli_sql_exception $e) {
        die("Connection Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}