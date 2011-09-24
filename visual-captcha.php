<?php
    
    require('../imp_scripts/php-captcha.inc.php');
    $aFonts = array('../imp_scripts/COLLEGE.ttf', '../imp_scripts/COLLEGE.ttf', '../imp_scripts/COLLEGE.ttf');
    $oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60);
    $oVisualCaptcha->SetMinFontSize('20');
    $oVisualCaptcha->Create();

?>
