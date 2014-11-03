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
	<?php echo $this->fetch('meta').PHP_EOL;?>
	<?php echo $this->fetch('css').PHP_EOL;?>
<!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="has-navbar-top" >
	<?php echo $this->element('user-side');?>
	<!-- main -->
    <div class="main">
      <?php echo $this->element('header');?>
      <?php echo $this->element('jumbotron',array('user_page'=>true));?>
   		<div id="content" class="container">
  		  <div id="get_alert"></div>
  		  <?php echo $this->Session->flash();?>
  			<?php echo $this->fetch('content'); ?>
  		</div>
	</div>

<script src="https://code.angularjs.org/1.2.9/angular.js"></script>
<script src="https://code.angularjs.org/1.2.9/angular-animate.js"></script>		
<?php echo $this->Html->script('//code.jquery.com/jquery-1.11.0.min.js').PHP_EOL;?>
<?php echo $this->Html->script('//ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js').PHP_EOL;?>
<?php echo $this->Html->script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js').PHP_EOL;?>
<?php echo $this->Html->script('min/lib.min').PHP_EOL;?>
<?php echo $this->Html->script('min/common.min').PHP_EOL;?>
<?php echo $this->fetch('script').PHP_EOL;?>
<script id="alert_tmpl" type="text/x-jquery-tmpl">
  <div class="alert ${alertClass}">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <i class="fa  {{if iconClass}}${iconClass}{{else}}fa-exclamation-triangle{{/if}}"></i><strong>${strong}</strong>　 ${message}
    </div>
</script>
<script id="modal_tmpl" type="text/x-jquery-tmpl">
<div class="modal fade" id="modal-window" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-${size}">
    <div class="modal-content">
     <div class="modal-header">
        <button type="button" id="modal-xlg-close" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">${title}</h4>
      </div>
 			<div class="modal-body">
 				${content}
 			</div>
 			{{if footer}}
 			 <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
        <button type="button" class="btn btn-primary ${submitClass}">${submitText}</button>
      </div>
      {{/if}}
    </div>
  </div>
</div>
</script>
<div id="get-modal"></div>
</body>
</html>