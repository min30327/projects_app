<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Role $Role
 */
class User extends AppModel {
	
	public $actsAs = array(
           // 'Acl' => 'requester',
           'UploadPack.Upload' => array(
                'avatar' =>array(
                          'quality' => 95,
                          'styles'=>array(
                          'thumb' => '80x80',
                          'mid'=> '200x200',
                          )
                     ),
           		'cover' =>array(
                          'quality' => 95,
                          'styles'=>array(
                          'thumb' => '150x70',
                          'original' => '1400x400',
                          )
                     )
           		)
           	);
           

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'メールアドレスを入力して下さい。',
				'last' => true
			),
			'unique' =>array(
				'rule'=>'isUnique',
				'message'=>'このユーザーはすでに使用されています。'
				)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
			'alphaNumeric' => array(
				  "rule"=>"alphaNumeric",
				  "message"=>"半角英数字で入力してください。",
			      'last'=>true
			),
			'length'=>array(
					"rule"=>array(
							"between",6,50
							),
					"message"=>"6文字以上の半角英数字で入力してください。"
			)
		),
		'avatar' => array(
				'maxSize' => array(
					'rule' => array('attachmentMaxSize', 8388608),
					'message' => '最大サイズは8MBまでです。'
				),
				'file_type'=>array(
				    'rule' => array('attachmentContentType', array('/^image\/.+/')),
				    'message' => '画像以外はアップロードできません。'
				  ),
		),
		'cover' => array(
				'maxSize' => array(
					'rule' => array('attachmentMaxSize', 8388608),
					'message' => '最大サイズは8MBまでです。'
				),
				'file_type'=>array(
				    'rule' => array('attachmentContentType', array('/^image\/.+/')),
				    'message' => '画像以外はアップロードできません。'
				  ),
			)
	);

	// public function parentNode()
	//   {
	//      if(!$this->id && empty($this->data))
	//      {
	//         return null;
	//      }
	//      if(isset($this->data['User']['role_id']))
	//      {
	//         $roleId = $this->data['User']['role_id'];
	//      } else {
	//         $roleId = $this->field('role_id');
	//      }

	//      if(!$roleId)
	//      {
	//         return null;
	//      } else {
	// 		return array('Role' => array('id' => $roleId));
	//      }
	//   }

	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	public function beforeSave($options = array())
 	{
  
   if(isset($this->data[$this->alias]['password'])) 
   {
	    $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'blowfish');
		 }
    return true;
 	}
}

 