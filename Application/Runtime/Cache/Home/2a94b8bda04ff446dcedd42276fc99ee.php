<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<?php $auto_login = new \User\Api\UserApi; $auto_login->autologin(); if(!test_user()) { header("Location: /User/Login?from=".$_SERVER['PHP_SELF'].$_SERVER["QUERY_STRING"]); exit; } ?>
<html class="no-js">
<head>
	  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <!-- Set render engine for 360 browser -->
  <meta name="renderer" content="webkit">

  <!-- No Baidu Siteapp-->
  <meta http-equiv="Cache-Control" content="no-siteapp"/>

  <link rel="icon" type="image/png" href="/Public/assets/i/favicon.png">

  <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="icon" sizes="192x192" href="/Public/assets/i/app-icon72x72@2x.png">

  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
  <link rel="apple-touch-icon-precomposed" href="/Public/assets/i/app-icon72x72@2x.png">

  <!-- Tile icon for Win8 (144x144 + tile color) -->
  <meta name="msapplication-TileImage" content="/Public/assets/i/app-icon72x72@2x.png">
  <meta name="msapplication-TileColor" content="#0e90d2">

  <link rel="stylesheet" href="/Public/css/pnotify.custom.min.css"/>
  <!--<link href="/Public/bootstrap/css/bootstrap.css" id="bootstrap-css" rel="stylesheet" type="text/css"/>-->
  <link rel="stylesheet" href="/Public/assets/css/amazeui.min.css">
  <link rel="stylesheet" href="/Public/assets/css/app.css">
  <link rel="stylesheet" href="/Public/css/public.css">

  <!--[if (gte IE 9)|!(IE)]><!-->
  <script src="/Public/assets/js/jquery.min.js"></script>
  <!--<script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>-->
  <script src="/Public/assets/js/amazeui.min.js"></script>
  <script src="/Public/js/notify.js"></script>
<!--<![endif]-->

<!--[if IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，不能达到完整的浏览体验。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->
<!--[if lte IE 8]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，萌娘问答 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<script type="text/javascript">
  var upload_mode = 'answer';
</script>
</head>
<body>
 
<div id="space_height">
	<!-- 头部 -->
	

<header class="am-topbar">
<div class="am-container">
  <h1 class="am-topbar-brand">
    <a href="/"><?php echo C('SITE_TITLE');?></a>
  </h1>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li class="" id="topbar-index"><a href="/"><span class="am-icon-home"></span> 首页</a></li>
      <li id="topbar-setting"><a href="<?php echo U('/Home/Setting');?>"><span class="am-icon-user"></span> 账户设置</a></li>
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-info-circle"></span> 关于 <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="http://weibo.com/smilexc8" target="_blank"><span class="am-icon-weibo"></span> 璨的微博</a></li>
          <li><a href="http://cuican.name/?page_id=154" target="_blank"><span class="am-icon-meh-o"></span> 关于璨</a></li>
        </ul>
      </li>
    </ul>


  <!--用户名下拉菜单-->
  <div class="am-collapse am-topbar-collapse am-topbar-right" id="doc-topbar-user">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <?php echo cookie('username');?> <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li class="am-dropdown-header">用户操作</li>
          <li><a href="javascript:;" onclick="logout()">登出</a></li>
        </ul>
      </li>
    </ul>
    </div>


  </div>
  </div>
</header>




	<!-- /头部 -->

	<!-- 主体 -->
	<div class="am-container">
	
<script type="text/javascript">
	$("#topbar-index").addClass("am-active");
</script>
<title>首页 - <?php echo C('SITE_TITLE');?></title>
<script src="/Public/js/index.js"></script>

<div class="am-g">
	<div class="am-u-md-9">

		<table class="am-table">
		    <thead>
		        <tr>
		        	<th>账户名</th>
		            <th>贴吧名</th>
		            <th>签到时间</th>
		            <th>签到情况</th>
		        </tr>
		    </thead>
		    <tbody>
		    <?php if(is_array($SignList)): $i = 0; $__LIST__ = $SignList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		        	<th><?php if(empty($vo['cookiename'])): ?><i class="am-icon-spinner am-icon-spin"></i> 队列加载中<?php endif; ?><noempty name="vo['cookiename']"><?php echo $vo['cookiename'];?></noempty></th>
		            <td><?php echo $vo['tiebaname'];?></td>
		            <td><?php echo $vo['time'];?></td>
		            <td><?php if($vo['issign'] == 0): ?><i class="am-icon-close"></i> 未签到<?php elseif($vo['issign'] == 2): ?><i class="am-icon-circle-o"></i> 待签到<?php else: ?><i class="am-icon-check"></i> 已签到<?php endif; ?></td>
		        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
		    </tbody>
		</table>

	</div>
	<div class="am-u-md-3">
	<p>共 <?php echo count($SignList);?> 条数据</p>
	<hr />
      <div class="am-panel am-panel-default">
  <div class="am-panel-hd">赞助璨</div>
  <div class="am-panel-bd">
<form accept-charset="GBK" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="POST" target="_blank"><input name="optEmail" type="hidden" value="smilexcc@gmail.com"/><input name="payAmount" type="hidden" value="10"/><input id="title" name="title" type="hidden" value="赞助璨-C云签"/><input name="memo" type="hidden" value="大爷赏你一杯咖啡.."/><input name="pay" src="https://img.alipay.com/sys/personalprod/style/mc/btn-index.png" type="image" value="转账"/></form>
  </div>
</div>
		<?php if($overdueCount != 0): ?><div class="am-alert am-alert-danger" data-am-alert>
			  你有 <?php echo $overdueCount;?> 个Cookie过期<br/>快去设置里看看吧
			</div><?php endif; ?>
		<div class="am-panel am-panel-default">
		  <div class="am-panel-hd">筛选查看</div>
		  <div class="am-panel-bd">
			<ul class="am-nav">
			  <li><a href="/">全部</a></li>
			  <li><a href="<?php echo U('Home/Index/index').'?cookieid=-1';?>">只看未签到</a></li>
			  <?php if(is_array($cookieList)): $i = 0; $__LIST__ = $cookieList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Index/index').'?cookieid='.$vo['id'];?>"><?php if($vo['overdue'] == 1): ?><ins>失效Cookie</ins><?php endif; echo $vo['name'];?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		  </div>
		</div>
	</div>
</div>


	</div>
	<!-- /主体 -->

	<!-- 底部 -->
	<footer data-am-widget="footer" class="am-footer am-footer-default qa-footer-grey" data-am-footer="{  }">
  <div class="am-footer-switch">
    <span><?php echo C('SITE_TITLE');?></span>
  </div>
  <div class="am-footer-miscs ">
    <p>你正在浏览的是由
      <a href="http://cuican.name/" title="璨" target="_blank" class="">璨</a> 编写的项目 - <?php echo C('SITE_TITLE');?></p>
    <p>CopyRight©2014-2015 Can.</p>
  </div>
</footer>
	<!-- /底部 -->
</div>
<script src="/Public/js/notify.js"></script>
<script src="/Public/js/public.js"></script>
</body>
</html>