<?php

namespace App\Controllers {

	class MemberController extends \App\Handling\Controller {

		public function __construct() {
			
			parent::__construct();	
		}
		
		public function create($data) {
			
			$member = new \App\Entities\Member();
			           
			$member_id = $member->insert(array(
				'firstname' => $this->request->post('firstname'),
				'lastname' => $this->request->post('lastname'),
				'occupation_id' => $this->request->post('occupation'),
			));	
			    
			$result = $member->select(array(
				'where' => array(
					'member_id' => (int)$member_id,
				)
			));
			
			$occupation = new \App\Entities\Occupation(); 					
			$references = $occupation->select(array(
				'where' => array(
					'occupation_id' => $this->request->post('occupation'),
				)
			));
				
			foreach($result as &$member) {
				foreach($references as $reference) {
					if ($reference['occupation_id'] == $member['occupation_id']) {
						$member['occupation'] = $reference['name'];
					}
				}
			}
				 
			$this->response->sendJSON([
				'result' => $result,
			]);
		}
		
		public function read() {
        	       
        	$member = new \App\Entities\Member();
        	
			if (!empty($this->request->post('member_id'))) {

				$result = $member->select(array(
					'where' => array(
						'member_id' => (int)$this->request->post('member_id'),
					)
				));
				
				$member = new \App\Entities\Member(); 					
				$result = $member->select(array(
					'where' => array(
						'member_id' => (int)$this->request->post('member_id'),
					)
				));
				
			} else {
	               
				$result = $member->select(array(
					'where' => array(
						'1' => 1,
					)
				));
			}
			
			$occupation_ids = array();
			foreach($result as $member) {
				$occupation_ids[] = $member['occupation_id'];
			}
			
			$occupation = new \App\Entities\Occupation(); 					
			$references = $occupation->select(array(
				'where' => array(
					'occupation_id' => $occupation_ids,
				)
			));
				
			foreach($result as &$member) {
				foreach($references as $reference) {
					if ($reference['occupation_id'] == $member['occupation_id']) {
						$member['occupation'] = $reference['name'];
					}
				}
			}
				
			$this->response->sendJSON([
				'result' => $result,
			]); 	
		}
		
		public function update() {
		
			if (!empty($this->request->post('member_id'))) {
				$member = new \App\Entities\Member();	
				       
				$result = $member->update(array(					
						'firstname' => $this->request->post('firstname'),
						'lastname' => $this->request->post('lastname'),
						'occupation_id' => $this->request->post('occupation'),
					),
					array(
						'member_id' => (int)$this->request->post('member_id'),
					)
				);
				
				$member = new \App\Entities\Member(); 					
				$result = $member->select(array(
					'where' => array(
						'member_id' => (int)$this->request->post('member_id'),
					)
				));
				
				$occupation = new \App\Entities\Occupation(); 					
				$references = $occupation->select(array(
					'where' => array(
						'occupation_id' => $this->request->post('occupation'),
					)
				));
				    
				foreach($result as &$member) {
					foreach($references as $reference) {
						if ($reference['occupation_id'] == $member['occupation_id']) {
							$member['occupation'] = $reference['name'];
							unset($member['occupation_id']);
						}
					}
				}
				   
				$this->response->sendJSON([
					'result' => $result,
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong member id',
				]);	
			}	
		}
		
		public function delete() {
		
			if (!empty($this->request->post('member_id'))) {
				$member = new \App\Entities\Member();	
				       
				$result = $member->delete(array(
					'where' => array(
						'member_id' => (int)$this->request->post('member_id'),
					)
				));
				
				$this->response->sendJSON([
					'result' => 'success',
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong member id',
				]);	
			}
		}
	}
}

?>