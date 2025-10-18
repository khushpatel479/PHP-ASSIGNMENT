<?php
session_start();
$txt = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),0,6);
$_SESSION['captcha_text'] = $txt;
$img = imagecreatetruecolor(120,40);
$bg = imagecolorallocate($img, 240,240,240);
$txtcol = imagecolorallocate($img, 20,60,100);
imagefilledrectangle($img,0,0,120,40,$bg);
$font = __DIR__ . '/fonts/arial.ttf'; 
imagettftext($img, 18, 0, 8, 28, $txtcol, $font, $txt);
header('Content-Type: image/png');
imagepng($img);
imagedestroy($img);
session_start();
if($_POST){
  if(strtoupper($_POST['captcha'] ?? '') !== ($_SESSION['captcha_text'] ?? '')) {
    $error = "Invalid captcha";
  } else {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash) VALUES (?,?,?)");
    $stmt->execute([$_POST['name'], $_POST['email'], $hash]);
  }
}
