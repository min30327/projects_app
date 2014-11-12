<?php
App::uses('AppController', 'Controller');
/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 */
class ProjectsController extends AppController {

	public $uses = array('Project','User','Message','Schedule');
	
	 
	public function beforeFilter()
	{
		parent::beforeFilter();
		//login処理の設定
	    $this->Auth->allow('index','edit');
	    // //ログインしないで、アクセスできるアクションを登録する
	    // $this->set('user',$this->Auth->user()); // ctpで$userを使えるようにする 。
	    // $this->layout = 'user';
  	}
/**
 * index method
 *
 * @return void
 */
	public function index($id = null) {
		
		if(empty($id)) $id = 1;
		
		if (!$this->Project->exists($id)) 
		{
			throw new NotFoundException(__('Not Found'));
		}
		$this->Project->id = $id;
		$this->data = $this->Project->read();
		// pr($this->data);
	}
	public function add(){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		if($this->Project->save($this->request->data)){
			$id = $this->Project->getLastInsertID();
			$response = array('id'=>$id);
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 	
	}
	public function edit($id =null){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		$this->Project->id = $id;
		if($this->Project->exists($id))
		{
			$this->Project->saveField('name',$this->request->data['Project']['name']);
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 	
	}
	public function delete($id =null){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		$this->Project->id = $id;
		$this->Project->delete($id);
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 	
	}
	/**
	 * [get_project_lists description]
	 * @return [type]
	 */
	public function get_project_lists(){
		$this->viewClass = 'Json';
		$this->Project->recursive = 2;
		$response = array();
		$data = $this->Project->find('all');
			foreach($data as $k => $v)
			{
				$response[] = array('id'=>$v['Project']['id'],'name'=>$v['Project']['name'],'modified'=> $v['Project']['modified']);
			}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}
	/**
	 * [get_data description]
	 * @param  [type] $id
	 * @return [type]
	 */
	public function get_data($id=null){
		global $AUTH;
		$newMessage = array();
		$this->Project->recursive = 2;
		$this->viewClass = 'Json';

		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Not Found'));
		if (!$this->Project->exists($id)) 
			throw new NotFoundException(__('Not Found'));

		$this->Project->id = $id;
		$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
		$data = $this->Project->find('first', $options);
		$this->paginate = array(
	                'Message' => array(
	                    'conditions' => array('project_id'=>$id),
	                    'order' => array('modified'=>'DESC'),
	                    'limit' =>10,
	                    'paramType' => 'querystring'
	                )
	  	);

		$message = $this->paginate('Message');

		$response['author'] = $this->Core->createAuthor($AUTH);
		foreach($message as $k => $v)
		{
			$newMessage[$k] = $v['Message'];
			$newMessage[$k]['author'] = $this->Core->createAuthor($v['User']);
			$newMessage[$k]['edit'] = false;
		}
		$response['project']['id'] = $data['Project']['id'];
		$response['project']['name'] = $data['Project']['name'];
		$response['details'] =  json_decode($data['Project']['data'],true);
		$response['schedules'] = $data['Schedule'];
		$response['messages'] = $newMessage;
		App::import('Helper', 'Paginator');
		$this->Paginator = new PaginatorHelper(new View(null));
		$response['paginate'] = $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1, 'ellipsis' => '<li class="disabled"><a>...</a></li>'));
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}
	public function get_information(){
		global $AUTH;
		$newMessage = array();
		$this->viewClass = 'Json';
		$this->Message->recursive = 2;
		$this->Schedule->recursive = 2;
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Not Found'));
		
		$this->paginate = array(
	                'Message' => array(
	                    'order' => array('modified'=>'DESC'),
	                    'limit' =>7,
	                    'paramType' => 'querystring'
	                )
	  	);

		$message = $this->paginate('Message');
		$schedule = $this->paginate('Schedule');
		$response['author'] = $this->Core->createAuthor($AUTH);
		foreach($message as $k => $v)
		{
			$newMessage[$k] = $v['Message'];
			$newMessage[$k]['author'] = $this->Core->createAuthor($v['User']);
			$newMessage[$k]['project_name'] = $v['Project']['name'];
			$newMessage[$k]['body'] = mb_strimwidth($newMessage[$k]['body'],0,'200',' ...');
		}
		foreach($schedule as $k => $v)
		{
			$newSchedule[$k] = $v['Schedule'];
		}
		$response['schedules'] = $newSchedule;
		$response['messages'] = $newMessage;
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}
	/**
	 * [get_data description]
	 * @param  [type] $id
	 * @return [type]
	 */
	public function add_message($id = null){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		if($this->Message->exists($id)){
			$this->Message->id = $id;
		}else{
			$this->Message->create();
		}
	 
		if($this->Message->save($this->request->data)){
			if(empty($id)) $id = $this->Message->getLastInsertID();
			$data = $this->Message->findById($id);
			$data['Message']['author'] = $this->Core->createAuthor($data['User']);
			$data['Message']['edit'] = false;

			$this->update_project($this->request->data['Message']['project_id']);
			unset($data['Message']['User']);
			$response = $data['Message'];
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}
	/**
	 * [delete_message description]
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_message($id){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		if($this->Message->delete($id)){
			$response = array('id'=>$id);
			$this->update_project($this->request->data['project_id']);
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}

	/**
	 * [get_data description]
	 * @param  [type] $id
	 * @return [type]
	 */
	public function add_schedule($id = null){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		if($this->Schedule->exists($id)){
			$this->Schedule->id = $id;
		}else{
			$this->Schedule->create();
		}
		if($this->Schedule->save($this->request->data)){
			if(empty($id)) $id = $this->Schedule->getLastInsertID();
			$data = $this->Schedule->findById($id);
			// $data['Schedule']['author'] = $this->Core->createAuthor($data['User']);
			$data['Schedule']['edit'] = false;
			unset($data['Schedule']['User']);
			$response = $data['Schedule'];
			$this->update_project($data['Schedule']['project_id']);
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}
	/**
	 * [get_data description]
	 * @param  [type] $id
	 * @return [type]
	 */
	public function schedule_complete($id = null){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		if(!$this->Schedule->exists($id)){
			throw new NotFoundException(__('Invalid request'));
		}
		$data = $this->Schedule->findById($id);
		$data['Schedule']['completed'] = $this->request->data['completed'];
		$data['Schedule']['complete_date'] = ($data['Schedule']['completed']) ? date('Y-m-d') :'0000-00-00';
		if($this->Schedule->save($data)){
			$response = array('id'=>$id,'date'=>$data['Schedule']['complete_date']);
			$this->update_project($this->request->data['project_id']);
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}
	/**
	 * [get_data description]
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_schedule($id = null){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		if(!$this->Schedule->exists($id)){
			throw new NotFoundException(__('Invalid request'));
		}
		
		if($this->Schedule->delete($id)){
			$response = array('id'=>$id);
			$this->update_project($this->request->data['project_id']);
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}

	public function update_project($id){
		
		$this->Project->id = $id;
		if($this->Project->exists($id))
		{
			$this->Project->saveField('modified',date('Y-m-d H:i:s'));
		}
	}

	public function add_detail($id=null){
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		$this->viewClass = 'Json';
		if (!$this->Project->exists($id))
			throw new NotFoundException(__('Not Found'));
		$this->Project->id = $id;
		
		foreach($this->request->data['details'] as $k => $v){
			unset($this->request->data['details'][$k]['$$hashKey']);
		}
		$data  = json_encode($this->request->data['details']);
		$this->Project->saveField('data',$data);
		$this->update_project($id);
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}
}