<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>注册 | <?php echo C('SITE_TITLE');?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
  <link rel="stylesheet" href="/Public/css/pnotify.custom.min.css"/>
  <link rel="stylesheet" href="/Public/assets/css/amazeui.min.css"/>

  <script src="/Public/assets/js/jquery.min.js"></script>
  <script src="/Public/assets/js/amazeui.min.js"></script>
  <script src="/Public/js/notify.js"></script>
  <script src="/Public/js/public.js"></script>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body style="background-color: #eee;">
<div class="header">
  <div class="am-g">
    <h1><?php echo C('SITE_TITLE');?></h1>
    <p>专注于提供优质的贴吧云签到服务</p>
  </div>
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <div class="am-form">
      <label for="username">用户名:</label>
      <input type="text" name="" id="username" value="">
      <br>
      <label for="email">邮箱:</label>
      <input type="text" name="" id="email" value="">
      <p>请把<code>cyunqiandao@sina.com</code>加入所填邮箱的白名单。<br/><b>当你的百度账户失效</b>的时候该邮箱会第一时间向你所填的邮箱发送通知邮件，如果<b>收不到可能导致断签</b>。</p>
      <label for="password">密码:</label>
      <input type="password" name="" id="password" value="">
      <br>
      <label for="email">邀请码:</label>
      <input type="text" name="" id="code" value="">
      <p>赞助我：<form accept-charset="GBK" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="POST" target="_blank"><input name="optEmail" type="hidden" value="smilexcc@gmail.com"/><input name="payAmount" type="hidden" value="10"/><input id="title" name="title" type="hidden" value="赞助璨-C云签"/><input name="memo" type="hidden" value="大爷赏你一杯咖啡.."/><input name="pay" src="https://img.alipay.com/sys/personalprod/style/mc/btn-index.png" type="image" value="转账"/></form></p>
      <br />
      <div class="am-cf">
        <input type="button" onclick="loading_notify();register('<?php echo $from;?>');" name="" value="注 册" class="am-btn am-btn-primary am-btn-sm am-fl">
        <a href="/User/Login/?from=<?php echo ($from); ?>" class="am-fr">我有账号 点此登录~</a>
      </div>
    </div>
    <hr>
    <p>你正在浏览的是由 <a href="http://cuican.name/" title="璨" target="_blank" class="">璨</a> 编写的项目 - <?php echo C('SITE_TITLE');?> CopyRight©2014-2015 Can.</p>
  </div>
</div>
</body>
</html>