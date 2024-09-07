<?php
class Main  // Определение класса Main для создания и обработки формовых полей
{
    public $type;          // Тип поля ввода (например, text, password)
    public $placeholder;   // Подсказка для поля ввода
    public $name;          // Имя поля ввода
    public $maxlength;     // Максимальная длина ввода
    public $value;         // Значение поля ввода

    // Конструктор класса, который инициализирует свойства при создании объекта
    public function __construct($type, $placeholder, $name, $maxlength, $value)
    {
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->name = $name;
        $this->maxlength = $maxlength;
        $this->value = $value;
    }

    // Метод для проверки сессии на наличие значения и его соответствие капче
    public function testSession()
    {
        if (isset($_SESSION[$this->value]) && $_SESSION[$this->value] != $_SESSION['captcha'])
        {
            return $_SESSION[$this->value];
        }
    }

    // Метод для создания поля ввода в HTML
    public function makeInput()
    {
        echo "<div>";
        // Формируем HTML-код для поля ввода с заданными атрибутами
        echo "<input type=".$this->type." placeholder=".$this->placeholder." id=".$this->name." name=".$this->name." maxlength=".$this->maxlength." value=".$this->testSession().">"."</br>";
        echo "</div>";
    }

    // Метод для проверки статуса поля ввода и вывода соответствующих сообщений об ошибках
    public function checkInput()
    {
        // Проверка наличия ошибок в сессии и вывод соответствующих сообщений
        if (isset($_SESSION[$this->name."Empty"]))
        {
            echo "<div class='error'>".$_SESSION[$this->name."Empty"]."</div></br>";
        }
        elseif (isset($_SESSION[$this->name."Short"]))
        {
            echo "<div class='error'>".$_SESSION[$this->name."Short"]."</div></br>";
        }
        elseif (isset($_SESSION[$this->name."Long"]))
        {
            echo "<div class='error'>".$_SESSION[$this->name."Long"]."</div></br>";
        }
        elseif (isset($_SESSION[$this->name."Good"]))
        {
            echo "<div class='currectly'>".$_SESSION[$this->name."Good"]."</div></br>";
        }
        elseif (isset($_SESSION[$this->name."Forbidden"]))
        {
            echo "<div class='error'>".$_SESSION[$this->name."Forbidden"]."</div></br>";
        }
        else if (isset($_SESSION['admin'.$this->name]))
        {
            echo "<div class='currectly'>".$_SESSION['admin'.$this->name]."</div></br>";
        }
    }

    // Метод для создания текстовой области в HTML
    public function makeArea()
    {
        echo "<div>";
        // Формируем HTML-код для текстовой области с заданными атрибутами
        echo "<textarea name=".$this->name." placeholder=".$this->placeholder." maxlength=".$this->maxlength."></textarea></br>";
        echo "</div>";
    }
}

class CreateForm // Определение класса CreateForm для создания HTML-форм
{
    public $action; // Действие для формы (куда отправлять данные)
    public $method; // Метод отправки формы (GET или POST)

    private $button_click_time = "button_click_time"; // Имя скрытого поля для времени нажатия кнопки
    private $send = "send"; // Имя кнопки отправки формы

    // Конструктор класса, который инициализирует action и method при создании объекта
    public function __construct($action, $method)
    {
        $this->action = $action;
        $this->method = $method;
    }

    // Метод для вывода начала формы с заданными action и method
    public function startForm()
    {
        echo "<div>";
        echo "<form action=".$this->action." method=".$this->method.">";
    }

    // Метод для вывода конца формы
    public function endForm()
    {
        echo "</form>";
        echo "</div>";
    }

    // Метод для создания кнопки отправки формы
    public function makeSubmit() {
        echo "<div>";
        echo "<input type='hidden' name='" . $this->button_click_time . "' value=''>";
        echo "<button type='submit' name='" . $this->send . "' onclick='document.getElementsByName(\"" . $this->button_click_time . "\")[0].value = new Date();'>send</button><br>";
        echo "</div>";
    }

    // Метод для завершения сессии, очищая все переменные сессии
    public function endSession()
    {
        $_SESSION = [];
    }

    // Метод для проверки успешного завершения действия и вывода сообщения
    public function checkSuccess()
    {
        if (isset($_SESSION["success"]))
        {
            echo "<div class='currectly'>";
            echo $_SESSION["success"];
            echo "</div>";
        }
    }
}
class CheckPostInput
{
    public $name; // Имя поля ввода
    public $length; // Максимальная длина ввода
    private $regExpUsername = "/^[0-9a-zа-яё]{2,20}$/ui"; // Регулярное выражение для проверки имени пользователя
    private $regExpEmail = "/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i"; // Регулярное выражение для проверки email

    // Конструктор класса, инициализирующий имя поля и его длину
    public function __construct($name, $length)
    {
        $this->name = $name;
        $this->length = $length;
    }

    // Метод для получения и обработки данных из POST-запроса
    public function get()
    {
        if (empty($_SESSION[$this->name])) // Если значение сессии пустое
        {
            $_SESSION[$this->name] = htmlspecialchars(trim($_POST[$this->name])); // Обработка и сохранение данных
        } 
    }

    // Метод для проверки введённых данных
    public function check()
    {
        if (empty($_SESSION[$this->name])) // Проверка на пустое значение
        {
            $_SESSION[$this->name . "Empty"] = "empty"; // Установка сообщения о пустом значении
        }
        elseif (mb_strlen($_SESSION[$this->name]) < 2) // Проверка на короткое значение
        {
            $_SESSION[$this->name . "Short"] = "short";
        }
        elseif (mb_strlen($_SESSION[$this->name]) > $this->length) // Проверка на слишком длинное значение
        {
            $_SESSION[$this->name . "Long"] = "long";
        }
        else
        {
            $_SESSION[$this->name . "Forbidden"] = "forbidden"; // Если другие условия не выполнены
        }
    }

    // Метод для проверки имени пользователя на ограничения
    public function checkAdminUsername()
    {
        if ($_SESSION[$this->name] === 'admin') // Проверка на специальное значение 'admin'
        {
            $_SESSION['admin' . $this->name] = 'admin'; // Установка соответствующей сессии
        }
        elseif (empty($_SESSION[$this->name])) // Проверка на пустое значение
        {
            $_SESSION[$this->name . "Empty"] = "empty"; // Установка сообщения о пустом значении
        }
        elseif (mb_strlen($_SESSION[$this->name]) < 2) // Проверка на короткое значение
        {
            $_SESSION[$this->name . "Short"] = "short";
        }
        elseif (mb_strlen($_SESSION[$this->name]) > $this->length) // Проверка на слишком длинное значение
        {
            $_SESSION[$this->name . "Long"] = "long";
        }
        elseif (preg_match($this->regExpUsername, $_SESSION[$this->name])) // Проверка на соответствие регулярному выражению
        {
            $_SESSION[$this->name . "Good"] = "good"; // Установка сообщения о корректном значении
        }
        else
        {
            $_SESSION[$this->name . "Forbidden"] = "forbidden"; // Если другие условия не выполнены
        }
    }

    // Метод для проверки капчи
    public function checkCaptcha()
    {
        if ($_SESSION[$this->name] == $_POST[$this->name]) // Проверка на соответствие капчи
        {
            $_SESSION[$this->name . "Good"] = "good"; // Установка сообщения о корректной капче
        }
    }

    // Метод для проверки адреса электронной почты на ограничения
    public function checkAdminEmail()
    {
        if ($_SESSION[$this->name] === 'admin') // Проверка на специальное значение 'admin'
        {
            $_SESSION['admin' . $this->name] = 'admin'; // Установка соответствующей сессии
        }
        elseif (empty($_SESSION[$this->name])) // Проверка на пустое значение
        {
            $_SESSION[$this->name . "Empty"] = "empty"; // Установка сообщения о пустом значении
        }
        elseif (mb_strlen($_SESSION[$this->name]) < 2) // Проверка на короткое значение
        {
            $_SESSION[$this->name . "Short"] = "short";
        }
        elseif (mb_strlen($_SESSION[$this->name]) > $this->length) // Проверка на слишком длинное значение
        {
            $_SESSION[$this->name . "Long"] = "long";
        }
        elseif (preg_match($this->regExpEmail, $_SESSION[$this->name])) // Проверка на соответствие регулярному выражению
        {
            $_SESSION[$this->name . "Good"] = "good"; // Установка сообщения о корректном значении
        }
        else
        {
            $_SESSION[$this->name . "Forbidden"] = "forbidden"; // Если другие условия не выполнены
        }
    }

    // Метод для проверки длины текста в текстовой области
    public function checkArea()
    {
        if (mb_strlen($_SESSION[$this->name]) >= 2) // Проверка на длину текста
        {
            $_SESSION[$this->name . "Good"] = "good"; // Установка сообщения о корректном значении
        }
    }
}

class DB
{
    public $mysql;              // Соединение с базой данных
    public $email;              // Email пользователя
    public $text;               // Текст комментария
    public $username;           // Имя пользователя
    public $button_click_time;  // Время нажатия кнопки
    public $user_ip;            // IP пользователя
    public $user_browser;       // Браузер пользователя 

    // Конструктор класса, инициализирующий свойства при создании объекта
    public function __construct($mysql, $email, $text, $username, $button_click_time, $user_ip, $user_browser)
    {
        $this->mysql = $mysql;
        $this->text = $text;
        $this->username = $username;
        $this->email = $email;
        $this->button_click_time = $button_click_time;
        $this->user_ip = $user_ip;
        $this->user_browser = $user_browser;
    }

    // Метод для подключения и сохранения данных в базу данных
    public function connect()
    {
        // Проверка на корректность введённых данных
        if ($_SESSION["usernameGood"] && $_SESSION["emailGood"] && $_SESSION["captchaGood"] && $_SESSION["commentGood"])
        {
            $_SESSION["success"] = "success"; // Установка сообщения об успешной операции
            $this->mysql->query("INSERT INTO `users`(`username`,`email`,`text`,`date`,`browser`,`ip`) VALUES('$this->text','$this->username','$this->email','$this->button_click_time','$this->user_browser','$this->user_ip')"); // Вставка данных в базу
            header("Location:https://guestbook2/send.php"); // Перенаправление на страницу успеха
        }
        elseif ($_SESSION["adminusername"] && $_SESSION["adminemail"]) // Проверка на администраторские данные
        {
            header("Location:https://guestbook2/admin.php"); // Перенаправление на страницу администратора
        }
        else
        {
            header("Location:https://guestbook2/index.php"); // Перенаправление обратно на главную страницу
        }
    }
}
?>