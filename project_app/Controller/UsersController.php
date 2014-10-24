<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController 
{
	public $uses = array('User','OnetimeToken');

	public function beforeFilter()
	{
		parent::beforeFilter();
		//login処理の設定
	    $this->Auth->allow('login','logout','identify','retype_password','add');
	    // //ログインしないで、アクセスできるアクションを登録する
	    // $this->set('user',$this->Auth->user()); // ctpで$userを使えるようにする 。
	    $this->layout = 'login';
  }

/**
 * index method
 *
 * @return void
 */
	public function index() 
	{
		$this->layout = 'user';
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	/**
	 * [login description]
	 * @return [type] [description]
	 */
	public function login()
	{
		if($this->request->is('post'))
		{
			if($this->Auth->login())
			{			
				$user = $this->Auth->user();
				if($this->request->data['User']['rememberme']){
				    $pass = array('Passport'=>$user['passport']);
				    $this->Cookie->write('pass', $pass, null,'+2 year');
				}else{
					$this->Cookie->delete('pass');
				}
				return $this->redirect($this->Auth->redirect());
			}else{
				$this->Core->get_alert('ユーザー名またはパスワードが違うようです','danger');	
			}
		}
	}

	public function logout()
	{
		$this->autoRender = false;
		$this->Core->get_alert('ログアウトしました','info');
		$this->Cookie->delete('pass');
		$this->redirect($this->Auth->logout());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) 
	{
		if (!$this->User->exists($id)) 
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() 
	{
		if ($this->request->is('post')) 
		{
			$this->request->data['User']['passport'] = Security::generateAuthKey();
			$this->User->create();
			if ($this->User->save($this->request->data)) 
			{
				$this->Core->get_alert('ユーザーを追加しました。','success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Core->get_alert('ユーザーを追加できませんでした。','danger');
			}
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) 
	{
		if(empty($id))
			$id = $this->Auth->user('id');
		$this->layout = 'user';
		if (!$this->User->exists($id)) 
		{
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) 
		{
			$this->User->id = $id;
			if ($this->User->save($this->request->data)) 
			{
				$this->Core->get_alert('ユーザー情報を変更しました。','success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Core->get_alert('ユーザー情報を変更できませんでした。','danger');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function upload($id = null) 
	{
		$this->viewClass = 'Json';
		$response = array();
		if (!$this->request->is('ajax'))
			throw new NotFoundException(__('Invalid request'));
		if (!$this->User->exists($id)) 
			throw new NotFoundException(__('Invalid user'));
			$this->User->id = $id;
		if ($this->User->save($this->request->data)) 
		{
			$user = $this->User->read();
			App::import('Helper', 'UploadPack.Upload');
			$this->Upload = new UploadHelper(new View(null));
			$response = array(
			                 'img'=> $this->Upload->uploadImage($user,'User.'.$_GET['type'], array('style' => 'thumb')),
			                 'error' =>false
			                 );

		}else{
			$response =array(
			                 'img'=> NULL,
			                 'error' =>true,
			                 'message' => $this->User->validationErrors[$_GET['type']]
			);
		}
		$this->set(compact('response'));
    	$this->set('_serialize', 'response'); 
	}

/**
 * identify method パスワードの再発行
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function identify() 
	{

		if($this->request->is('POST'))
		{
			if(!array_key_exists('mail',$this->request->data['User']))
			{
				throw new ErrorException(__('Invalid request'));
			}
			$user = $this->User->findByUsername($this->request->data['User']['mail'],array('fields'=>'id'));
			$this->User->id =  $user;
			if (!$this->User->exists()) 
			{
				$this->Core->get_alert('無効なメールアドレスです。','danger');
			}else{
				$to = $this->request->data["User"]["mail"];
				$this->request->data["OnetimeToken"]["user_id"] = $user["User"]["id"];
         		//ワンタイムパスワードを取得
				$token = $this->Core->generateToken($this->Core->random_string());
           		//token をセット
		    	$this->request->data["OnetimeToken"]["token"] = $token;
		   		//tokenを保存
				$this->OnetimeToken->create();
		   		if($this->OnetimeToken->save($this->request->data))
		   		{
					// ラストインサートIDを取得  
					$id = $this->OnetimeToken->getLastInsertID();		
					
					$url = Router::url('/users/retype_password/', true) . "?token=".$token."&id=".$id; 
					$body = $this->Templates->forgot_password($url);
							
					$Email = new CakeEmail("default");
				
					/* Send Options */
					$Email->to($to); 
					$Email->subject("パスワードの再発行");
					$Email->emailFormat(Configure::read('EmailOptions.email_format'));  
						$Email->template('default');
						$Email->from( 
						             array( 
						                   Configure::read('EmailOptions.admin_mail') =>
						                   Configure::read('EmailOptions.admin_name')
						              )
					);	

					if($Email->send($body))
					{					
						$this->Core->get_alert('メールを送信しました。送信されたリンクからパスワードを再発行してください。','success');
						$this->redirect("/users/login/");
					}  
				}
			}
		}
	}

/***
*	
*	パスワードの再発行
*	
****/
     public function retype_password() {
		$this->set('title_for_layout', 'パスワードの再発行｜ダッシュボード | 管理画面');
		
		//一日前を取得
		$date = date("Ymd",strtotime("-1 day")); 
		
		if(!$_GET["token"] && !$_GET["id"]) 
		{
	 		return $this->redirect("/users/login/");
	 		
	    }
		
		$token = $this->OnetimeToken->find('all',
		          array(
		       		'conditions' => 
		       			array(
		       			      "id"		=>	$_GET["id"],
		       			      "created >="=> $date)
		       			)
		          );
		
		if(!$token || $token[0]["OnetimeToken"]["token"] != $_GET["token"]) 
		{
	 		return $this->redirect("/users/login/");
	 		
	    }
		if($this->request->is("post"))
		{			
			if($this->request->data["User"]["password"] == $this->request->data["User"]["password2"])
			{				
				$this->User->id = $token[0]["OnetimeToken"]["user_id"];
					
					if($this->User->save($this->request->data))
					{							
						//トークンを削除
						$this->OnetimeToken->delete($token[0]["OnetimeToken"]["id"]);
						$user = $this->User->read();
				   		$this->Core->get_alert('パスワードを変更しました。','success');
				   		$url = Router::url('/users/login/', true); 
						$body = $this->Templates->change_password($url);

						$Email = new CakeEmail("default");					
						/* Send Options */
						$Email->to($user['User']['username']); 
						$Email->subject("パスワードの変更完了のお知らせ");
						$Email->emailFormat(Configure::read('EmailOptions.email_format'));  
						$Email->template('default');
						$Email->from( 
						             array( 
						                   Configure::read('EmailOptions.admin_mail') =>
						                   Configure::read('EmailOptions.admin_name')
						              )
						);						
						if($Email->send($body))
						{					
							$this->redirect("/users/login/");
						}  						
					}
							
			}else{
				 $this->Core->get_alert('パスワードを変更に失敗しました。','danger');
			}
			
		}
		
	 }
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) 
	{
		$this->User->id = $id;
		if (!$this->User->exists()) 
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) 
		{
			$this->Core->get_alert('ユーザーを削除しました。','success');
		} else {
				$this->Core->get_alert('ユーザーを削除できませんでした。','danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

}
