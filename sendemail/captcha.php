<?php getCode(4,100,30);
function getCode($num,$w,$h) {
    /**
     * 去掉了数字0和1 字母小写O和L
     * 避免用户输入时模糊混淆
     */
    $str = "23456789abcdefghijkmnpqrstuvwxyz";
    $code = '';
    for ($i = 0; $i < $num; $i++) {
        $code .= $str[mt_rand(0, strlen($str)-1)];
    }

    $im = imagecreate($w, $h);
    $black = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
    $black2 = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
    $black3 = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
    $black4 = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
    $gray = imagecolorallocate($im, 118, 151, 199);
    $bgcolor = imagecolorallocate($im, 235, 236, 237);
    /*创建图片背景*/
    imagefilledrectangle($im, 0, 0, $w, $h, $bgcolor);
    /*创建图片边框*/
    imagerectangle($im, 0, 0, $w-1, $h-1, $gray);
    /*在画布上随机生成大量点*/
    for ($i = 0; $i < 80; $i++) {
        imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
    }
    imageline($im,rand(0, 50), rand(0, 20), rand(50, 100), rand(0, 20),$black);  //划线
    imageline($im,rand(0, 50), rand(0, 20), rand(50, 100), rand(0, 20),$black);  //划线
    for ($i = 0; $i < 80; $i++) {
        imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
    }    for ($i = 0; $i < 80; $i++) {
        imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
    }  for ($i = 0; $i < 80; $i++) {
        imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
    }
    /**
     * 将字符随机显示在画布上
     * 字符的水平间距和位置随机生成
     */
    $strx = rand(3, 8);
    for ($i = 0; $i < $num; $i++) {
        $strpos = rand(1, 9);
      imagestring($im, 5, $strx, $strpos, substr($code, $i, 1), $black.$i);
        $strx += rand(10, 30);
    }


    /*输出图片*/
    imagepng($im);
    session_start();
   $_SESSION['turing'] = $code; //.md5(date('Y-m-d H:m:s'))
    $_SESSION['MemberType'] = MEMBER_TYPE_JOBSEEKER;
    imagedestroy($im);
}
 ?>

