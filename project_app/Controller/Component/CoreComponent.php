<?php
class CoreComponent extends Component{
		
	public $components = array('Session');
	public function initialize(Controller $controller){  
		 //コントローラを変数に格納  
		 $this->controller = $controller;  
	}

	public function errorAlert()
	{
			$response = array('id' => '','message' => 'エラーが発生しました。','class'=>'alert-danger');
			$this->header('Content-Type: application/json');
			echo json_encode($response);
			exit();
	}
	/**
	 * Get alert message for bootstrap alerts.
	 * $this->Session->setFlash($this->Core->get_alert([message],[type])); 
	 * 
	 * @param  [type] $message Your alerts message.
	 * @param  [type] $type    Type of [success,info,warning,danger]
	 * @return [type]          ARRAY
	 */
	public function get_alert($message,$type)
	{
		switch($type){
			case 'success':
				$icon = 'fa-check-circle';
			break;
			case 'danger':
				$icon = 'fa-exclamation-triangle';
			break;
			case 'info':
				$icon = 'fa-info-circle';
			break;
			case 'warning':
				$icon = 'fa-bell-o';
			break;
		}
		$this->Session->setFlash('<i class="fa '. $icon .'"></i> '.h($message) ,
				  'alert', 
			  	 array(
						'plugin' => 'BoostCake',
						'class' => 'alert-'.$type
						)
			);
	}
/**
 * authorデータを生成
 * 
 *
 * @param array User
 * @return array('id','name','src');
 */
		public function createAuthor($user=array()) {
			$arr = array();
			$arr['src'] = Router::url('/', true).'img/user-dummy.png';
			if(array_key_exists('id', $user))
			{
				$arr['id'] = $user['id'];
			}
			if(array_key_exists('name', $user))
			{
				$arr['name'] = $user['name'];
			}
			if(array_key_exists('avatar_file_name', $user))
			{
				if($user['avatar_file_name']!=''){
					App::import('Helper', 'UploadPack.Upload');
					$this->Upload = new UploadHelper(new View(null));
					$arr['src'] = $this->Upload->uploadUrl($user,'User.avatar', array('style' => 'thumb'));
				}
			}
			return $arr;
		} 
/**
 * ワンタイムトークンを生成
 *
 * @param string $form_name
 * @return string $token
 */
		public function generateToken($form_name) {
			
			$token = sha1($form_name . session_id() . microtime() . mt_rand());
			
			return $token;
		}

/**
 * ランダム文字列を生成
 *
 * @param string $form_name
 * @return string $token
 */
		public function random_string($max=10) {
			
			$strinit = "abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ012345679";
			$strarray = preg_split("//", $strinit, 0, PREG_SPLIT_NO_EMPTY); 
				  
				  for ($i = 0, $str = null; $i < $max; $i++) { 
					  $str .= $strarray[array_rand($strarray, 1)]; 
				  } 
			return $str;
		}
} 