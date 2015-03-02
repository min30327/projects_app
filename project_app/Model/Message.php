<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property User $User
 */
class Message extends AppModel {

	public $order = array('Message.modified DESC');
	public $belongsTo = array('User','Project');
}