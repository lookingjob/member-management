<?php

namespace App\Controllers {

	class OccupationController extends \App\Handling\Controller {

		public function __construct() {
			
			parent::__construct();	
		}
		
		public function create($data) {
			
			$occupation = new \App\Entities\Occupation();
			           
			$result = $occupation->insert(array(
				'name' => $this->request->post('firstname'),
			));	
				 
			$this->response->sendJSON([
				'result' => $result,
			]);
		}
		
		public function read() {
        	
        	$occupation = new \App\Entities\Occupation();
        	       
			if (!empty($this->request->post('occupation_id'))) {

				$result = $occupation->select(array(
					'where' => array(
						'occupation_id' => (int)$this->request->post('occupation_id'),
					)
				));

			} else {
	            
				$result = $occupation->select(array(
					'where' => array(
						'1' => 1,
					)
				));
			} 
			
			$this->response->sendJSON([
				'result' => $result,
			]);	
		}
		
		public function update() {
		
			if (!empty($this->request->post('occupation_id'))) {
				$occupation = new \App\Entities\Occupation();	
				
				$occupation_id = (int)$this->request->post('occupation_id');
				       
				$result = $occupation->update(array(					
						'name' => $this->request->post('name'),
					),
					array(
						'occupation_id' => $occupation_id,
					)
				);
				
				$result = $occupation->select(array(
					'where' => array(
						'occupation_id' => $occupation_id,
					)
				));
				    
				$this->response->sendJSON([
					'result' => $result,
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong occupation id',
				]);	
			}	
		}
		
		public function delete() {
		
			if (!empty($this->request->post('occupation_id'))) {
				$occupation = new \App\Entities\Occupation();	
				       
				$result = $occupation->delete(array(
					'where' => array(
						'occupation_id' => (int)$this->request->post('occupation_id'),
					)
				));
				
				$this->response->sendJSON([
					'result' => 'success',
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong occupation id',
				]);	
			}
		}
	}
}

?>