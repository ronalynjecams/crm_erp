<?php
App::uses('AppController', 'Controller');
/**
 * ProdInvLocations Controller
 *
 * @property ProdInvLocation $ProdInvLocation
 * @property PaginatorComponent $Paginator
 */
class ProdInvLocationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ProdInvLocation->recursive = 0;
		$this->set('prodInvLocations', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProdInvLocation->exists($id)) {
			throw new NotFoundException(__('Invalid prod inv location'));
		}
		$options = array('conditions' => array('ProdInvLocation.' . $this->ProdInvLocation->primaryKey => $id));
		$this->set('prodInvLocation', $this->ProdInvLocation->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProdInvLocation->create();
			if ($this->ProdInvLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The prod inv location has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The prod inv location could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$invLocations = $this->ProdInvLocation->InvLocation->find('list');
		$products = $this->ProdInvLocation->Product->find('list');
		$this->set(compact('invLocations', 'products'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ProdInvLocation->exists($id)) {
			throw new NotFoundException(__('Invalid prod inv location'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProdInvLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The prod inv location has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The prod inv location could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('ProdInvLocation.' . $this->ProdInvLocation->primaryKey => $id));
			$this->request->data = $this->ProdInvLocation->find('first', $options);
		}
		$invLocations = $this->ProdInvLocation->InvLocation->find('list');
		$products = $this->ProdInvLocation->Product->find('list');
		$this->set(compact('invLocations', 'products'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ProdInvLocation->id = $id;
		if (!$this->ProdInvLocation->exists()) {
			throw new NotFoundException(__('Invalid prod inv location'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ProdInvLocation->delete()) {
			$this->Session->setFlash(__('The prod inv location has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The prod inv location could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function get_product_location(){
        $this->autoRender = false;
        $this->response->type('json');
            if ($this->request->is('ajax')) {
                $id = $this->request->query['id']; 
                $this->ProdInvLocation->recursive = 2;
                $product_locations = $this->ProdInvLocation->find('all',array(
                    'conditions'=>array('ProdInvLocation.inv_location_id'=>$id)));
                return (json_encode($product_locations));
                exit;
            }
        }
        
        public function get_product_location_property(){
        $this->autoRender = false;
        $this->response->type('json');
            if ($this->request->is('ajax')) {
                $this->loadModel('ProdInvLocationProperty');
                $id = $this->request->query['id']; 
                $this->ProdInvLocationProperty->recursive = 2;
                $product_location_properties = $this->ProdInvLocationProperty->find('all',array(
                    'conditions'=>array('ProdInvLocationProperty.prod_inv_location_id'=>$id)));
                return (json_encode($product_location_properties));
                exit;
            }
            
        }
}