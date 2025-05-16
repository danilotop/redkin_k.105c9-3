<?php
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "pm09";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


$conn->set_charset("utf8mb4");

$username = $_POST['username'] ?? ''; 
$password = $_POST['password'] ?? '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT id, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {

            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            header("Location: profile.php?user_id=" . $user_id);
            exit();
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Пользователь не найден.";
    }

    $stmt->close();
} else {
    echo "Необходимо отправить данные через форму.";
}

$conn->close();
?>