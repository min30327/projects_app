<?php $style = '';
if(!empty($AUTH['cover_file_name'])&&$user_page) :
    $style = "background-color:#333;color:#fff;background-size:cover;";
    $style .= "background-image:url('" . $this->Upload->uploadUrl($AUTH, 'User.cover', array('style' => 'original'))."')";
endif;
?>
  <div class="jumbotron" style="<?php echo $style;?>">
    <div class="container">
    <?php if($this->name=='Projects') :?>
      <h2 ng-if="!view">プロジェクト</h2>
      <h2 ng-if="view&&!edit_project" ng-bind="project.name"><?php echo $title_for_layout; ?></h2>
      <h2 ng-if="view&&edit_project">
      	<input type="text" ng-model="project.name" class="form-control mb20">
      	<button class="btn btn-warning" ng-click="editProject(project)">変更</button>
      	<button class="btn btn-default" ng-click="cancelEditProject()">キャンセル</button>
      	</h2>
      <div ng-if="view&&!edit_project" class="controls">
        <a href="javascript:void(0)" class="mr10" ng-click="showEditProjectFrom()">
          <i class="ion-ios7-compose fwb fz-l"></i>
          編集
        </a>
        <a href="javascript:void(0)" ng-click="deleteProject(project)">
          <i class="ion-ios7-close fwb fz-l"></i> 
          削除
        </a>
      </div>
      <?php else:?>
        <h2><?php echo $title_for_layout; ?></h2>
      <?php endif;?>  
    </div>
  </div>