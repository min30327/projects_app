<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

App::uses( 'CakeEmail', 'Network/Email');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

	public $components = array(
		'Acl',
		'RequestHandler',
		'Cookie',
		'Session',
	    'Auth' => array(
	        'authenticate' => array(
	            'Form' => array(
	                'passwordHasher' => 'Blowfish'
	            )
	     ),
	    //ログイン後の移動先
        'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
        //ログアウト後の移動先
        'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
        //ログインページのパス
        'loginAction' => array('controller' => 'users', 'action' => 'login'),
        //未ログイン時のメッセージ
        'authError' => '',
	    ),
	    'Paginator',
	    'Search.Prg' => array(
		        'commonProcess' => array(
		            'paramType' => 'querystring',
		        )
			  ),
	    'Core',
	    'Templates'
	);

	public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'UploadPack.Upload',
        'Core'
    );
	public $uses = array('User');

	public function beforeFilter()
	{
		// ページャ設定  
	    $pager_numbers = array(  
	      'before' => ' - ',  
	      'after'=>' - ',  
	      'modulus'=> 10,  
	      'separator'=> ' ',  
	      'class'=>'pagenumbers'  
	    );  
	  	$this->Paginator->settings['paramType'] = 'querystring';
		/**
		 * Auto logged in by Cookie.
		 */
		if(!$this->Auth->loggedIn())
		{
		    $cookiePassport = $this->Cookie->Read('pass');
		    if(!empty($cookiePassport)&&is_array($cookiePassport))
		    {
		    	if(array_key_exists('Passport',$cookiePassport))
		    	{
		        $cookieUser = $this->User->find('first',
                      array(
                        'conditions'=>array(
   							 'User.passport'=>$cookiePassport['Passport']
							)
						)
					);
			        if(!empty($cookieUser))
			        {
			            $this->Auth->login($cookieUser);
			       	}
		     	}
			  
			}
		
		}else{
			$user = $this->User->findById(AuthComponent::user('id'));
			global $AUTH;
			if(array_key_exists('User', $user)) 
			{
				$AUTH = $user['User'];
			}
		}
	}

}