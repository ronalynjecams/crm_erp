<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $uses = ['User', 'Role', 'Position', 'Department', 'Team','AgentStatus'];
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
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
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => '/index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
                
		$positions = $this->Position->find('list');
		$departments = $this->Department->find('list');
		$this->set(compact('departments', 'positions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	
	public function login() { 
		if($this->Auth->user('id')) {
//			$this->redirect('/users/dashboard'); 
                            if($this->Auth->user('role') == 'sales_executive'){
                                return $this->redirect('/users/dashboard_sales');
                            }else if($this->Auth->user('role') == 'marketing_staff'){
                                return $this->redirect('/users/dashboard_marketing');
                            }else if($this->Auth->user('role') == 'super_admin'){
                                return $this->redirect('/users/dashboard_super_admin');
                            }else if($this->Auth->user('role') == 'it_staff'){
                                return $this->redirect('/users/dashboard_it_staff');
                            }else if($this->Auth->user('role') == 'design_head'){
                                return $this->redirect('/users/dashboard_design_head');
                            }else if($this->Auth->user('role') == 'designer'){
                                return $this->redirect('/users/dashboard_designer');
                            }else if($this->Auth->user('role') == 'supply_staff'){
                                return $this->redirect('/users/dashboard_supply');
                            }
                            
		}
	    
	    if ($this->request->is('post')) {
		        if ($this->Auth->login()) {
                             
                            if($this->Auth->user('role') == 'sales_executive'){
                                return $this->redirect('/users/dashboard_sales');
                            }else if($this->Auth->user('role') == 'marketing_staff'){
                                return $this->redirect('/users/dashboard_marketing');
                            }else if($this->Auth->user('role') == 'super_admin'){
                                return $this->redirect('/users/dashboard_super_admin');
                            }else if($this->Auth->user('role') == 'design_head'){
                                return $this->redirect('/users/dashboard_design_head');
                            }else if($this->Auth->user('role') == 'designer'){
                                return $this->redirect('/users/dashboard_designer');
                            }else if($this->Auth->user('role') == 'supply_staff'){
                                return $this->redirect('/users/dashboard_supply');
                            }
		        } 
	    	
	        $this->Session->setFlash(__('Invalid username or password, try again'));
	    }
	}
	
	public function logout() {
	    return $this->redirect($this->Auth->logout()); 
	}	
        
        public function dashboard(){
            
		 
        }
        
        public function dashboard_sales(){
         
            
        }
        
        public function demo_icons(){
            
        }
}
