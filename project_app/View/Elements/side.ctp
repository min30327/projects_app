    <div>
      <div class="side-nav">
          <div class="panel-body">
            <input type="text" ng-model="searchProject" class="form-control" placeholder="プロジェクトを検索">
          </div>
          <nav>
            <ul class="nav nav-pills nav-stacked">
              <li class="active project_index">
                <a href="javascript:void(0);" ng-click="switchIndex()">プロジェクト</a>
              </li>
             <li ng-repeat="project in projects | orderBy:'-modified' | filter:searchProject" class="project-{{ project.id }}">
              <a href="javascript:void(0)" ng-click="switchClient(project.id)">
                {{ project.name }}
                <i class="pull-right ion-ios7-arrow-right"></i>
              </a>
            </li>
            </ul>
          </nav>
        </div>
    </div>