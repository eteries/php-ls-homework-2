<?php

/*
Задание #1
Функция должна принимать массив строк и выводить каждую строку в отдельном параграфе (тег <p>)
Если в функцию передан второй параметр true, то возвращать (через return) результат в виде одной объединенной строки.
*/

function task1(array $strings, bool $to_return = false)
{
    $res = '';

    foreach ($strings as $string) {
        $string = "<p>$string</p>";
        echo $string;
        $res .= $string;
    }

    if ($to_return === true) {
        return $res;
    }
}
/*
Задание #2
Функция должна принимать 2 параметра:
массив чисел; строку, обозначающую арифметическое действие,  которое нужно выполнить со всеми элементами массива.
Функция должна вывести результат на экран.
Функция должна обрабатывать любой ввод, в том числе некорректный и выдавать сообщения об этом
*/

function task2(array $numbers, string $operator)
{
    if (!is_array($numbers) || empty($numbers)) {
        echo 'Первым аргументом должен быть непустой массив';
        return;
    }

    if (!is_string($operator) || empty($operator)) {
        echo 'Вторым аргументом должна быть непустая строка';
        return;
    }

    if (array_is_numeric($numbers) === false) {
        echo 'Поддерживаются только численные операнды';
        return;
    }

    if (array_has_zero($numbers) === true && $operator === '/') {
        echo 'Делить на 0 нельзя';
        return;
    }

    echo array_calc($numbers, $operator);
}

function array_calc($numbers, $operator)
{
    switch ($operator) {
        case '+':
            $res = array_sum($numbers);
            break;
        case '-':
            $res = array_reduce($numbers, function ($res, $item) {
                if ($res === null) {
                    return $item;
                }
                return $res - $item;
            });
            break;
        case '*':
            $res = array_reduce($numbers, function ($res, $item) {
                if ($res === null) {
                    return $item;
                }
                return $res * $item;
            });
            break;
        case '/':
            $res = array_reduce($numbers, function ($res, $item) {
                if ($res === null) {
                    return $item;
                }
                return $res / $item;
            });
            break;
        default:
            $res = 'Поддерживаются операторы +, -, *, /';
    }
    return $res;
}

function array_is_numeric(array $arr) : bool
{
    $res = true;
    foreach ($arr as $value) {
        if (!is_numeric($value)) {
            $res = false;
            break;
        }
    }
    return $res;
}

function array_has_zero(array $arr) : bool
{
    $res = false;
    foreach ($arr as $index => $value) {
        if ($index > 0 && $value === 0) {
            $res = true;
        }
    }
    return $res;
}

/*Задание #3

Функция должна принимать переменное число аргументов.
Первым аргументом обязательно должна быть строка, обозначающая арифметическое действие,
которое необходимо выполнить со всеми передаваемыми аргументами.
Остальные аргументы это целые и/или вещественные числа.
Пример вызова: calcEverything(‘+’, 1, 2, 3, 5.2);
Результат: 1 + 2 + 3 + 5.2 = 11.2*/

function task3()
{
    $args_num = func_num_args();
    $operator = func_get_arg(0);

    if ($args_num < 3) {
        echo 'Недостаточное количество аргументов';
        return;
    }

    if (!is_string($operator) || empty($operator)) {
        echo 'Первым аргументом должна быть непустая строка';
        return;
    }

    $numbers = [];
    for ($i = 1; $i < $args_num; $i++) {
        $numbers[] = func_get_arg($i);
    }

    if (array_is_numeric($numbers) === false) {
        echo 'Поддерживаются только численные операнды';
        return;
    }

    if (array_has_zero($numbers) === true && $operator === '/') {
        echo 'Делить на 0 нельзя';
        return;
    }

    echo array_calc($numbers, $operator);
}

/*
 * Задание #4

Функция должна принимать два параметра – целые числа.
Если в функцию передали 2 целых числа, то функция должна отобразить таблицу умножения
 размером со значения параметров, переданных в функцию.
(Например если передано 8 и 8, то нарисовать от 1х1 до 8х8).
 Таблица должна быть выполнена с использованием тега <table>
 В остальных случаях выдавать корректную ошибку.
*/

function task4($x, $y)
{
    if (!is_integer($x) || !is_integer($y)) {
        echo 'Ожидаются два целых числа';
        return;
    }

    echo '<table border="1" cellpadding="4" style="border-collapse: collapse; text-align: center">';

    for ($i  = 1; $i <= $x; $i++) {
        echo '<tr>';
        for ($j = 1; $j <= $y; $j++) {
            echo '<td>';
            echo $i * $j;
            echo '</td>';
        }
        echo '</tr>';
    }

    echo '</table>';
}


/*Задание #5
Написать две функции.
Функция №1 принимает 1 строковый параметр и возвращает true, если строка является палиндромом*,
false в противном случае. Пробелы и регистр не должны учитываться.
Функция №2 выводит сообщение в котором на русском языке оговаривается результат из функции №1
*/

function task5_1(string $str) : bool
{
    if (!is_string($str) || empty($str)) {
        return false;
    }

    $str_prepared = str_replace(' ', '', $str);
    $str_prepared = mb_strtolower($str_prepared);

    $left_ind = 0;
    $right_ind = mb_strlen($str_prepared) - 1;

    while ($left_ind < $right_ind) {
        $left_char = mb_substr($str_prepared, $left_ind, 1);
        $right_char = mb_substr($str_prepared, $right_ind, 1);

        if ($left_char !== $right_char) {
            return false;
        }

        $left_ind++;
        $right_ind--;
    }
    return true;
}

function task5_2(string $str)
{
    if (task5_1($str)) {
        echo "&laquo;$str&raquo; - палиндром";
    } else {
        echo 'Это не палиндром';
    }
}

/*
 * Задание #6 (выполняется после вебинара “ВСТРОЕННЫЕ ВОЗМОЖНОСТИ ЯЗЫКА”)
Выведите информацию о текущей дате в формате 31.12.2016 23:59
Выведите unixtime время соответствующее 24.02.2016 00:00:00.
 */

function task6()
{
    echo date('d.m.Y H:i');
    echo '<br>';
    echo strtotime('24.02.2016 00:00:00');
}


/*
 * Задание #7 (выполняется после вебинара “ВСТРОЕННЫЕ ВОЗМОЖНОСТИ ЯЗЫКА”)
Дана строка: “Карл у Клары украл Кораллы”. удалить из этой строки все заглавные буквы “К”.
Дана строка “Две бутылки лимонада”. Заменить “Две”, на “Три”. По желанию дополнить задание.
 */

function task7()
{
    $str1 = 'Карл у Клары украл Кораллы';
    $str1 = str_replace('К', '', $str1);
    echo $str1;

    echo '<br>';

    $str2 = 'Две бутылки лимонада';
    $str2 = str_replace(['Две', 'лимонада'], ['Три', 'пива'], $str2);
    echo $str2;
}

/*Задание #8 (выполняется после вебинара “ВСТРОЕННЫЕ ВОЗМОЖНОСТИ ЯЗЫКА”)
Напишите функцию, которая с помощью регулярных выражений,
получит информацию о переданных RX пакетах из переданной строки:
Пример строки: “RX packets:950381 errors:0 dropped:0 overruns:0 frame:0. “
Если кол-во пакетов более 1000, то выдавать сообщение: “Сеть есть”
Если в переданной в функцию строке есть “:)”, то нарисовать смайл в ASCII и не выдавать сообщение из пункта №3.
Смайл должен храниться в отдельной функции
*/

function task8()
{
    $str = 'RX packets:950381 errors:0 dropped:0 overruns:0 frame:0.';
    $regex_smile = '|:\)|';
    $regex_digits = '|RX packets:(\d+)\s|';

    $smile = preg_match($regex_smile, $str);

    if ($smile) {
        asciiSmile();
        return;
    }

    preg_match($regex_digits, $str, $match);
    $numbers = $match[1];
    if ($numbers > 1000) {
        echo 'Сеть есть';
    }
}

/*
Задание #9 (выполняется после вебинара “ВСТРОЕННЫЕ ВОЗМОЖНОСТИ ЯЗЫКА”)

Создайте средствами ОС файл test.txt и поместите в него текст “Hello, world”
Напишите функцию, которая будет принимать имя файла, открывать файл и выводить содержимое на экран.
*/

function task9(string $filename)
{
    $handle = fopen($filename, "r");
    echo fread($handle, filesize($filename));
}

/*
Задание #10 (выполняется после вебинара “ВСТРОЕННЫЕ ВОЗМОЖНОСТИ ЯЗЫКА”)

Создайте файл anothertest.txt средствами PHP. Поместите в него текст - “Hello again!”
*/

function task10(string $filename, string $file_content)
{
    $handle = fopen($filename, "w");
    fwrite($handle, $file_content);
    echo 'Файл записан ' . date('d.m.Y в H:i');
}

function asciiSmile()
{
    echo <<<EOT
    <pre>
                        oooo$$$$$$$$$$$$oooo
                      oo$$$$$$$$$$$$$$$$$$$$$$$$o
                   oo$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$o         o$   $$ o$
   o $ oo        o$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$o       $$ $$ $$o$
oo $ $ "$      o$$$$$$$$$    $$$$$$$$$$$$$    $$$$$$$$$o       $$$o$$o$
"$$$$$$o$     o$$$$$$$$$      $$$$$$$$$$$      $$$$$$$$$$o    $$$$$$$$
  $$$$$$$    $$$$$$$$$$$      $$$$$$$$$$$      $$$$$$$$$$$$$$$$$$$$$$$
  $$$$$$$$$$$$$$$$$$$$$$$    $$$$$$$$$$$$$    $$$$$$$$$$$$$$  """$$$
   "$$$""""$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     "$$$
    $$$   o$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     "$$$o
   o$$"   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$       $$$o
   $$$    $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$" "$$$$$$ooooo$$$$o
  o$$$oooo$$$$$  $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$   o$$$$$$$$$$$$$$$$$
  $$$$$$$$"$$$$   $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$     $$$$""""""""
 """"       $$$$    "$$$$$$$$$$$$$$$$$$$$$$$$$$$$"      o$$$
            "$$$o     """$$$$$$$$$$$$$$$$$$"$$"         $$$
              $$$o          "$$""$$$$$$""""           o$$$
               $$$$o                                o$$$"
                "$$$$o      o$$$$$$o"$$$$o        o$$$$
                  "$$$$$oo     ""$$$$o$$$$$o   o$$$$""
                     ""$$$$$oooo  "$$$o$$$$$$$$$"""
                        ""$$$$$$$oo $$$$$$$$$$
                                """"$$$$$$$$$$$
                                    $$$$$$$$$$$$
                                     $$$$$$$$$$"
                                      "$$$"" 
</pre>
EOT;
}

