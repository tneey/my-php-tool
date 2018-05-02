<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="qc:admins" content="2572777061641501663757013307247" />
    <meta name="mobile-agent" content="format=html5;url=http://m.ecrecruit.com">
    <meta name="applicable-device" content="pc">
    <title>ECrecruit –Email</title>
</head>

<div class="container">

    <div style=" -moz-border-radius:15px;-webkit-border-radius:15px;border-radius: 15px;margin:0 auto;width:450px;height: 200px;background-color: #B0CFDC">
        <div style="padding: 10px 0 0 10px">
            <img src="http://www.ecrecruit.com/en/images/logo.png" width="35%" height="30%">
        </div>

        <div style="position: absolute; -moz-border-radius:15px;-webkit-border-radius:15px;border-radius: 15px;margin:5px 15px 15px 15px;width:420px;height:100px;background-color: #AACDDD">
            <h3 style="text-align: center; font-family: 微软雅黑;color:#404040"><?php echo $switch_lang[$lang]['Activate failed'];?></h3>
            <div style="margin: 0 auto;width:243px;font-family: 微软雅黑;color:#404040"><span style="font-family: 微软雅黑;color:#404040"><?php echo $switch_lang[$lang]['page_jump'];?></span><span id="totalSecond">5</span><span style="font-family: 微软雅黑;color:#404040"><?php echo $switch_lang[$lang]['jump_in_sec'];?></span>    <a  href="http://gewf.org/recruit/en/home/home.php"><?php echo $switch_lang[$lang]['click_on_jump'];?></a></div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
    var second = document.getElementById('totalSecond').textContent;
    if (navigator.appName.indexOf("Explorer") > -1)
    {
        second = document.getElementById('totalSecond').innerText;
    } else
    {
        second = document.getElementById('totalSecond').textContent;
    }
    setInterval("redirect()", 1000);
    function redirect()
    {
        if (second < 0)
        {
            <!--定义倒计时后跳转页面-->
            location.href = 'http://www.ecrecruit.com';
        } else
        {
            if (navigator.appName.indexOf("Explorer") > -1)
            {
                document.getElementById('totalSecond').innerText = second--;
            } else
            {
                document.getElementById('totalSecond').textContent = second--;
            }
        }
    }
</script>
</html>