<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property User $User
 */
class Project extends AppModel {

	public $order = array('modified DESC');
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	/**
	 * [$hasMany description]
	 * @var array
	 */
	public $hasMany = array(
                    	'Message'=>array(
							'order' => array(
								'modified' => 'DESC',
								)
	                         ),
	                  	'Schedule'=>array(
							'order' => array(
								'modified' => 'DESC',
								)
	                         )
	                    );
}