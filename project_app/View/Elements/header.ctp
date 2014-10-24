<?php global $AUTH;?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php echo Configure::read('Company.name');?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><?php echo $this->Html->link('プロジェクト','/projects/');?></li>
        <!-- <li><a href="#">Link</a></li> -->
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li> -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown gnav-user">
          <div class="avatar w40">
            <?php if(!empty($AUTH['avatar_file_name'])) :?>
              <?php echo $this->Upload->uploadImage($AUTH, 'User.avatar', array('style' => 'thumb'),array("class"=>"img-circle")) ?>
            <?php else:?>
              <img src="<?php echo $this->Html->url('/img/user-dummy.png');?>" alt="avator" class="img-circle">
            <?php endif;?>  
          </div>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $AUTH['name']?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><?php echo $this->Html->link('プロフィールの編集','/users/edit/');?></li>
            <!-- <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li> -->
            <li class="divider"></li>
            <li><?php echo $this->Html->link('ログアウト','/users/logout/');?></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
