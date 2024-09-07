<?php
// Класс Comment для работы с комментариями.
class Comment {
    private $mysql;

    // Конструктор принимает соединение с базой данных и сохраняет его в свойство $mysql.
    public function __construct($dbConnection) {
        $this->mysql = $dbConnection;
    }

    // Метод dataProvider получает комментарии из базы данных с параметрами для пагинации, сортировки и выборки.
    public function dataProvider(array $options) {
        // Рассчитываем начальный индекс для выборки с учётом текущей страницы и количества записей на странице.
        $start_from = ($options['page'] - 1) * $options['perPage'];
        // Формируем SQL-запрос для получения комментариев, учитывающий сортировку и пагинацию.
        $sql = "SELECT `id`, `text`, `username`, `email`, `date`
                FROM `users`
                ORDER BY {$options['sortBy']} {$options['direction']}, `id` ASC
                LIMIT $start_from, {$options['perPage']}";
        // Выполняем SQL-запрос.
        $result = mysqli_query($this->mysql, $sql);
        // Проверяем на наличие ошибок при выполнении запроса.
        if (!$result) {
            die('Error: ' . mysqli_error($this->mysql));
        }

        $data = [];
        // Извлекаем данные из результата запроса и добавляем их в массив $data.
        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row;
        }

        return $data; // Возвращаем массив данных.
    }

    // Метод getTotalCount возвращает общее количество комментариев в базе данных.
    public function getTotalCount() {
        $totalQuery = "SELECT COUNT(*) as count FROM `users`"; // SQL-запрос для подсчёта количества комментариев.
        $totalResult = mysqli_query($this->mysql, $totalQuery);
        return mysqli_fetch_assoc($totalResult)['count']; // Возвращаем значение количества.
    }
    
    // Метод getSortLink генерирует ссылку для сортировки.
    public function getSortLink($field, $currentDirection) {
        $direction = 'ASC' === $currentDirection ? 'DESC' : 'ASC'; // Меняем направление сортировки.
        return sprintf('?sortBy=%s&dir=%s&page=%d', urlencode($field), $direction, intval($_GET['page'] ?? 1)); // Формируем ссылку.
    }
}
?>

<?php
$title = 'comments'; // Заголовок страницы.
$exile = 'index.php'; // Ссылка для возврата на главную страницу.
$exileTitle = 'main'; // Название ссылки возврата.
require_once ("header.php"); // Подключаем заголовок страницы.
require_once ("connect_db.php"); // Подключаем файл с настройками соединения базы данных.

// Получаем параметры для пагинации и сортировки.
$options = [
    'page' => empty($_GET['page']) ? 1 : max(1, intval($_GET['page'])), // Текущая страница.
    'sortBy' => !empty($_GET['sortBy']) && in_array(strtolower($_GET['sortBy']), ['text', 'username', 'email', 'date']) ? strtolower($_GET['sortBy']) : 'username', // Поле сортировки.
    'direction' => !empty($_GET['dir']) && in_array(strtoupper($_GET['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['dir']) : 'ASC', // Направление сортировки.
    'perPage' => 5 // Количество комментариев на странице.
];

// Создание экземпляра класса Comment.
$comment = new Comment($mysql);

// Получаем общее количество записей для пагинации.
$totalCount = $comment->getTotalCount();

// Рассчитываем общее количество страниц.
$totalPages = ceil($totalCount / $options['perPage']);

// Отображение таблицы с комментариями.
?>
<div class="table-container">
<table>
    <thead>
       <tr>
          <th><a href="admin.php<?= $comment->getSortLink('text', $options['direction']); ?>">text</a></th>
          <th><a href="admin.php<?= $comment->getSortLink('username', $options['direction']); ?>">username</a></th>
          <th><a href="admin.php<?= $comment->getSortLink('email', $options['direction']); ?>">email</a></th>
          <th><a href="admin.php<?= $comment->getSortLink('date', $options['direction']); ?>">date</a></th>
          <th>actions</th>
       </tr>
    </thead>
    <tbody>
       <?php foreach ($comment->dataProvider($options) as $row) { ?>
       <tr>
           <td><?= htmlspecialchars($row['text']); ?></td> 
           <td><?= htmlspecialchars($row['username']); ?></td> 
           <td><?= htmlspecialchars($row['email']); ?></td> 
           <td><?= htmlspecialchars($row['date']); ?></td> 
           <td><a href='delete.php?id=<?= $row["id"]; ?>'>delete</a></td> 
       </tr>
       <?php } ?>
    </tbody>
</table>
</div>
<!-- Кнопки навигации для смены страниц. -->
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="admin.php?page=<?= $i; ?>&sortBy=<?= urlencode($options['sortBy']); ?>&dir=<?= $options['direction']; ?>"><?= $i; ?></a> 
    <?php endfor; ?>
</div>

<?php
$mysql->close(); // Закрываем соединение с базой данных.
require_once ("footer.php"); // Подключаем подвал страницы.
?>