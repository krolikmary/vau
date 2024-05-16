<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

require_once '../Session.php';
require_once '../FileWriter.php';

session_start();

function findPrice($info, $keyToSearch) {
    if ($keyToSearch === 'Сауна' || $keyToSearch === 'Бассейн' || $keyToSearch === 'Бар') {
        $subArray = 'entertainments_cruise';
    } elseif ($keyToSearch === 'Кормление животных' || $keyToSearch === 'Фотоохота' || $keyToSearch === 'Разделывание животных') {
        $subArray = 'excursions_safari';
    } elseif ($keyToSearch === 'Местный рынок' || $keyToSearch === 'Приготовление еды' || $keyToSearch === 'Виноферма') {
        $subArray = "local_places_gastronomic_tour";
    }

    if (isset($info[$subArray][$keyToSearch])) {
        return $info[$subArray][$keyToSearch];
    }
    return 0;
}

$info = Session::getSessionData('info');
$name = Session::getSessionData('name') !== null ? Session::getSessionData('name') : '';
$email = Session::getSessionData('email') !== null ? Session::getSessionData('email') : '';
$phone = Session::getSessionData('phone') !== null ? Session::getSessionData('phone') : '';
$type = Session::getSessionData('type') !== null ? Session::getSessionData('type') : '';
$food_option = Session::getSessionData('food_option') !== null ? Session::getSessionData('food_option') : '';
$entertainments = Session::getSessionData('entertainments') !== null ? Session::getSessionData('entertainments') : [];
$excursions = Session::getSessionData('excursions') !== null ? Session::getSessionData('excursions') : [];
$gastronomic_tour_options = Session::getSessionData('gastronomic_tour_options') !== null ? Session::getSessionData('gastronomic_tour_options') : [];
$country = Session::getSessionData('country') !== null ? Session::getSessionData('country') : '';
$days = Session::getSessionData('days') !== null ? Session::getSessionData('days') : '1';
$sum = $info['countries_' . $type][$country] + $info['types'][$type]['price'] + $info['food_options'][$food_option]['cost'];

$additionalServices = "";
foreach ($entertainments as $entertainment) {
    $price = findPrice($info, $entertainment);
    $additionalServices .= $entertainment . " = " . $price . " руб.\n";
    $sum += $price;
}

foreach ($excursions as $excursion) {
    $price = findPrice($info, $excursion);
    $sum += $price;
    $additionalServices .= $excursion . " = " . $price . " руб.\n";
}

foreach ($gastronomic_tour_options as $option) {
    $price = findPrice($info, $option);
    $sum += $price;
    $additionalServices .= $option . " = " . $price . " руб.\n";
}


$mailSendler = new PHPMailer(true);;
$fileWriter = new FileWriter();

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

                                                <div style="margin-top:6px; margin-left:6px ">
                                                    <table border="1px solid #7C994A" cellpadding="0" cellspacing="0"
                                                           border="0" align="center">
                                                        <tr>
                                                            <td>
                                                                <div>Имя</div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div><?php echo $name; ?></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>Телефон</div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div><?php echo $phone; ?></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>E-mail</div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div><?php echo $email; ?></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>Тип путевки</div>
                                                            </td>
                                                            <td style="font-family: Tahoma; font-size: 10px; color: #7E7E76;">
                                                                <?php
                                                                echo "{$info['types'][$type]['name']}(страна {$country}, +{$info['countries_' . $type][$country]} руб. )";
                                                                ?>
                                                            </td>
                                                            <td style="font-family: Tahoma; font-size: 10px; color: #7E7E76;">
                                                                <?php
                                                                echo $info['types'][$type]['price'] . ' руб';
                                                                ?>
                                                            </td>
                                                            <td style="font-family: Tahoma; font-size: 10px; color: #7E7E76;">
                                                                <?php
                                                                echo $info['types'][$type]['description'];
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div>Вид питания</div>
                                                            </td>
                                                            <td>
                                                                <div><?php echo (isset($food_option) && $food_option !== '') ? $info['food_options'][$food_option]['name'] : 'не выбрано'; ?></div>
                                                            </td>
                                                            <td >
                                                                <div><?php echo (isset($food_option) && $food_option !== '') ? $info['food_options'][$food_option]['cost'] . ' руб' : 'не выбрано'; ?></div>
                                                            </td>
                                                            <td >
                                                                <div><?php echo (isset($food_option) && $food_option !== '') ? $info['food_options'][$food_option]['time']  : 'не выбрано'; ?></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <div>Дополнительные опции</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div style="display: <?php echo $type === 'safari' ? 'block' : 'none'; ?>;">Экскурсии</div>
                                                                <div style="display: <?php echo $type === 'cruise' ? 'block' : 'none'; ?>;">Развлечения</div>
                                                                <div style="display: <?php echo $type === 'gastronomic_tour' ? 'block' : 'none'; ?>;">Места</div>
                                                            </td>
                                                            <td class="options_area" colspan="3">
                                                                <?php if (!empty($excursions) && $type === 'safari'): ?>
                                                                    <ul style="font-family: Tahoma; font-size: 10px; color: #7E7E76;">
                                                                        <?php foreach ($excursions as $excursion): ?>
                                                                            <?php
                                                                            $price = findPrice($info, $excursion);
                                                                            ?>
                                                                            <li><?php echo htmlspecialchars($excursion) . " - " . $price . " руб."; ?></li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                <?php endif; ?>
                                                                <?php if (!empty($entertainments) && $type === 'cruise'): ?>
                                                                    <ul style="font-family: Tahoma; font-size: 10px; color: #7E7E76;">
                                                                        <?php foreach ($entertainments as $entertainment): ?>
                                                                            <?php
                                                                            $price = findPrice($info, $entertainment);
                                                                            ?>
                                                                            <li><?php echo htmlspecialchars($entertainment) . " - " . $price . " руб."; ?></li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                <?php endif; ?>
                                                                <?php if (!empty($gastronomic_tour_options) && $type === 'gastronomic_tour'): ?>
                                                                    <ul style="font-family: Tahoma; font-size: 10px; color: #7E7E76;">
                                                                        <?php foreach ($gastronomic_tour_options as $gastronomic_tour_option): ?>
                                                                            <?php
                                                                            $price = findPrice($info, $gastronomic_tour_option);
                                                                            ?>
                                                                            <li><?php echo htmlspecialchars($gastronomic_tour_option) . " - " . $price . " руб."; ?></li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <div>Количество дней</div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div><?php echo $days; ?></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div style="margin-top: 10px;">
                                                    <?php
                                                    if ($type == 'cruise') {
                                                        echo '<img src="../images/cruise.jpg" alt="Cruise Image" style="width: 150px; height: 150px; margin-left: 6px;>';
                                                    } elseif ($type == 'safari') {
                                                        echo '<img src="../images/safari.jpeg" alt="Safari Image" style="width: 150px; height: 150px; margin-left: 6px;>';
                                                    } elseif ($type == 'gastronomic_tour') {
                                                        echo '<img src="../images/gastro_tur.jpg" alt="Safari Image" style="width: 150px; height: 150px; margin-left: 6px;>';
                                                    }
                                                    ?>
                                                </div>


                                            </td>

                                            <td valign="top" height="338" width="1" background="../images/tal.gif"
                                                style="background-repeat:repeat-y"></td>
                                            <td valign="top" height="232" width="243">
                                                <div style="margin-left: 6px; margin-top: 25px;">
                                                    <p>Итоговая сумма: <?php
                                                        echo $sum;
                                                        ?> руб.</p>

                                                </div>
                                                <div style="margin-left:10px; margin-top:50px; margin-right:10px ">
                                                    <form method="POST">
                                                        <input type="submit" name="mail"
                                                               value="Отправить на почту и записать в файл"/>
                                                        <br><br>
                                                        <input type="submit" name="write" value="Записать в файл"/>
                                                    </form>
                                                    <?php
                                                    $typeOfService = "{$info['types'][$type]['name']}(страна {$country}, +{$info['countries_' . $type][$country]} руб. ) - {$info['types'][$type]['price']} руб. - {$info['types'][$type]['description']}";
                                                    $typeOfFood = (isset($food_option) && $food_option !== '') ? "{$info['food_options'][$food_option]['name']} - {$info['food_options'][$food_option]['cost']} руб - {$info['food_options'][$food_option]['time']}" : '';

                                                    $text = $text = "Дата и время: " . date("d.m.y H:i") . "\nИмя: " . $name . "\nПочта: " . $email . "\nТип путевки: " . $typeOfService . "\nВид питания: " . $typeOfFood . "\nДополнительные услуги:\n" . (!empty($additionalServices) ? $additionalServices : 'нет') . "\nИтоговая сумма: " . $sum;
                                                    $mailText = "Дата и время: " . date("d.m.y H:i") . "<br>Имя: " . $name . "<br>Почта: " . $email . "<br>Тип путевки: " . $typeOfService . "<br>Вид питания: " . $typeOfFood . "<br>Дополнительные услуги: " . (!empty($additionalServices) ? $additionalServices : 'нет') . "<br>Итоговая сумма: " . $sum;
                                                    if (isset($_REQUEST['mail'])) {

                                                        try {
                                                            $mailSendler->isSMTP();
                                                            $mailSendler->Host = 'ssl://smtp.yandex.ru';
                                                            $mailSendler->SMTPAuth = true;
                                                            $mailSendler->Username = 'mashzuk@gmail.com';
                                                            $mailSendler->Password = '124578124578124578Aaa';
                                                            $mailSendler->SMTPSecure = 'ssl';
                                                            $mailSendler->Port = 465;
                                                            $mailSendler->CharSet = 'UTF-8';

                                                            $mailSendler->setFrom('mashzuk@gmail.com', 'Masha');
                                                            $mailSendler->addAddress($email, $name);

                                                            $mailSendler->isHTML(true);
                                                            $mailSendler->Subject = 'Voucher';
                                                            $mailSendler->Body = $mailText;
                                                            $file_path = "./" . "$name" . '_' . date("d.m.y") . ".txt";
                                                            $fileWriter->writeFile($file_path, $text);
                                                            $mailSendler->addAttachment($file_path);
                                                            if ($type == 'cruise') {
                                                                $mailSendler->addAttachment('../images/cruise.jpg');
                                                            } elseif ($type == 'safari') {
                                                                $mailSendler->addAttachment('../images/safari.jpeg');
                                                            } elseif ($type == 'gastronomic_tour') {
                                                                $mailSendler->addAttachment('../images/gastro_tur.jpg');
                                                            }
                                                            $mailSendler->send();

                                                            echo 'Письмо успешно отправлено';
                                                        } catch (Exception $e) {
                                                            echo 'Ошибка при отправке письма: ' . $mailSendler->ErrorInfo;
                                                        }
                                                    } elseif (isset($_REQUEST['write'])) {
                                                        if ($fileWriter->writeFile("$name" . '_' . date("d.m.y") . ".txt", $text)) {
                                                            echo "Записано в файл " . "$name" . '_' . date("d.m.y") . ".txt";
                                                        } else {
                                                            echo "Ошибка записи в файл!";
                                                        }
                                                    }
                                                    ?>
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
<?php
} else {
    header("Location: ../index.php");
}
?>
</body>
</html>

