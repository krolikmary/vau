<?php
require_once 'Session.php';
session_start();

$info = [
    "types" => [
        "cruise" => ["name" => "Круиз", "price" => 2000, "description" => "На большом теплоходе"],
        "safari" => ["name" => "Сафари", "price" => 3000, "description" => "В жаркой пустыне"],
        "gastronomic_tour" => ["name" => "Гастротур", "price" => 1000, "description" => "Этнические рестораны"],
    ],
    "food_options" => [
        "breakfast" => ["name" => "Завтрак", "cost" => 10, "time" => "с 8-00 до 10-00"],
        "dinner" => ["name" => "Ужин", "cost" => 20, "time" => "с 19-00 до 22-00"],
        "full_pension" => ["name" => "Пансион", "cost" => 50, "time" => "Добавляется обед с 13-00 до 15-00"],
    ],
    "countries_cruise" => [
        "Италия" => 200,
        "Хорватия" => 100,
        "Швеция" => 300,
    ],
    "countries_safari" => [
        "Кения" => 500,
        "Марокко" => 300,
        "ЮАР" => 800,
    ],
    "countries_gastronomic_tour" => [
        "Дания" => 50,
        "Норвегия" => 100,
        "Франция" => 80,
    ],
    "entertainments_cruise" => [
        "Сауна" => 50,
        "Бассейн" => 100,
        "Бар" => 200,
    ],
    "excursions_safari" => [
        "Кормление животных" => 100,
        "Фотоохота" => 50,
        "Разделывание животных" => 200,
    ],
    "local_places_gastronomic_tour" => [
        "Местный рынок" => 50,
        "Приготовление еды" => 200,
        "Виноферма" => 100,
    ],
];

Session::setSessionData('info', $info);

// Сменить пользователя на order.php
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    Session::destroySession();
    setcookie("loggedin", "");
    setcookie("user", "");

    // Перенаправление на главную страницу
    header("Location: index.php");
    exit();
}

// Обработка данных формы авторизации
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    // Простая проверка авторизации
    if ($login == 'admin' && $password == '123') {
        // Установка кук после успешной авторизации
        setcookie("user", $login, time() + 3600, "/");
        setcookie("loggedin", "true", time() + 3600, "/"); // Установим флаг, что пользователь вошел в систему
        // Перенаправление пользователя на другую страницу после авторизации
        header("Location: pages/order.php");
    }
    else {
        setcookie("loggedin", "");
    }
}
?>
<html>
<head>
    <title>Работа</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<body topmargin="0" bottommargin="0" rightmargin="0"  leftmargin="0"   background="images/fon-stena-quot-brick-1-quot.jpg">
<table cellpadding="0" cellspacing="0" border="0"  align="center" width="583" height="614">
    <tr>
        <td valign="top" width="583" height="208" background="images/row1.gif">
            <div style="margin-left:88px; margin-top:57px "><img src="images/w1.gif"></div>
            <div style="margin-left:50px; margin-top:69px ">
                <a href="index.php">Главная<img src="images/m1.gif" border="0" ></a>
                <img src="images/spacer.gif" width="10" height="10">
                <a href="pages/order.php">Заказ<img src="images/m2.gif" border="0" ></a>
                <img src="images/spacer.gif" width="5" height="10">
                <a href="pages/basket.php">Корзина<img src="images/m3.gif" border="0" ></a>
                <img src="images/spacer.gif" width="5" height="10">
                <a href="pages/index-3.php">О компании<img src="images/m4.gif" border="0" ></a>
                <img src="images/spacer.gif" width="5" height="10">
                <a href="pages/index-4.php">Контакты<img src="images/m5.gif" border="0" ></a>

            </div>
        </td>
    </tr>
    <tr>
        <td valign="top" width="583" height="338"  bgcolor="#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td valign="top" height="338" width="42"></td>
                    <td valign="top" height="338" width="492">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td width="492" valign="top" height="106">

                                    <div style="margin-left:1px; margin-top:2px; margin-right:10px "><br>
                                        <div style="margin-left:5px "><img src="./images/1_p1.gif" align="left"></div>
                                        <div style="margin-left:95px "><font class="title">Авторизация</font><br>



                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="492" valign="top" height="232">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td valign="top" height="232" width="248">
                                                <div style="margin-left:6px; margin-top:2px; "><img src="./images/hl.gif"></div>
                                                <div style="margin-left:6px; margin-top:7px; "><img src="./images/1_w2.gif"></div>
                                                <?php
                                                if (!isset($_COOKIE['loggedin']) || !isset($_COOKIE['user']) ) {
                                                ?>
                                                <div class="form-section">
                                                    <p>
                                                    <form name="auth" method="POST" action="">
                                                        <label for="login">Логин</label> <br>
                                                        <input type="text" name="login" id="login" style="width: 200px;"> <br>
                                                        <label for="password">Пароль</label> <br>
                                                        <input type="password" name="password" id="password" style="width: 200px;"> <br>
                                                        <input type="submit" name="submit" value="Войти" style="margin-top: 10px;">
                                                    </form>
                                                    </p>
                                                </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] !== '' &&
                                                    isset($_COOKIE['user']) && $_COOKIE['user'] == 'admin') {
                                                    echo '<input value="Выйти" type="button" style="margin-left:6px; margin-top:2px; " onclick=\'window.location.href="index.php?logout=true";\'>';
                                                }
                                                ?>
                                            </td>


                                            <td valign="top" height="215" width="1" background="./images/tal.gif" style="background-repeat:repeat-y"></td>
                                            <td valign="top" height="215" width="243">
                                                <div style="margin-left:22px; margin-top:2px; "><img src="./images/hl.gif"></div>
                                                <div style="margin-left:22px; margin-top:7px; "><img src="./images/1_w2.gif"></div>
                                                <div style="margin-left:22px; margin-top:13px; ">

                                                    <br><br><br><br>

                                                </div>
                                                <div style="margin-left:22px; margin-top:16px; "><img src="./images/hl.gif"></div>
                                                <div style="margin-left:22px; margin-top:7px; "><img src="./images/1_w4.gif"></div>
                                                <div style="margin-left:22px; margin-top:9px; ">

                                                </div>
                                                </div>




                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top" height="338" width="49"></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td valign="top" width="583" height="68" background="images/row3.gif">
            <div style="margin-left:51px; margin-top:31px ">
                <a href="#"><img src="images/p1.gif" border="0"></a>
                <img src="images/spacer.gif" width="26" height="9">
                <a href="#"><img src="images/p2.gif" border="0"></a>
                <img src="images/spacer.gif" width="30" height="9">
                <a href="#"><img src="images/p3.gif" border="0"></a>
                <img src="images/spacer.gif" width="149" height="9">
                <a href="index-5.html"><img src="images/copyright.gif" border="0"></a>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
