<?php

defined('DEBUG')
    || define('DEBUG', false);

if (array_key_exists('hash', $_POST) && !empty($_POST['hash'])) {
    $startShift = new DateTime($_POST['startShift']);
    $startBreak = new DateTime($_POST['startBreak']);
    $endBreak   = new DateTime($_POST['endBreak']);
    $endShift   = new DateTime($_POST['endShift']);

    $amInterval    = $startShift->diff($startBreak);
    $pmInterval    = $endBreak->diff($endShift);

    $sumMin  = $amInterval->i + $pmInterval->i;
    $sumHour = 0;

    if ($sumMin > 59) {
        $sumHour = floor($sumMin / 60);
        $sumMin  = $sumMin % 60;
    }

    $sumHour += $amInterval->h + $pmInterval->h;

    $breakInterval = $startBreak->diff($endBreak);
}

?>
<!doctype html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/css/app.css">
        <title>Wie lang?</title>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>:black_circle:️</text></svg>">
        <script src="/js/form.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Form.init();
            });
        </script>
    </head>
    <body>
        <?php if (isset($amInterval) && isset($pmInterval)): ?>
        <table>
            <tr>
                <td>Stunden (vm):</td>
                <td><?= sprintf('%02d:%02d', $amInterval->h, $amInterval->i) ?></td>
            </tr>
            <tr>
                <td>Stunden (nm):</td>
                <td><?= sprintf('%02d:%02d', $pmInterval->h, $pmInterval->i) ?></td>
            </tr>
            <tr><td colspan="2"></td></tr>
            <tr>
                <th class="ta-right">Summe:</th>
                <td><?= sprintf('%02d:%02d', $sumHour, $sumMin) ?></td>
            </tr>
            <tr>
                <th class="ta-right">Pause:</th>
                <td><?= sprintf('%02d:%02d', $breakInterval->h, $breakInterval->i) ?></td>
            </tr>
        </table>
        <?php endif ?>
        <form id="main-form" method="post" action="">
            <fieldset id="shift" class="js-shift">
                <div class="input-group">
                    <label for="start-shift">Login:</label>
                    <input type="time" id="start-shift" name="startShift"
                        value="<?= (!empty($_POST['startShift'])) ? $_POST['startShift'] : '' ?>">
                </div>
                <div class="input-group">
                    <label for="start-break">Pause Start:</label>
                    <input type="time" id="start-break" name="startBreak"
                        value="<?= (!empty($_POST['startBreak'])) ? $_POST['startBreak'] : '' ?>">
                </div>
                <div class="input-group">
                    <label for="end-break">Pause Ende:</label>
                    <input type="time" id="end-break" name="endBreak"
                        value="<?= (!empty($_POST['endBreak'])) ? $_POST['endBreak'] : '' ?>">
                </div>
                <div class="input-group">
                    <label for="end-shift">Feierabend:</label>
                    <input type="time" id="end-shift" name="endShift"
                        value="<?= (!empty($_POST['endShift'])) ? $_POST['endShift'] : '' ?>">
                </div>
            </fieldset>

            <input type="hidden" id="break-count" name="break-count" value="1">
            <input type="hidden" id="hash" name="hash" value="<?= md5(time()) ?>">

            <fieldset id="formCtrl" class="formCtrl">
                <button type="submit" class="js-submitBtn">Submit</button>
                <button type="button" class="js-cancelBtn">Cancel</button>
            </fieldset>
        </form>
        <?php if (DEBUG && ! empty($_POST)):?>
        <pre class="debug"><?php
            print_r($_POST);
        ?></pre>
        <?php endif; ?>
    </body>
</html>