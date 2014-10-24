<!DOCTYPE html>
<html lang="ja">
<head>
	<?php echo $this->Html->charset().PHP_EOL; ?>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo $title_for_layout; ?></title>
	<?php	echo $this->Html->meta('icon').PHP_EOL;?>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<?php echo $this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css').PHP_EOL;?>
	<?php echo $this->Html->css('style').PHP_EOL;?>
<?php echo $this->fetch('meta');?>
<?php echo $this->fetch('css');?>
<!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body ng-app="App">
	<!-- main -->
    <div class="login">
  		<div id="content">
        <div id="get_alert"></div>
    			<?php echo $this->fetch('content'); ?>
    	</div>
  </div>
<?php echo $this->Html->script('//code.jquery.com/jquery-1.11.0.min.js').PHP_EOL;?>
<?php echo $this->Html->script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js').PHP_EOL;?>
<?php echo $this->Html->script('min/lib.min').PHP_EOL;?>
<?php echo $this->Html->script('min/common.min').PHP_EOL;?>
<?php echo $this->fetch('script')?>
</body>
</html>