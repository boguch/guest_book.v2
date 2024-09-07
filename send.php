<?php
class Comment {
    private $mysql; // Переменная для хранения соединения с базой данных

    // Конструктор класса, который принимает соединение с базой данных
    public function __construct($dbConnection) {
        $this->mysql = $dbConnection;
    }

    // Метод для получения данных комментариев с учетом параметров
    public function dataProvider(array $options) {
        // Подготавливаем лимиты для пагинации
        $start_from = ($options['page'] - 1) * $options['perPage'];
        // Формируем SQL-запрос с сортировкой и ограничением
        $sql = "SELECT `text`, `username`, `email`, `date`
                FROM `users`
                ORDER BY {$options['sortBy']} {$options['direction']}, `id` ASC
                LIMIT $start_from, {$options['perPage']}";
        $result = mysqli_query($this->mysql, $sql); // Выполняем запрос
        if (!$result) {
            die('Error: ' . mysqli_error($this->mysql)); // Обработка ошибок запроса
        }

        $data = [];
        // Извлечение данных из результата запроса
        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row; // Добавление строки в массив данных
        }

        return $data; // Возвращаем собранные данные
    }

    // Метод для получения общего количества комментариев
    public function getTotalCount() {
        $totalQuery = "SELECT COUNT(*) as count FROM `users`"; // Запрос на подсчет всех записей
        $totalResult = mysqli_query($this->mysql, $totalQuery); // Выполнение запроса
        return mysqli_fetch_assoc($totalResult)['count']; // Возвращаем общее количество
    }
    
    // Метод для получения ссылки на сортировку
    public function getSortLink($field, $currentDirection) {
        $direction = 'ASC' === $currentDirection ? 'DESC' : 'ASC'; // Переключение направления сортировки
        return sprintf('?sortBy=%s&dir=%s&page=%d', urlencode($field), $direction, intval($_GET['page'] ?? 1)); // Формирование URL-ссылки
    }
}
?>

<?php
$title = 'comments'; // Заголовок страницы - комментарии
$exile = 'index.php'; // Путь к главной странице
$exileTitle = 'main'; // Заголовок для главной страницы
require_once ("header.php"); // Подключение заголовка страницы
require_once ("connect_db.php"); // Подключение к базе данных

// Установка параметров для пагинации и сортировки
$options = [
    'page' => empty($_GET['page']) ? 1 : max(1, intval($_GET['page'])), // Страница по умолчанию 1
    'sortBy' => !empty($_GET['sortBy']) && in_array(strtolower($_GET['sortBy']), ['text', 'username', 'email', 'date']) ? strtolower($_GET['sortBy']) : 'username', // Поле для сортировки
    'direction' => !empty($_GET['dir']) && in_array(strtoupper($_GET['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['dir']) : 'ASC', // Направление сортировки
    'perPage' => 5 // Количество комментариев на странице
];

// Создание экземпляра класса Comment
$comment = new Comment($mysql);

// Получаем общее количество записей
$totalCount = $comment->getTotalCount();

// Определение общего числа страниц для пагинации
$totalPages = ceil($totalCount / $options['perPage']);

// Отображение таблицы с комментариями
?>
<div class="table-container">
<table>
    <thead>
       <tr>
          <th><a href="send.php<?= $comment->getSortLink('text', $options['direction']); ?>">text</a></th> <!-- Заголовок для текстового поля с ссылкой на сортировку -->
          <th><a href="send.php<?= $comment->getSortLink('username', $options['direction']); ?>">username</a></th> <!-- Заголовок для поля имени пользователя с ссылкой на сортировку -->
          <th><a href="send.php<?= $comment->getSortLink('email', $options['direction']); ?>">email</a></th> <!-- Заголовок для поля email с ссылкой на сортировку -->
          <th><a href="send.php<?= $comment->getSortLink('date', $options['direction']); ?>">date</a></th> <!-- Заголовок для поля даты с ссылкой на сортировку -->
       </tr>
    </thead>
    <tbody>
       <?php foreach ($comment->dataProvider($options) as $row) { ?> <!-- Цикл для вывода данных комментариев -->
       <tr>
           <td><?= htmlspecialchars($row['text']); ?></td> <!-- Вывод текста комментария -->
           <td><?= htmlspecialchars($row['username']); ?></td> <!-- Вывод имени пользователя -->
           <td><?= htmlspecialchars($row['email']); ?></td> <!-- Вывод адреса email -->
           <td><?= htmlspecialchars($row['date']); ?></td> <!-- Вывод даты комментария -->
       </tr>
       <?php } ?>
    </tbody>
</table>
</div>
<!-- Кнопки навигации для пагинации -->
<div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?> <!-- Цикл для вывода номеров страниц -->
        <a href="send.php?page=<?= $i; ?>&sortBy=<?= urlencode($options['sortBy']); ?>&dir=<?= $options['direction']; ?>"><?= $i; ?></a> <!-- Ссылка на соответствующую страницу -->
    <?php endfor; ?>
</div>

<?php
$mysql->close(); // Закрываем соединение с базой данных
require_once ("footer.php"); // Подключение подвала страницы
?>