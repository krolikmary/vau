<?php
require_once '../Session.php';
session_start();
$info = Session::getSessionData('info');

function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $type = clean_input($_POST['type']); // Тип путевки
    $food_option = clean_input($_POST['food_option']); // Вид питания

    Session::setSessionData('name', $name);
    Session::setSessionData('email', $email);
    Session::setSessionData('phone', $phone);
    Session::setSessionData('type', $type);
    Session::setSessionData('food_option', $food_option);

    header("Location: bill.php");
}
$name = Session::getSessionData('name') !== null ? Session::getSessionData('name') : '';
$email = Session::getSessionData('email') !== null ? Session::getSessionData('email') : '';
$phone = Session::getSessionData('phone') !== null ? Session::getSessionData('phone') : '';
$type = Session::getSessionData('type') !== null ? Session::getSessionData('type') : '';
$food_option = Session::getSessionData('food_option') !== null ? Session::getSessionData('food_option') : '';
?>
<?php
if ($_COOKIE['loggedin'] !== "" && $_COOKIE['user'] == 'admin') {
?>
<html>
<head>
    <title>Работа</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body topmargin="0" bottommargin="0" rightmargin="0" leftmargin="0" background="../images/back_main.gif">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const submitButton = document.querySelector('input[type="submit"][name="submit"]');
        toggleButtonState();

        document.querySelector('input[name="name"]').addEventListener('input', toggleButtonState);
        document.querySelector('input[name="email"]').addEventListener('input', toggleButtonState);
        document.querySelector('input[name="phone"]').addEventListener('input', toggleButtonState);

        function toggleButtonState() {
            const nameInput = document.querySelector('input[name="name"]').value.trim();
            const emailInput = document.querySelector('input[name="email"]').value.trim();
            const phoneInput = document.querySelector('input[name="phone"]').value.trim();
            submitButton.disabled = !(nameInput && emailInput && phoneInput);
        }
    });
</script>
<form method="POST" action="">
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="583" height="614">
        <tr>
            <td valign="top" width="583" height="208" background="../images/row1.gif">
                <div style="margin-left:88px; margin-top:57px "><img src="../images/w1.gif"></div>
                <div style="margin-left:50px; margin-top:69px ">
                    <a href="../index.php">Главная<img src="../images/m1.gif" border="0"></a>
                    <img src="../images/spacer.gif" width="20" height="10">
                    <a href="order.php">Заказ<img src="../images/m2.gif" border="0"></a>
                    <img src="../images/spacer.gif" width="5" height="10">
                    <a href="basket.php">Корзина<img src="../images/m3.gif" border="0"></a>
                    <img src="../images/spacer.gif" width="5" height="10">
                    <a href="index-3.php">О компании<img src="../images/m4.gif" border="0"></a>
                    <img src="../images/spacer.gif" width="5" height="10">
                    <a href="index-4.php">Контакты<img src="../images/m5.gif" border="0"></a>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" width="583" height="338" bgcolor="#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td valign="top" height="338" width="42"></td>
                        <td valign="top" height="338" width="492">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <div style="margin-left:60px "><font class="title">Туристическая путевка</font><br>
                                </tr>
                                <tr>
                                    <td width="492" valign="top" height="232">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td valign="top" height="232" width="248">
                                                    <div style="margin-left:6px; margin-top:2px; "><img
                                                                src="../images/hl.gif"></div>
                                                    <div style="margin-left:6px; margin-top:7px; "><img
                                                                src="../images/1_w2.gif"></div>


                                                    <div class="types_list">
                                                        <p>Тип путевки</p>
                                                        <select name="type">
                                                            <?php foreach ($info['types'] as $key => $value): ?>
                                                                <option value="<?php echo $key; ?>" <?php if (isset($type) && $type == $key) echo "selected"; ?>><?php echo $value['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="food_selection" style="margin-top: 55px;">
                                                        <p>Выбор питания</p>
                                                        <?php $first = true; ?>
                                                        <?php foreach ($info['food_options'] as $key => $option): ?>
                                                            <p>
                                                                <input name="food_option" type="radio"
                                                                       value="<?php echo $key; ?>" <?php if ($first) {
                                                                    echo "checked";
                                                                    $first = false;
                                                                } ?>>
                                                                <?php echo htmlspecialchars($option['name']) . " (+" . htmlspecialchars($option['cost']) . " руб., время: " . htmlspecialchars($option['time']) . ")"; ?>
                                                            </p>
                                                        <?php endforeach; ?>
                                                    </div>

                                                </td>

                                                <td valign="top" height="338" width="1" background="../images/tal.gif"
                                                    style="background-repeat:repeat-y"></td>
                                                <td valign="top" height="232" width="243">
                                                    <div class="contact_data" style="margin-left: 6px">
                                                        <p style="margin-top: 30px;">Контактные данные</p>
                                                        <label for="login">Имя</label> <br>
                                                        <input type="text" name="name"
                                                               style="width: 150px; margin-bottom: 10px"
                                                               value="<?php echo htmlspecialchars($name); ?>"><br>
                                                        <label for="login">E-mail</label> <br>
                                                        <input type="text" name="email"
                                                               style="width: 150px; margin-bottom: 10px"
                                                               value="<?php echo htmlspecialchars($email); ?>"><br>
                                                        <label for="login">Телефон</label> <br>
                                                        <input type="text" name="phone"
                                                               style="width: 150px; margin-bottom: 10px"
                                                               value="<?php echo htmlspecialchars($phone); ?>"><br>

                                                        <div class="next_button">
                                                            <input type="submit" name="submit" value="Далее">
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
            <td valign="top" width="583" height="68" background="../images/row3.gif">
                <div style="margin-left:51px; margin-top:31px ">
                    <a href="#"><img src="../images/p1.gif" border="0"></a>
                    <img src="../images/spacer.gif" width="26" height="9">
                    <a href="#"><img src="../images/p2.gif" border="0"></a>
                    <img src="../images/spacer.gif" width="30" height="9">
                    <a href="#"><img src="../images/p3.gif" border="0"></a>
                    <img src="../images/spacer.gif" width="149" height="9">
                    <a href="index-5.php"><img src="../images/copyright.gif" border="0"></a>
                </div>
            </td>
        </tr>

    </table>
</form>
<?php
} else {
    header("Location: ../index.php");
}
?>
</body>
</html>
