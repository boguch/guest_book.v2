<?php
$title = 'main'; // Заголовок страницы
$exile = 'send.php'; // Файл для отправки комментариев
$exileTitle = 'comments'; // Заголовок для страницы комментариев

require_once ("header.php"); // Подключение заголовка страницы

require_once ("functions.php"); // Подключение необходимых функций

// Создание экземпляра класса CreateForm для формы регистрации с указанными параметрами
$createForm = new CreateForm("reg.php", "post");

// Создание полей ввода для имени пользователя, email, капчи и комментария
$inputUsername = new Main("text", "username", "username", "20", "username");
$inputEmail = new Main("text", "email", "email", "50", "email");
$inputCaptcha = new Main("text", "captcha", "captcha", "10", "captcha");
$inputComment = new Main("text", "comment", "comment", "1000", "comment");

// Проверка успешных операций и ошибочных вводов
$createForm->checkSuccess();
$createForm->startForm(); // Начало формы

// Создание и вывод инпутов для имени пользователя и email
$inputUsername->makeInput();
$inputUsername->checkInput();
$inputEmail->makeInput();
$inputEmail->checkInput();
?>
<div>
    <p><img id="captcha" src="captcha.php" alt="captcha"></p> <!-- Отображение капчи -->
    <button type="button" id="refreshImg"><span onclick="document.getElementById('captcha').src = 'captcha.php?' + Math.random()">refresh</span></button> <!-- Кнопка для обновления капчи -->
</div>
<?php
// Создание и вывод инпутов для капчи и комментария
$inputCaptcha->makeInput();
$inputCaptcha->checkInput();
$inputComment->makeArea();
$inputComment->checkInput();

// Завершение сессии и создание кнопки отправки формы
$createForm->endSession();
$createForm->makeSubmit();
$createForm->endForm(); // Конец формы

require_once ("footer.php"); // Подключение подвала страницы
?>