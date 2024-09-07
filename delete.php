<?php
require_once ("connect_db.php"); // Подключение файла с настройками соединения базы данных

// Определяем класс Database для работы с базой данных
class Database {
    public $connection; // Свойство для хранения соединения с базой данных

    // Конструктор класса, принимающий соединение в качестве параметра
    public function __construct($connection) {
        $this->connection = $connection;

        // Проверяем наличие ошибок при подключении к базе данных
        if ($this->connection->connect_errno) {
            die('Ошибка! Не удалось подключиться к базе данных! ' . $this->connection->connect_errno);
        }
    }

    // Метод для удаления пользователя по ID
    public function deleteUser($id) {
        // Проверка, что ID является числом
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Неверный ID.");
        }

        // Проверка существования записи с данным ID
        $result = $this->connection->query("SELECT * FROM `users` WHERE `id` = $id");
        if ($result->num_rows == 0) {
            throw new Exception("Запись с таким ID не найдена.");
        }

        // Подготовка SQL-запроса для удаления записи
        $sql = "DELETE FROM `users` WHERE `id` = ?";
        $stmt = $this->connection->prepare($sql);

        // Проверка успешности подготовки запроса
        if ($stmt === false) {
            throw new Exception("Ошибка подготовки запроса: " . $this->connection->error);
        }

        $stmt->bind_param("i", $id); // Привязываем параметр ID (целое число)

        // Выполнение запроса и возврат результата
        if ($stmt->execute()) {
            return "Запись успешно удалена.";
        } else {
            throw new Exception("Ошибка при удалении записи: " . $stmt->error);
        }
    }

    // Деструктор для закрытия соединения с базой данных при уничтожении объекта
    public function __destruct() {
        $this->connection->close();
    }
}

// Создаем экземпляр класса Database для работы с базой данных
$db = new Database($mysql);

try {
    // Проверяем, указан ли ID в GET-запросе
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $message = $db->deleteUser($id); // Вызываем метод для удаления пользователя
        echo $message; // Выводим сообщение об успехе
    } else {
        echo "ID не указан."; // Если ID не указан, выводим сообщение
    }
} catch (Exception $e) {
    echo $e->getMessage(); // Обработка исключений и вывод сообщения об ошибке
}

// Перенаправление обратно на admin.php после выполнения операций
header("Location: admin.php");
exit();
?>