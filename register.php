<?php
session_start();

// Параметры подключения к базе данных
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'root';
$db_name = 'pm09';

// Подключение к базе данных
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Создание таблицы, если не существует
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Обработка формы регистрации
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Валидация
    if (empty($username) || empty($password)) {
        $error = "Все поля обязательны для заполнения";
    } elseif (strlen($username) < 3) {
        $error = "Логин должен содержать минимум 3 символа";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен содержать минимум 6 символов";
    } else {
        // Проверка существования пользователя
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Пользователь с таким логином уже существует";
        } else {
            // Регистрация нового пользователя
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);
            
            if ($stmt->execute()) {
                $success = "Регистрация прошла успешно!";
                $_SESSION['username'] = $username;
                header("Refresh: 3; url=login.php"); // Перенаправление через 3 секунды
            } else {
                $error = "Ошибка регистрации: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Регистрация</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --text-color: #333;
            --light-text: #fff;
            --border-color: #ddd;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
            --success-color: #27ae60;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: 
                linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0)),
                url('https://i.pinimg.com/originals/2d/58/68/2d58688c9f62d6e01d24565d8c8cc839.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Шапка */
        header {
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .container {
            width: 100%;
            padding: 0 15px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            margin: 0;
            font-weight: 700;
            color: var(--light-text);
            text-decoration: none;
            padding: 5px 0;
        }

        /* Навигация для мобильных */
        nav {
            width: 100%;
            order: 3;
            margin-top: 10px;
            display: none;
        }

        nav.active {
            display: block;
        }

        nav ul {
            list-style: none;
            background-color: var(--primary-color);
            border-radius: 5px;
            overflow: hidden;
        }

        nav li {
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        nav a {
            color: var(--light-text);
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            font-size: 1rem;
            transition: var(--transition);
        }

        nav a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* Кнопка меню для мобильных */
        .menu-toggle {
            display: block;
            background: none;
            border: none;
            color: var(--light-text);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px 10px;
        }

        /* Основное содержимое */
        main {
            flex: 1;
            padding: 30px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-section {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--shadow);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 25px;
            font-size: clamp(1.5rem, 5vw, 2rem);
        }

        /* Форма регистрации */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--primary-color);
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: var(--transition);
        }

        input:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .error {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: orangered;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .alert-error {
            background-color: #fdecea;
            color: var(--secondary-color);
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: var(--success-color);
            border: 1px solid #c3e6cb;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95rem;
        }

        .login-link a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Подвал */
        footer {
            background-color: var(--primary-color);
            color: var(--light-text);
            text-align: center;
            padding: 20px 0;
            margin-top: auto;
        }

        /* Адаптация для планшетов и десктопов */
        @media (min-width: 768px) {
            .menu-toggle {
                display: none;
            }
            
            nav {
                display: block;
                width: auto;
                order: 2;
                margin-top: 0;
            }
            
            nav ul {
                display: flex;
                background: none;
            }
            
            nav li {
                border-top: none;
                margin-left: 15px;
            }
            
            nav a {
                padding: 8px 12px;
                border-radius: 4px;
            }
        }

        /* Адаптация для очень маленьких экранов */
        @media (max-width: 480px) {
            .register-section {
                padding: 20px;
                margin: 0 10px;
            }
            
            h1 {
                font-size: 1.4rem;
                margin-bottom: 20px;
            }
            
            input, .btn {
                padding: 12px;
            }
        }

        /* Поддержка устройств с notch */
        @supports(padding: max(0px)) {
            body, header, footer {
                padding-left: max(15px, env(safe-area-inset-left));
                padding-right: max(15px, env(safe-area-inset-right));
            }
            
            header {
                padding-top: max(15px, env(safe-area-inset-top));
            }
            
            footer {
                padding-bottom: max(15px, env(safe-area-inset-bottom));
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="container header-container">
                <h1 class="logo">Здоровый образ жизни с нами!</h1>
                <button class="menu-toggle" onclick="toggleMenu()">☰</button>
                <nav id="main-nav">
                    <ul>
                        <li><a href="index.html">Главная</a></li>
                        <li><a href="programs.html">Программы</a></li>
                        <li><a href="profile.html">Профиль</a></li>
                        <li><a href="calculator.html">Калькулятор</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section class="register-section">
                <h1>Регистрация</h1>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Имя пользователя</label>
                        <input type="text" id="username" name="username" required 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" required>
                        <small class="error">Минимум 6 символов</small>
                    </div>
                    
                    <button type="submit" class="btn">Зарегистрироваться</button>
                </form>
                
                <div class="login-link">
                    Уже есть аккаунт? <a href="login.html">Войти</a>
                </div>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> Фитнес-портал. Все права защищены.</p>
            </div>
        </footer>
    </div>

    <script>
        // Переключение мобильного меню
        function toggleMenu() {
            const nav = document.getElementById('main-nav');
            nav.classList.toggle('active');
        }

        // Валидация формы на клиенте
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            let isValid = true;

            if (username.length < 3) {
                isValid = false;
                alert('Имя пользователя должно содержать минимум 3 символа');
            }

            if (password.length < 6) {
                isValid = false;
                alert('Пароль должен содержать минимум 6 символов');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>