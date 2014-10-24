<?php $style = '';
if(!empty($AUTH['cover_file_name'])&&$user_page) :
    $style = "background-color:#333;color:#fff;background-size:cover;";
    $style .= "background-image:url('" . $this->Upload->uploadUrl($AUTH, 'User.cover', array('style' => 'original'))."')";
endif;
?>
  <div class="jumbotron" style="<?php echo $style;?>">
    <div class="container">
      <h2 ng-if="!view">プロジェクト</h2>
      <h2 ng-if="view&&!editProject" ng-bind="project.name"><?php echo $title_for_layout; ?></h2>
      <h2 ng-if="view&&editProject">
      	<input type="text" ng-model="project.name" class="form-control ">
      	<button class="btn btn-warning" ng-click="editProject(project)">変更</button>
      	<button class="btn btn-default" ng-click="cancelEditProject()">キャンセル</button>
      	</h2>
    </div>
  </div>