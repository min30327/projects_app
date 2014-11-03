			<div class="container" id="projects_content" data-url="<?php echo $this->Html->url('/projects/')?>">

				<div ng-show="!view">
					<div class="row mb15">
						<div class="col-md-3 mb-sm-10 mb10">
							<button class="btn btn-primary" ng-click="showProjectFrom()"><i class="f-lg ion-ios7-plus-empty"></i> 新規追加</button>
						</div>
					</div>
					<div class="panel panel-default slide-down" ng-show="add_project">
						<div class="panel-body">
							<div class="col-md-2 text-right">
								プロジェクト名
							</div>
							<div class="col-md-10 mb10">
								<input type="text" class="form-control" ng-model="newProjectName">
							</div>
							<div class="col-md-2 ">
								
							</div>
							<div class="col-md-10 mb10">
								<button class="btn btn-sm btn-primary" ng-click="addProject()">
									新規追加
								</button>
								<button class="btn btn-sm btn-default" ng-click="hideProjectFrom()">
									キャンセル
								</button>
							</div>
						</div>
					</div>
					<div class="list-group">
					  <li class="list-group-item disabled">
					    最近の動き
					  </li>
					  <a href="javascript:void(0);" ng-click="switchClient(message.project_id)" class="list-group-item ov-h" ng-repeat="message in messages">
						<span class="badge mr5 project_label">{{message.project_name}}</span>
						<span class="pull-left mr10 text-center db project_list_avatar">
						 	<span class="avatar w35">
								<img ng-src="{{ message.author.src }}" alt="avator" class="img-circle">
							</span>
							<span class="avatar_name">
								{{ message.author.name }}
							</span>
						</span>
					  	<span class="pull-left project_list_detail">
					  		{{message.body}}
					  	</span>
					  	<span class="db mb5 clearfix project_list_time">{{message.date | date:'yy年MM月dd日 HH:mm'}}</span>			
					  </span>
					  </a>
					</div>
				</div>
				<div ng-show="view">
					<ul class="nav nav-tabs nav-justified mb20" role="tablist">
						<li class="active">
							<a href="#timelines" role="tab" data-toggle="tab">タイムライン</a>
						</li>
						<li>
							<a href="#schedules" role="tab" data-toggle="tab">スケジュール</a>
						</li>
						<li>
							<a href="#details" role="tab" data-toggle="tab">概要</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="timelines">
							<div class="row mb15">
								<div class="col-md-3 mb-sm-10 mb10">
									<button class="btn btn-primary" ng-click="showMessageFrom()"><i class="f-lg ion-ios7-plus-empty"></i> 新規追加</button>
								</div>
								<div class="col-md-3 col-md-offset-6">
									<input type="text" ng-model="query" class="form-control" placeholder="キーワードから検索">
								</div>
							</div>
							<div class="panel panel-timeline-add slide-down" ng-show="add_new">
								<span class="avatar w50">
									<img ng-src="{{ author.src }}" alt="avator" class="img-circle">
									<span>
										<a href="">{{ author.name }}</a>
									</span>
								</span>
								<div class="panel-body">
									<div class="inner">
										<textarea rows="3" class="message-text form-control" placeholder="メッセージを書く" ng-model="newMessage" ></textarea>
									</div>
									<div class="text-right control-wrap">
										<time>
											<small>
												<i class="fa fa-clock-o"></i> {{ now_date | date:'yy年MM月dd日 HH:mm'}}
												<input type="hidden" ng-model="now_date">
											</small>
										</time>
									</div>
									<button class="btn btn-sm btn-primary" ng-click="addMessage()">
										投稿する
									</button>
									<button class="btn btn-sm btn-default" ng-click="hideMessageFrom()">
										キャンセル
									</button>
								</div>
							</div>
							<div class="wrap-timeline slide-top" ng-repeat="message in messages | orderBy:'-date' | filter:query">
								<div class="dateline" ng-if="prev_date(message.date,$index)">
									<span class="label-date">
										<i class="fa fa-lg fa-code-fork"></i> {{ message.date | date:'yy年MM月dd日'}}
									</span>
								</div>
								<div class="panel panel-timeline" id="message-{{message.id}}">
									<span class="avatar w50">
										<img ng-src="{{ message.author.src }}" alt="avator" class="img-circle">
										<span>
											<a href="/users/view/{{ message.author.id }}">{{ message.author.name }}</a>
										</span>
									</span>
									<div class="panel-body">
										<div ng-if="!message.edit" class="inner" ng-bind-html="message.body | nl2br | parseUrl">
										</div>
										<div ng-if="message.edit" class="mb15">
											<textarea ng-model="message.body" data-id="{{message.id}}" class="form-control" rows="4"></textarea>
										</div>
										<div ng-if="message.edit">
											<button class="btn btn-sm btn-primary" ng-click="editMessage(message)">
												変更する
											</button>
											<button class="btn btn-sm btn-default" ng-click="hideEditMessageFrom(message)">
												キャンセル
											</button>
										</div>
										<div class="text-right control-wrap">
											<span class="controls" ng-if="(message.user_id==author.id)">
												<a href="javacript:void(0);" ng-click="trigger_edit_message(message)"><i class="ion-ios7-compose-outline edit"></i>編集</a>
												<a href="javacript:void(0);" ng-click="delete_message(message.id)"><i class="ion-ios7-trash-outline trash"></i>削除</a>
											</span>
											<time>
												<small>
													<i class="fa fa-clock-o"></i> {{ message.date | date:'yy年MM月dd日 HH:mm'}}
												</small>
											</time>
										</div>
									</div>
								</div>
							</div>
							<ul class="pagination" ng-if="paginate" ng-bind-html="paginate"></ul>
						</div>
						<div class="tab-pane" id="schedules">
							<div class="row mb20">
								<div class="col-md-3 mb-sm-10">
									<button class="btn btn-primary" ng-click="showScheduleForm()"><i class="f-lg ion-ios7-plus-empty"></i> 新規追加</button>
								</div>
							</div>						
							<div class="panel panel-default" ng-show="add_schedule">
								<div class="panel-body">
									<div class="form row">
										<div class="col-md-3 mb10">
											<input type="date" class="form-control" ng-model="newScheduleDate">
										</div>
										<div class="col-md-12 mb10">
											<textarea class="form-control" rows="2" ng-model="newSchedule"></textarea>
										</div>
										<div class="col-md-12">
											<input type="button" value="スケジュールを追加" ng-click="addSchedule();" class="btn btn-primary mr5">
											<input type="button" value="キャンセル" ng-click="cancelSchedule();" class="btn btn-default">
										</div>
									</div>
								</div>	
							</div>						
							<div class="panel-schedule slide-top" id="schedule-{{schedule.id}}" ng-repeat="schedule in schedules | orderBy:'date'">
								<div class="panel panel-default">
									<div class="schedule_date panel panel-default toggle" ng-class="date_class(schedule)">
										<div class="month panel-heading">
											<small class="year">{{ schedule.date | date:'yyyy'}}</small>											
											{{ schedule.date | date:'MM'}}<small>月</small>
										</div>
										<div class="date panel-body">
											{{ schedule.date | date:'dd'}}<small>日</small>
										</div>
									</div>
									<div class="panel-body panel-schedule-body">
										<div ng-if="!schedule.edit" class="inner" ng-bind-html="schedule.title | nl2br | parseUrl">
										</div>
										<div ng-if="!schedule.edit&&schedule.completed" class="detail">
											<small>完了日 : {{schedule.complete_date}}</small>
										</div>
										<div ng-if="!schedule.edit&&schedule.completed==0" class="detail">
											<small ng-bind="schedule_away(schedule)"></small>
										</div>
										<div ng-if="schedule.edit" class="mb10">
											<input type="date" class="form-control" ng-model="schedule.date">
										</div>
										<div ng-if="schedule.edit" class="mb15">
											<textarea ng-model="schedule.title" data-id="{{schedule.id}}" class="form-control" rows="2"></textarea>
										</div>
										<div ng-if="schedule.edit">
											<button class="btn btn-sm btn-primary" ng-click="editSchedule(schedule)">
												変更する
											</button>
											<button class="btn btn-sm btn-default" ng-click="hideEditScheduleFrom(schedule)">
												キャンセル
											</button>
										</div>
										<div ng-show="!schedule.edit" class="hide_edit_mode">
											<div class="checks">
												<i ng-if="schedule.completed" ng-click="schedule_uncomplete(schedule)" class="ion-ios7-checkmark success scale-fade-in"></i>
												<i ng-if="schedule.completed==0" ng-click="schedule_complete(schedule)" class="ion-ios7-checkmark yet scale-fade-in"></i>				
											</div>
											<div class="controls">
												<a href="javacript:void(0);" ng-click="triggerEditSchedule(schedule)"><i class="ion-ios7-compose-outline edit"></i>編集</a>
												<a href="javacript:void(0);" ng-click="delete_schedule(schedule.id)"><i class="ion-ios7-trash-outline trash"></i>削除</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="details">
							<div class="row mb20">
									<div class="col-md-3 mb-sm-10">
										<button class="btn btn-primary" ng-click="showDetailForm()"><i class="f-lg ion-ios7-plus-empty"></i> 新規追加</button>
									</div>
								</div>						
								<div class="panel panel-default" ng-show="add_detail">
									<div class="panel-body">
										<div class="form row">
											<div class="col-md-2 text-right">
												名前
											</div>
											<div class="col-md-10 mb10">
												<input type="text" class="form-control" ng-model="newDetailKey">
											</div>
											<div class="col-md-2 text-right">
												値
											</div>
											<div class="col-md-10 mb10">
												<textarea class="form-control" rows="3" ng-model="newDetailValue"></textarea>
											</div>
											<div class="col-md-2">
												
											</div>
											<div class="col-md-9">
												<input type="button" value="概要を追加" ng-click="addDetail();" class="btn btn-primary mr5">
												<input type="button" value="キャンセル" ng-click="cancelDetail();" class="btn btn-default">
											</div>
										</div>
									</div>	
								</div>	
							<div class="panel panel-default details" >	
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="" width="20%">プロジェクト名</th>
												<th>{{project.name}}</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="detail in details | orderBy:'order'">
												<th class="">
													<span ng-if="!detail.edit">{{detail.key}}</span>
													<input type="text" class="form-control" ng-model="detail.key" ng-if="detail.edit">
												</th>
												<td>
													<div ng-bind-html="detail.value| nl2br | parseUrl" ng-if="!detail.edit"></div>
													<textarea class="form-control mb10" rows="3" ng-model="detail.value" ng-if="detail.edit"></textarea>
													<div ng-if="detail.edit">
														<button class="btn btn-sm btn-primary" ng-click="editDetail(detail)">
															変更する
														</button>
														<button class="btn btn-sm btn-default" ng-click="hideEditDetailFrom(detail)">
															キャンセル
														</button>
													</div>
													<div class="controls">
														<a href="javacript:void(0);" ng-click="triggerEditDetail(detail)"><i class="ion-ios7-compose-outline edit"></i>編集</a>
														<a href="javacript:void(0);" ng-click="delete_detail(detail)"><i class="ion-ios7-trash-outline trash"></i>削除</a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>