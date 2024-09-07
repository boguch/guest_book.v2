<?php
session_start(); // Начинаем сессию для хранения значения капчи

// Определяем класс CaptchaImage для создания изображений капчи
class CaptchaImage {
    private $width; // Ширина изображения
    private $height; // Высота изображения
    private $image; // Ресурс изображения
    private $font; // Шрифт для текста капчи
    private $text; // Текст капчи

    // Конструктор класса, инициализирует параметры изображения и генерирует капчу
    public function __construct($width = 200, $height = 50, $font = "georgia.ttf") {
        $this->width = $width;
        $this->height = $height;
        $this->font = $font;

        // Создаем пустое изображение
        $this->image = imagecreatetruecolor($this->width, $this->height);
        $this->generateCaptcha(); // Генерируем капчу
    }

    // Метод для генерации случайного цвета
    private function randColor($red = null, $green = null, $blue = null) {
        // Если цвета переданы, используем их, иначе генерируем случайные значения
        if (is_numeric($red) && is_numeric($green) && is_numeric($blue)) {
            return imagecolorallocate($this->image, $red, $green, $blue);
        } else {
            return imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255));
        }
    }

    // Метод для генерации изображения капчи
    private function generateCaptcha() {
        $white = $this->randColor(255, 255, 255); // Цвет фона (белый)
        // Заполняем фон белым цветом
        imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $white);
        
        $countLine = rand(0, 10); // Случайное количество линий
        $countPixel = rand(200, 1000); // Случайное количество точек
        $lineColor = $this->randColor(); // Цвет линий
        $pixelColor = $this->randColor(); // Цвет точек

        // Генерируем случайные линии
        for ($i = 0; $i < $countLine; $i++) {
            imageline($this->image, 0, rand(0, $this->height), $this->width, rand(0, $this->height), $lineColor);
        }

        // Генерируем случайные точки
        for ($i = 0; $i < $countPixel; $i++) {
            imagesetpixel($this->image, rand(0, $this->width), rand(0, $this->height), $pixelColor);
        }

        // Генерируем текст капчи и сохраняем его в сессии
        $this->text = $this->getRandString(5);
        $_SESSION['captcha'] = $this->text;

        $this->drawText(); // Рисуем текст на изображении
    }

    // Метод для генерации случайной строки заданной длины
    private function getRandString($length) {
        $characters = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9)); // Массив допустимых символов
        $randStr = '';
        for ($i = 0; $i < $length; $i++) {
            $randStr .= $characters[array_rand($characters)]; // Формируем строку из случайных символов
        }
        return $randStr; // Возвращаем случайную строку
    }

    // Метод для рисования текста на изображении
    private function drawText() {
        $fontSize = 24; // Размер шрифта
        // Рисуем каждый символ текста капчи
        for ($i = 0; $i < strlen($this->text); $i++) {
            $x = ($this->width - 20) / strlen($this->text) * $i + 10; // Вычисляем координату X для символа
            $x = rand($x, $x + 4); // Немного смещаем по X для динамики
            $y = $this->height - (($this->height - $fontSize) / 2); // Вычисляем координату Y для символа
            $letterColor = $this->randColor(); // Генерируем случайный цвет для символа
            $angle = rand(-25, 50); // Угол наклона символа
            // Рисуем символ
            imagettftext($this->image, $fontSize, $angle, $x, $y, $letterColor, $this->font, $this->text[$i]);
        }
    }

    // Метод для вывода изображения капчи
    public function output() {
        header('Content-type: image/png'); // Указываем тип контента
        imagepng($this->image); // Выводим изображение в формате PNG
        imagedestroy($this->image); // Освобождаем память
    }
}

// Создаем экземпляр класса CaptchaImage и выводим изображение
$captcha = new CaptchaImage();
$captcha->output();
?>