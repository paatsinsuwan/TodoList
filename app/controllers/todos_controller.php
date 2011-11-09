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
		if($this->JsonResponse->shouldRespond()){
			if (!empty($this->data)) {
				$this->Todo->create();
				if ($this->Todo->save($this->data)) {
					$this->JsonResponse->set(array(
						'message' => __('The todo has been saved', true),
						'data' => $this->Todo->findById($this->Todo->getLastInsertId())
					));
				} else {
					$this->JsonResponse->set(array(
						'message' => __('The todo could not be saved. Please, try again.', true),
						'status' => 'error',
					));
				}
				$this->JsonResponse->respond();
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
		if($this->JsonResponse->shouldRespond()){
			if(!$id && empty($this->data)){
				$this->JsonResponse->set(array(
					'message' => __('invalid todo', true),
					'status' => 'error',
				));
				$this->JsonResponse->respond();
			}
			if(!empty($this->data)){
				if($this->Todo->save($this->data)){
					$this->JsonResponse->set(array(
						'message' => __('The todo has been saved', true),
						'data' => $this->Todo->findById($id),
					));
				}
				else{
					$this->JsonResponse->set(array(
						'message' => __('The todo could not be saved. Please, try again.', true),
						'status' => 'error',
					));
				}
				$this->JsonResponse->respond();
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
		if($this->JsonResponse->shouldRespond()){
			$todo = $this->Todo->findById(substr($id, 5));
			$todo['Todo']['done'] = false;
			if(!empty($this->data['todo'])){
				$todo['Todo']['done'] = true;
			}
			if($this->Todo->save($todo)){
				$this->JsonResponse->set(array(
					'message' => __('The record is marked.', true),
					'data' => $todo,
				));
			}
			else{
				$this->JsonResponse->set(array(
					'status' => 'error',
					'message' => __('The record is not marked.', true),
				));
			}
			$this->JsonResponse->respond();
		}
	}

	function delete($id = null) {
		if($this->JsonResponse->shouldRespond()){
			if($this->Todo->delete($id)){
				$this->JsonResponse->set(array(
					'message' => __('The record is deleted.', true),
				));
			}
			else{
				$this->JsonResponse->set(array(
					'status' => 'error',
					'message' => __('The record is not deleted.', true),
				));
			}
			$this->JsonResponse->respond();
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
