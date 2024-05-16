<?php
$cookie = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : 'root';
$userSettings = json_decode(file_get_contents('settings.json'), true);
$userData = (@json_decode(file_get_contents($cookie . '_session.json'), true) != null) ? json_decode(file_get_contents($cookie . '_session.json'), true) : $userSettings['defaults'];
$enterBicolor = $userData['back_color'].dechex($userData['opacity']);
echo $userData['radius']."\r\n".
$userData['box_shadow']."\r\n".
$userData['gradient_deg']."\r\n".
$userData['back_size']."\r\n".
$userData['fore_size']."\r\n".
$userData['input_size']."\r\n".
$userData['head1_size']."\r\n".
$userData['head2_size']."\r\n".
$userData['head3_size']."\r\n".
$userData['disp_size']."\r\n".
$userData['priv1_size']."\r\n".
$userData['priv2_size']."\r\n".
$userData['priv3_size']."\r\n".
$userData['back_color']."\r\n".
$userData['fore_color']."\r\n".
$userData['input_color']."\r\n".
$userData['back_text_color']."\r\n".
$userData['fore_text_color']."\r\n".
$userData['input_text_color']."\r\n".
$userData['blank_color']."\r\n".
$userData['blank_text_color']."\r\n".
$userData['arc_fore_color']."\r\n".
$userData['arc_input_color']."\r\n".
$userData['opacity']."\r\n".
$userData['blur']."\r\n".
$userData['brightness']."\r\n".
$userData['saturation']."\r\n".
$userData['contrast']."\r\n".
$userData['sepia']."\r\n".
$userData['grayscale']."\r\n".
$userData['hue']."\r\n".
$enterBicolor;