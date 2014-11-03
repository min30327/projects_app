
 	App = angular.module('App',['ngSanitize','ngAnimate']);

    /**
     * [description]
     * @return {[type]} [description]
     */
 	App.filter('nl2br', function() {
	  return function(input) {

        input = htmlentities(input);
	    return input.replace(/\n/g, '<br>');
	  };
	});
    /**
     * [description]
     * @return {[type]} [description]
     */
	App.filter('parseUrl', function() {
	    var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?!^=%&amp;:\/~+#-]*[\w@?!^=%&amp;\/~+#-])?/gi;
	    return function(text, target, style) {
	        style = style || null;
	        angular.forEach(text.match(urlPattern), function(url) {
	            if (style) {
	                text = text.replace(url, '<a target="' + target + '" href='+ url + ' style="' + style + '">' + url + '</a>');
	            } else {
	                text = text.replace(url, '<a target="' + target + '" href='+ url + '>' + url + '</a>');
	            }
	        });
	        return text;
	    };
	});
    function htmlentities(str) {
        return str.replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
    }
 	/**
     * TimelineController
     * @param  {[type]} $scope  [description]
     * @param  {[type]} $filter [description]
     * @return {[type]}         [description]
     */
 	App.controller('TimelineController',['$scope','$filter',function($scope,$filter){
        var path = $('#projects_content').data('url');
     
        $scope.projects = [];
        $scope.newScheduleDate='';
        $.getJSON(
                path + 'get_project_lists/',
                function(json){
                $scope.$apply(function() {
                    $scope.projects = json;
                     if(window.location.hash!==''){
                        var hash = window.location.hash.replace(/^#\!/,'');
                        var id = hash.split("+")[0];
                        setTimeout(function(){
                         $scope.newMessage = '';   
                         $scope.switchClient(id,true);
                        },200);
                    }else{
                        $scope.switchIndex();
                    }
                })
            }
        );
       $(window).on('load',function(){
           $scope.$apply(function() {
                 popState();
                 $(document).on('click','.pagination a',function(e){
                    e.preventDefault();
                    var hash = window.location.hash.replace(/^#\!/,'');
                    var id = hash.split("+")[0];
                    id += '+page=' + $(this).text();
                    window.location.hash = '!'+id;
                 })
             });
            $(document)
              .on('keydown.add_message','.message-text',function(e){ 

             if(e.keyCode==13 && e.shiftKey){
                e.preventDefault(); 
                add = false;
                $('.message-text')
                    .off('keydown.add_message');
                    if($(this).hasData('id')){
                        $scope.editMessage($(this).data('id'));
                    }else{
                        $scope.addMessage();
                    }         
                }
            });
        })

 		$scope.now_date = new Date().getTime();
 		$scope.add_new = false;
        $scope.newMessage = '';
 		/**
         * [showMessageFrom description]
         * @return {[type]} [description]
         */
		$scope.showMessageFrom = function(){
            // var add = true;
			$scope.add_new = true;
            setTimeout(function(){
                $scope.now_date = new Date().getTime();
                  $('.message-text').trigger('focus');
            },150);
		}

    
        /**
         * [hideMessageFrom description]
         * @return {[type]} [description]
         */
		$scope.hideMessageFrom = function(){
			$scope.add_new = false;
		}
 		/**
         * [addMessage description]
         */
 		$scope.addMessage = function(){
            if($scope.newMessage==''){
                alert('入力してください')
            }else{
    			$scope.add_new = false;
                $.ajax({
                    url :path  +'add_message/',
                    type : 'Post',
                    data : {
                            data : { 
                            Message : { 
                            project_id :$scope.id,
                            body : $scope.newMessage,
                            user_id :  $scope.author.id,
                            date : $scope.now_date
                            }
                        }
                    },
                    success: function(data){
                        $scope.newMessage='';
                        $scope.$apply(function(){
                            $scope.messages.push(data);
                        });
                    }
                })
     			
            }
 		}
        /**
         * [editMessage description]
         */
        $scope.editMessage = function(message){
            if(message.body==''){
                alert('入力してください')
            }else{
                $scope.add_new = false;
                $.ajax({
                    url :path  +'add_message/' + message.id,
                    type : 'Post',
                    data : {
                            data : { 
                            Message : { 
                            project_id :$scope.id,
                            body : message.body,
                            user_id :  $scope.author.id,
                            date : $scope.now_date
                            }
                        }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                            for(var i = 0; i < $scope.messages.length; i++){
                                    if( $scope.messages[i].id==data.id){
                                       $scope.messages[i] = data;
                                    };
                            }
                        });
                    }
                })
                
            }
        }
        /**
         * [hideMessageFrom description]
         * @return {[type]} [description]
         */
        $scope.hideEditMessageFrom = function(message){
            var i = $scope.messages.indexOf(message);
            $scope.messages[i].edit = false;
        }
        $scope.trigger_edit_message = function(message){
            var i = $scope.messages.indexOf(message);
            $scope.messages[i].edit = true;
        }
        $scope.delete_message = function(id){
            var confirm  = {
                title : '本当に削除しますか？',
                size :'xs',
                content : 'このメッセージを削除します。よろしければ[ 削除 ]ボタンを押してください。',
                submitClass : 'btn-danger delete_message',
                submitText : '削除',
                footer : true
            };
            var source = $('#modal_tmpl').tmpl(confirm);
            $('#get-modal').html(source);
            $('.modal').modal();
            $('#get-modal .modal-body').append($('#message-'+id).clone());
            $(document).on('click.delete_message','.delete_message',function(){
                $('.modal').modal('hide');
                $.ajax({
                    url :path  +'delete_message/' + id,
                    type : 'Post',
                    data : {
                        data:{
                          project_id : $scope.id
                        }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                            for(var i = 0; i < $scope.messages.length; i++){

                                    if( $scope.messages[i].id==data.id){
                                       $scope.messages.splice(i,1);
                                    };
                            }
                        });
                    }
                })
            });

            $('.modal').on('hidden.bs.modal', function (e) {
                 $(document).off('click.delete_message','.delete_message');
            })
        }
        $scope.date_class = function(schedule){
            if(schedule.completed==0){
                    var d = new Date();
                    lastW = (d.getTime() / 1000) - (86400 * 7);
                    today = d.getTime() / 1000;
                    date = (new Date(schedule.date).getTime() / 1000);
                    if(today > date ){
                        if(lastW < date ){
                            return 'warning';
                        }else if(lastW > date){
                            return 'danger';
                        }
                    }
                return 'yet';
            }
        }
        $scope.schedule_away = function(schedule){
                
                    var d = new Date();
                    var today = d.getTime();
                    var date = new Date(schedule.date).getTime();
                    
                if(date > today){
                    var diff = date - today;
                    var diff = Math.floor(diff / (1000 * 60 * 60 *24));
                    return '残り'+ (diff+1) +'日';
                }else{
                    var diff = today - date;
                    var diff = Math.floor(diff / (1000 * 60 * 60 *24));
                    return ( diff ) +'日経過';
                }
        }
        $scope.schedule_complete = function(schedule){
            $.ajax({
                    url :path  +'schedule_complete/' + schedule.id,
                    type : 'Post',
                    data : {
                            data:{
                                completed : 1,
                                project_id : $scope.id
                            }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                           var i = $scope.schedules.indexOf(schedule);
                            $scope.schedules[i].completed = true;
                            $scope.schedules[i].complete_date = data.date;
                        });
                    }
                })
        }
        $scope.schedule_uncomplete = function(schedule){
             $.ajax({
                    url :path  +'schedule_complete/' + schedule.id,
                    type : 'Post',
                    data : {
                            data:{
                                completed : 0,
                                project_id : $scope.id
                            }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                           var i = $scope.schedules.indexOf(schedule);
                            $scope.schedules[i].completed = false;
                        });
                    }
                })
        }
        $scope.delete_schedule = function(id){
             var confirm  = {
                title : '本当に削除しますか？',
                size :'xs',
                content : 'このスケジュールを削除します。よろしければ[ 削除 ]ボタンを押してください。',
                submitClass : 'btn-danger delete_schedule',
                submitText : '削除',
                footer : true
            };
            var source = $('#modal_tmpl').tmpl(confirm);
            $('#get-modal').html(source);
            $('.modal').modal();
            $('#get-modal .modal-body').append($('#schedule-'+id).clone());
            $(document).on('click.delete_schedule','.delete_schedule',function(){
                $('.modal').modal('hide');
                $.ajax({
                    url :path  +'delete_schedule/' + id,
                    type : 'Post',
                    data : {
                        data:{
                            project_id : $scope.id
                        }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                            for(var i = 0; i < $scope.schedules.length; i++){

                                    if( $scope.schedules[i].id==data.id){
                                       $scope.schedules.splice(i,1);
                                    };
                            }
                        });
                    }
                })
            });

            $('.modal').on('hidden.bs.modal', function (e) {
                 $(document).off('click.delete_schedule','.delete_schedule');
            })
        }
        

        $scope.showScheduleForm = function(){
            $scope.add_schedule = true;
        }
        $scope.cancelSchedule = function(){
            $scope.add_schedule = false;
        }
        $scope.addSchedule = function(){
            if($scope.newSchedule=='' || $scope.newScheduleDate==''){
                alert('入力してください')
            }else{
                $scope.add_schedule = false;
                $.ajax({
                    url :path  +'add_schedule/',
                    type : 'Post',
                    data : {
                            data : { 
                            Schedule : { 
                            project_id :$scope.id,
                            title : $scope.newSchedule,
                            author_id :  $scope.author.id,
                            completed : 0,
                            date : $scope.newScheduleDate
                            }
                        }
                    },
                    success: function(data){
                        $scope.newSchedule='';
                        $scope.$apply(function(){
                            $scope.schedules.push(data);
                        });
                    }
                })
                
            }
        }
        $scope.editSchedule = function(schedule){
           if(schedule.title== '' || schedule.date ==''){
                alert('入力してください')
            }else{
                var id = $scope.schedules.indexOf(schedule);
                $scope.schedules[id].edit = false;
                $.ajax({
                    url :path  +'add_schedule/' + schedule.id,
                    type : 'Post',
                    data : {
                            data : { 
                            Schedule : { 
                            project_id :$scope.id,
                            title : schedule.title,
                            author_id :  $scope.author.id,
                            date : schedule.date
                            }
                        }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                            // $scope.schedules.push(data);
                        });
                    }
                })
                
            }
        }
        $scope.hideEditScheduleFrom = function(schedule){
            var i = $scope.schedules.indexOf(schedule);
            $scope.schedules[i].edit = false;
        }
        $scope.triggerEditSchedule = function(schedule){
            var i = $scope.schedules.indexOf(schedule);
            $scope.schedules[i].edit = true;
        }

        $scope.showDetailForm = function(){
            $scope.add_detail = true;
        }
        $scope.cancelDetail = function(){
            $scope.add_detail = false;
        }

        $scope.delete_detail = function(detail){
            var id = $scope.details.indexOf(detail);
             var confirm  = {
                title : '本当に削除しますか？',
                size :'xs',
                content : 'この項目を削除します。よろしければ[ 削除 ]ボタンを押してください。',
                submitClass : 'btn-danger delete_detail',
                submitText : '削除',
                footer : true
            };
            var source = $('#modal_tmpl').tmpl(confirm);
            $('#get-modal').html(source);
            $('.modal').modal();
            $('#get-modal .modal-body').append('<div class="panel panel-default mt20"><div class="panel-body"><dl class="dl-horizontal"><dt>'+detail.key+'</dt><dd>'+detail.value+'</dd></dl></div></div>');
            $(document).on('click.delete_detail','.delete_detail',function(){
                $('.modal').modal('hide');
                $scope.$apply(function(){
                    $scope.details.splice(id,1);
                });
                $.ajax({
                    url :path  +'add_detail/' + $scope.id,
                    type : 'Post',
                    data : {
                            data :{
                                details : $scope.details
                            }
                    }                    
                })
            });

            $('.modal').on('hidden.bs.modal', function (e) {
                 $(document).off('click.delete_detail','.delete_detail');
            })
        }
        

        $scope.addDetail = function(){
        if($scope.newDetailKey=='' || $scope.newDetailValue==''){
                alert('入力してください')
            }else{
                $scope.add_detail = false;
                $scope.details.push({
                    key : $scope.newDetailKey,
                    value : $scope.newDetailValue
                })
                $.ajax({
                    url :path  +'add_detail/' + $scope.id,
                    type : 'Post',
                    data : {
                            data :{
                                details : $scope.details
                            }
                    },
                    success: function(data){
                        $scope.newDetailKey='';
                        $scope.newDetailValue='';
                    }
                })
                
            }
        }
        $scope.editDetail = function(detail){
           if(detail.title== '' || detail.date ==''){
                alert('入力してください')
            }else{
                var id = $scope.details.indexOf(detail);
                $scope.details[id].edit = false;
                $scope.details[id] = {
                    key : detail.key,
                    value : detail.value,
                    order : detail.order
                };
                $.ajax({
                    url :path  +'add_detail/' + $scope.id,
                    type : 'Post',
                    data : {
                            data :{
                                details : $scope.details
                            }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                            // $scope.schedules.push(data);
                        });
                    }
                })
                
            }
        }
        $scope.hideEditDetailFrom = function(detail){
            var i = $scope.details.indexOf(detail);
            $scope.details[i].edit = false;
        }
        $scope.triggerEditDetail = function(detail){
            var i = $scope.details.indexOf(detail);
            $scope.details[i].edit = true;
        }
        $scope.showProjectFrom = function(){
            $scope.add_project = true;
        }
        $scope.hideProjectFrom = function(){
            $scope.add_project = false;
        }
        $scope.showEditProjectFrom = function(){
            $scope.edit_project = true;
        }
        $scope.cancelEditProject = function(){
            $scope.edit_project = false;
        }
        $scope.addProject = function(){
            if($scope.newProjectName == ''){
                alert('入力してください');
            }else{
                $.ajax({
                    url :path  +'add/',
                    type : 'Post',
                    data : {
                            data :{
                                Project :{
                                    name : $scope.newProjectName
                                }
                            }
                    },
                    success: function(data){
                        
                        $scope.$apply(function(){
                            $scope.projects.push({id:data.id,name:$scope.newProjectName})
                        });
                        $scope.switchClient(data.id);
                        $scope.newProjectName='';
                    }
                })
            }
        }
        $scope.editProject = function(project){
            if(project.name == ''){
                alert('入力してください');
            }else{
               $.ajax({
                    url :path  +'edit/' + project.id,
                    type : 'Post',
                    data : {
                            data :{
                                Project :{
                                    name : project.name
                                }
                            }
                    },
                    success: function(data){
                        $scope.$apply(function(){
                             for(var i = 0; i < $scope.projects.length; i++){
                                 if( $scope.projects[i].id==project.id){
                                        $scope.projects[i].name = project.name; 
                                }
                            }
                        });
                    }
                })
            }
        }
        $scope.deleteProject = function(project){
            var id = project.id;
             var confirm  = {
                title : '本当に削除しますか？',
                size :'xs',
                content : 'このプロジェクトを削除します。よろしければ[ 削除 ]ボタンを押してください。',
                submitClass : 'btn-danger delete_project',
                submitText : '削除',
                footer : true
            };
            var source = $('#modal_tmpl').tmpl(confirm);
            $('#get-modal').html(source);
            $('.modal').modal();
            $('#get-modal .modal-body').append('<div class="panel panel-default mt20"><div class="panel-body"><h3>'+project.name+'</h3></div></div>');
            $(document).on('click.delete_project','.delete_project',function(){
                $('.modal').modal('hide');
                $.ajax({
                    url :path  +'delete/' + id,
                    type : 'Post',
                    data : '',
                    success : function(){
                        window.location.href = path;
                    }          
                })
            });

            $('.modal').on('hidden.bs.modal', function (e) {
                 $(document).off('click.delete_project','.delete_project');
            })
        }
        /**
         * [switchClient description]
         * @param  {[type]} id [description]
         * @return {[type]}    [description]
         */
        $scope.switchIndex = function(){

                loading();
                $scope.view = false;
                window.location.hash = '';
                $scope.messages = [];
                $scope.schedules = [];
                $scope.detail = [];
                $('.side-nav .nav li').removeClass('active');
                $('.project_index').addClass('active');

                $.ajax({
                    url :path  +'get_information/',
                    type : 'Post',
                    data : {},
                    success: function(data){
                        $scope.$apply(function(){
                            get_scope(data);
                            loading_complete();
                        });
                    }
                })
        }
        /**
         * [switchClient description]
         * @param  {[type]} id [description]
         * @return {[type]}    [description]
         */
        $scope.switchClient = function(id,first){
            loading();
            $scope.predate = '';
            $scope.view = true;
            $scope.id = id;
            $scope.messages = [];
            $scope.schedules = [];
            $scope.detail = [];
            var hash = window.location.hash.replace(/^#\!/,'');
            var hash = hash.split("+");
            var uri = id;
            if(first){
                if(hash[1]!=undefined) uri += '+' + hash[1];
            }
            window.location.hash = '!'+uri;
            // window.history.pushState(null, null,window.location.href.replace(window.location.hash,'') +'#!/' + id);
            $('.side-nav .nav li').removeClass('active');
            $('.side-nav .nav li.project-' + id).addClass('active');
            // pushState(id);
        }

        window.addEventListener('popstate', function(event) {
            popState();
        },false );

        $scope.prev_date = function(date,i){
          
                var d = new Date();
                d.setTime(date);
                d = d.getDate();

                if($scope.predate != d ){
                        $scope.predate = d;
                        return true;
                  }
            return false;
        }
        var popState = function(){
            if(window.location.hash==''){

                 // $scope.switchIndex();
            }else{
                var hash = window.location.hash.replace(/^#\!/,'');
                
                setTimeout(function(){
                 $scope.newMessage = '';   
                 pushState(hash);
                },400);
            }
        }
        var pushState = function (hash){
             var id = hash.split("+")
             var uri  = id[0];
             if(id.length > 1)
                uri = uri + '?';

             for(var i in id){
                if(i > 0){
                     uri += id[i]
                }
             }
             $.getJSON(
                   path   +'get_data/' + uri ,
                    function(json){
                    $scope.$apply(function() {
                            get_scope(json);
                            loading_complete();
                    })
                }
            ).error(function(){
                notfound();
            });
        } 
        var notfound = function(){
            var source = $('#alert_tmpl').tmpl({
                alertClass : 'alert-danger',
                strong : 'Not Found!',
                message : 'ページが見つかりませんでした。'
            });
            $('#get_alert').html(source);
        }
        var get_scope = function(json){
             $scope.messages = (json.messages) ? json.messages : [];
             $scope.author = json.author;
             $scope.project = json.project;
             $scope.schedules = json.schedules;
             $scope.details = (json.details) ? json.details : [];
             $scope.paginate = json.paginate;
        }
        var loading = function(){
            $('#loading').removeClass('active');
        }
        var loading_complete = function(){
            $('#loading').addClass('active');
        }
 	}]);

