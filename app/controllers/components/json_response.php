<?php
/**
 * CakePHP Json Response Component
 *
 * Copyright 2009 - 2010, Cake Development Corporation
 *                        1785 E. Sahara Avenue, Suite 490-423
 *                        Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2009 - 2010, Cake Development Corporation (http://cakedc.com)
 * @link      http://github.com/CakeDC/Search
 * @package   controllers.components
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class JsonResponseComponent extends Object {

/**
 * Components
 *
 * @var array $components
 */
	public $components = array('RequestHandler', 'Session');

/**
 * Helpers
 *
 * @var array $components
 */
	public $helpers = array();

/**
 * Enabled
 *
 * @var boolean $enabled
 */
	public $enabled = true;

/**
 * Intialize Callback
 *
 * @param object Controller object
 */
	public function initialize(Controller $Controller) {
		$this->Controller = $Controller;
	}

/**
 * beforeRedirect
 * 
 * @return
 */
	public function beforeRedirect(Controller $Controller, $url, $status = null, $exit = true) {
		if ($this->RequestHandler->prefers('json')) {
			$this->set(array('redirect', $url));
			if ($exit) {
				echo $this->Controller->render();
				$this->_stop();
			}
		}
		return $url;
	}

/**
 * Used to check and see if we should respond with the JsonResponseComponent
 *
 * @return boolean True if we should respond 
 */
	public function shouldRespond() {
		if ($this->_extensionIsJson() || $this->_userAgentWantsJson()) {
			return true;
		}
		return false;
	}

/**
 * Used to make set a certain response structure for some json requests
 *
 * This is done to avoid to repeat this check in the code over and over and to
 * set defaults for the json data.
 *
 * If the check for json request was successfully the method returns true,
 * if not false. This can be used to check agains and return; in a controller
 * method to avoid further execution of other code i.e. a redirect.
 *
 * @param array
 * @param boolean
 * @return boolean True on success
 */
	public function set($data = array(), $check = true) {
		if ($this->shouldRespond() || $check == false) {
			$defaults = array(
				'referer' => $this->Controller->referer(),
				'status' => 'success',
				'redirect' => null,
				'message' => $this->Session->read('Message.flash.message'),
				'content' => null
			);

			$this->Session->delete('Message.flash');
			
			if (isset($data['redirect']) && is_array($data['redirect'])) {
				$data['redirect'] = Router::url($data['redirect']);
			}

			$this->Controller->set(array_merge($defaults, $data));
			return true;
		}
		return false;
	}

/**
 * Used to render the correct layout and view for json requests
 *
 * @return 
 * @see Controller::render();
 */
	public function respond($action = null, $layout = null, $file = null) {
		$this->RequestHandler->respondAs('json');
		$this->RequestHandler->renderAs($this->Controller, 'json');
		$this->Controller->layout = 'ajax';
		$this->Controller->render($action, $layout, $file);
	}
/**
 * Detect .json in a URL
 *
 * @return boolean True on success
 */

	protected function _extensionIsJson() {
		if(empty($this->Controller->params['url']['ext'])) return false;
		return $this->Controller->params['url']['ext'] == 'json';
	}

/**
 * Detected if request is from a JSON useragent
 *
 * @return boolean True on success
 */
	protected function _userAgentWantsJson() {
		return $this->RequestHandler->isAjax() && $this->RequestHandler->accepts('json');
	}
}

?>
