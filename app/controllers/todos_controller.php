<?php
class TodosController extends AppController {

	var $name = 'Todos';
	
	var $components = array('RequestHandler');

	function index() {
		$this->Todo->recursive = 0;
		$this->set('todos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid todo', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('todo', $this->Todo->read(null, $id));
	}

	function add() {
		if($this->RequestHandler->isAjax()){
			Configure::write('debug', 0);
			$this->autoRender = false;
			header('Content-Type: application/json');
			$this->Todo->create();
			if($this->Todo->save($this->data)){
				$todo = $this->Todo->findById($this->Todo->getLastInsertId());
				echo json_encode($todo);
			}
		}
		else{
			if (!empty($this->data)) {
				$this->Todo->create();
				if ($this->Todo->save($this->data)) {
					$this->Session->setFlash(__('The todo has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The todo could not be saved. Please, try again.', true));
				}
			}
		}
	}

	function edit($id = null) {
		if($this->RequestHandler->isAjax()){
			Configure::write('debug', 0);
			$this->autoRender = false;
			header('Content-Type: application/json');
			if($this->Todo->save($this->data)){
				echo json_encode(array('success' => 'true', 'data' => $this->Todo->findById($id)));
			}
			else{
				echo json_encode(array('success' => 'false'));
			}
		}
		else{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid todo', true));
				$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->Todo->save($this->data)) {
					$this->Session->setFlash(__('The todo has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The todo could not be saved. Please, try again.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Todo->read(null, $id);
			}
		}
	}
	
	function mark($id = null) {
		if($this->RequestHandler->isAjax()){
			Configure::write('debug', 0);
			$this->autoRender = false;
			header('Content-Type: application/json');
			$todo = $this->Todo->findById(substr($id, 5));
			$todo['Todo']['done'] = false;
			if(!empty($this->data['todo'])){
				$todo['Todo']['done'] = true;
			}
			$this->Todo->save($todo);
			echo json_encode($todo);
		}
	}

	function delete($id = null) {
		if($this->RequestHandler->isAjax()){
			Configure::write('debug', 0);
			$this->autoRender = false;
			header('Content-Type: application/json');
			if($this->Todo->delete($id)){
				echo json_encode(array("success" => true));
			}
			else{
				echo json_encode(array("success" => false));
			}
		}
		else{
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for todo', true));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->Todo->delete($id)) {
				$this->Session->setFlash(__('Todo deleted', true));
				$this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash(__('Todo was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}
}
