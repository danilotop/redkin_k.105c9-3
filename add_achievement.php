<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "pm09";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

ob_start();

$achievement_text = $_POST['achievement_text'] ?? '';

if (!empty($achievement_text)) {

    $achievement_text = $conn->real_escape_string($achievement_text);


    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO achievements (user_id, achievement_text, achievement_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Ошибка подготовки запроса: " . $conn->error;
    } else {

        $stmt->bind_param("is", $user_id, $achievement_text);

        if ($stmt->execute()) {
             $_SESSION['message'] = "Достижение добавлено успешно!";
        } else {
             $_SESSION['message'] = "Ошибка при добавлении достижения: " . $stmt->error; 
        }

        $stmt->close();
    }
} else {
    $_SESSION['message'] = "Пожалуйста, введите текст достижения.";
}

$conn->close();

header("Location: profile.php");

ob_end_flush();
exit();

?>