<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Подключение к базе данных
$servername = "localhost";
$dbusername = "root";
$password = "root";
$dbname = "pm09";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем список достижений пользователя
$sql = "SELECT id, achievement_text, achievement_date FROM achievements WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
  die("Ошибка подготовки запроса: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$achievements = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $achievements[] = $row;
    }
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#2c3e50">
    <title>Личный кабинет | Портал по здоровью и фитнесу</title>
    <style>
        /* Базовые стили */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --text-color: #333;
            --light-text: #fff;
            --border-color: #ddd;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }
        
        html, body {
            height: 100%;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5)),
                url('https://sportzim86.ru/wp-content/uploads/2018/10/man.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
        }
        
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
        }
        
        /* Шапка */
        header {
            background-color: rgba(44, 62, 80, 0.9);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
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
        
        /* Мобильное меню */
        .menu-toggle {
            display: block;
            background: none;
            border: none;
            color: var(--light-text);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px 10px;
        }
        
        nav {
            width: 100%;
            order: 3;
            margin-top: 10px;
            display: none;
        }
        
        nav.active {
            display: block;
        }
        
        .nav-menu {
            list-style: none;
            background-color: rgba(44, 62, 80, 0);
            border-radius: 5px;
            overflow: hidden;
        }
        
        .nav-menu li {
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .nav-menu a {
            color: var(--light-text);
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .nav-menu a:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        /* Основное содержимое */
        main {
            flex: 1;
            padding: 30px 0;
            width: 100%;
        }
        
        .profile-section {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 30px;
            margin: 0 auto 30px;
            width: 90%;
            max-width: 800px;
            box-shadow: var(--shadow);
        }
        
        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 25px;
            font-size: clamp(1.5rem, 5vw, 2rem);
        }
        
        /* Информация о профиле */
        .profile-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-color);
        }
        
        .profile-details {
            flex: 1;
        }
        
        .profile-details p {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .profile-details span {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        /* Достижения */
        .achievements-list {
            margin-bottom: 30px;
        }
        
        .achievement {
            background-color: rgba(255, 255, 255, 0.9);
            border-left: 4px solid var(--accent-color);
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 0 5px 5px 0;
        }
        
        .achievement-date {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        
        .achievement-description {
            font-size: 1rem;
        }
        
        /* Форма добавления достижения */
        .add-achievement-form {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .add-achievement-form input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
        }
        
        .add-button {
            padding: 12px 20px;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .add-button:hover {
            background-color: #2980b9;
        }
        
        /* Кнопка выхода */
        .logout-link {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--secondary-color);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: var(--transition);
            text-align: center;
        }
        
        .logout-link:hover {
            background-color: #c0392b;
        }
        
        /* Подвал */
        footer {
            background-color: rgba(44, 62, 80, 0.9);
            color: var(--light-text);
            text-align: center;
            padding: 20px 0;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            width: 100%;
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
            
            .nav-menu {
                display: flex;
                background: none;
            }
            
            .nav-menu li {
                border-top: none;
                margin-left: 15px;
            }
            
            .nav-menu a {
                padding: 8px 12px;
                border-radius: 4px;
            }
        }
        
        /* Адаптация для мобильных */
        @media (max-width: 767px) {
            .profile-info {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-bottom: 15px;
            }
            
            .add-achievement-form {
                flex-direction: column;
            }
            
            .profile-section {
                padding: 20px;
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
                <a href="index.html" class="logo">Здоровый образ жизни с нами!</a>
                <button class="menu-toggle" onclick="toggleMenu()">☰</button>
                <nav id="main-nav">
                    <ul class="nav-menu">
                        <li><a href="index.html">База знаний</a></li>
                        <li><a href="programs.html">Программы</a></li>
                        <li><a href="profile.php">Личный кабинет</a></li>
                        <li><a href="calculator.html">Калькулятор</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section id="user-profile" class="profile-section">
                <div class="container">
                    <h2>Личный кабинет</h2>
                    <div class="profile-info">
                        <img src="https://avatars.mds.yandex.net/i?id=9845748e58ffdd02a7044445b5393d77_l-8340505-images-thumbs&n=13" alt="Аватар пользователя" class="profile-avatar">
                        <div class="profile-details">
                            <p>Добро пожаловать, <span><?php echo htmlspecialchars($username); ?></span>!</p>
                            <p>ID пользователя: <span><?php echo htmlspecialchars($user_id); ?></span></p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="achievements" class="profile-section">
                <div class="container">
                    <h2>История достижений</h2>
                    <?php if (count($achievements) > 0): ?>
                        <div class="achievements-list">
                            <?php foreach ($achievements as $achievement): ?>
                                <div class="achievement">
                                    <p class="achievement-date">Дата: <?php echo htmlspecialchars($achievement['achievement_date']); ?></p>
                                    <p class="achievement-description">Достижение: <?php echo htmlspecialchars($achievement['achievement_text']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>У вас пока нет достижений.</p>
                    <?php endif; ?>

                    <div class="achievement add-achievement">
                        <p>Добавить новое достижение:</p>
                        <form action="add_achievement.php" method="post" class="add-achievement-form">
                            <input type="text" name="achievement_text" placeholder="Введите новое достижение" required>
                            <button type="submit" class="add-button">Добавить</button>
                        </form>
                    </div>
                </div>
            </section>

            <section id="settings" class="profile-section">
                <div class="container">
                    <a href="index.html" class="logout-link">Выйти</a>
                </div>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>&copy; 2025 Портал по здоровью и фитнесу</p>
            </div>
        </footer>
    </div>

    <script>
        // Функция для переключения мобильного меню
        function toggleMenu() {
            const nav = document.getElementById('main-nav');
            nav.classList.toggle('active');
        }
        
        // Закрытие меню при клике на пункт (для мобильных)
        document.querySelectorAll('.nav-menu a').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    document.getElementById('main-nav').classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>