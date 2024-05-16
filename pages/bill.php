<?php
require_once '../Session.php';
session_start();
$info = Session::getSessionData('info');

$days = Session::getSessionData('days') !== null ? Session::getSessionData('days') : 1;
$country = Session::getSessionData('country') !== null ? Session::getSessionData('country') : 'Italy';
$entertainments = Session::getSessionData('entertainments') !== null ? Session::getSessionData('entertainments') : [];
$excursions = Session::getSessionData('excursions') !== null ? Session::getSessionData('excursions') : [];
$gastronomic_tour_options = Session::getSessionData('gastronomic_tour_options') !== null ? Session::getSessionData('gastronomic_tour_options') : [];
$type = Session::getSessionData('type') !== null ? Session::getSessionData('type') : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['entertainment_options'])) {
        $entertainments = $_POST['entertainment_options'];
    }
    if (isset($_POST['excursion_options'])) {
        $excursions = $_POST['excursion_options'];
    }
    if (isset($_POST['gastronomic_tour_options'])) {
        $gastronomic_tour_options = $_POST['gastronomic_tour_options'];
    }
    if (isset($_POST['days'])) {
        $days = $_POST['days'];
    }
    if (isset($_POST['country'])) {
        $country = $_POST['country'];
    }


    Session::setSessionData('country', $country);
    Session::setSessionData('entertainments', $entertainments);
    Session::setSessionData('excursions', $excursions);
    Session::setSessionData('gastronomic_tour_options', $gastronomic_tour_options);
    Session::setSessionData('days', $days);

    header("Location: basket.php");
}
?>
<?php
if ($_COOKIE['loggedin'] !== "" && $_COOKIE['user'] == 'admin') {
?>
<form method="POST" action="">
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


                                                    <div class="types_list">
                                                        <p>Страна основного пребывания</p>

                                                        <?php $countries = $info['countries_' . $type]; ?>
                                                        <?php $first = true; ?>
                                                        <?php foreach ($countries as $countryKey => $countryCost): ?>
                                                            <input type="radio" id="country_<?php echo $countryKey; ?>"
                                                                   name="country" value="<?php echo $countryKey; ?>"
                                                                <?php if ($first) {
                                                                    echo "checked";
                                                                    $first = false;
                                                                } ?>>
                                                            <label for="country_<?php echo $countryKey; ?>"><?php echo $countryKey . ' (+' . $countryCost . ' руб.)'; ?></label> <br>
                                                        <?php endforeach; ?>

                                                    </div>

                                                    <div style="margin-top: 25px;">Дополнительные услуги</div><br>

                                                    <div class="type-section cruise" style="display: <?php echo $type === 'cruise' ? 'block' : 'none'; ?>;">
                                                        <p>Развлечения</p>
                                                        <?php foreach ($info['entertainments_cruise'] as $key => $cost): ?>
                                                            <p>
                                                                <input name="entertainment_options[]" type="checkbox" value="<?php echo $key; ?>"
                                                                    <?php if (in_array($key, $entertainments)) echo "checked"; ?>>
                                                                <label><?php echo htmlspecialchars($key) . " (+" . htmlspecialchars($cost) . " руб.)"; ?></label>
                                                            </p>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="type-section safari" style="display: <?php echo $type === 'safari' ? 'block' : 'none'; ?>;">
                                                        <p>Экскурсии</p>
                                                        <?php foreach ($info['excursions_safari'] as $key => $cost): ?>
                                                            <p>
                                                                <input name="excursion_options[]" type="checkbox" value="<?php echo $key; ?>"
                                                                    <?php if (isset($excursions) && in_array($key, $excursions)) echo "checked"; ?>>
                                                                <label><?php echo htmlspecialchars($key) . " (+" . htmlspecialchars($cost) . " руб.)"; ?></label>
                                                            </p>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="type-section gastronomic_tour" style="display: <?php echo $type === 'gastronomic_tour' ? 'block' : 'none'; ?>;">
                                                        <p>Гастротур</p>
                                                        <?php foreach ($info['local_places_gastronomic_tour'] as $key => $cost): ?>
                                                            <p>
                                                                <input name="gastronomic_tour_options[]" type="checkbox" value="<?php echo $key; ?>"
                                                                    <?php if (isset($gastronomic_tour_options) && in_array($key, $gastronomic_tour_options)) echo "checked"; ?>>
                                                                <label><?php echo htmlspecialchars($key) . " (+" . htmlspecialchars($cost) . " руб.)"; ?></label>
                                                            </p>
                                                        <?php endforeach; ?>
                                                    </div>

                                                </td>

                                                <td valign="top" height="338" width="1" background="../images/tal.gif"
                                                    style="background-repeat:repeat-y"></td>
                                                <td valign="top" height="232" width="243">
                                                    <div style="margin-top: 30px; margin-left: 6px;">
                                                        <p>Количество дней</p>
                                                        <input type="number" name="days" min="1" value="<?php echo htmlspecialchars($days); ?>"><br>
                                                        <div class="submit_button_area" style="margin-top: 10px;">
                                                            <input type="button" onclick="history.back()" value="Назад">
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
    <?php
    } else {
        header("Location: ../index.php");
    }
    ?>
    </body>
    </html>
</form>
