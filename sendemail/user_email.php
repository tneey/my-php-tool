<?php require('class.phpmailer.php');
      require('class.smtp.php');
date_default_timezone_set("Asia/Hong_Kong"); //时间设置为香港

function sendemail($sendto,$title,$body)
{

    $mail = new PHPMailer(); //new一个PHPMailer对象出来
    // $body = preg_replace("[\]", '', $body); //对邮件内容进行必要的过滤
    $mail->CharSet = "UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug = 1;                     // 启用SMTP调试功能
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth = true;                  // 启用 SMTP 验证功能
    $mail->SMTPSecure = "tls";//"ssl";      // 安全协议,163用ssl,hotmail gmail用tls.
    $mail->Host = "smtp.gmail.com";      // SMTP 服务器
    $mail->Port = 587;//25,465,587;                   // SMTP服务器的端口号
    $mail->Username = "ecrecruitpro";  // SMTP服务器用户名
    $mail->Password = "153624lai";            // SMTP服务器密码
    $mail->SetFrom('ecrecruitpro@gmail.com', 'ecrecruitpro');//发送邮件的邮箱和用户名
    //  $mail->AddReplyTo("myMail@hotmail.com", "Zhixiong");//没啥用
    $mail->Subject = $title;  //邮件题目
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
    $mail->MsgHTML($body);  //邮件内容
    $address = $sendto;     //收件人地址
    $mail->AddAddress($address, "Dear User");
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    if (!$mail->Send()) {
     //   echo "Mailer Error: " . $mail->ErrorInfo; //调用错误提示
        echo "郵件發送失敗！";
    }
}
?>
