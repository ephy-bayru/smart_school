<?php
/**
 * Created by PhpStorm.
 * User: raju
 * Date: 1/8/18
 * Time: 11:56 AM
 */


class Students extends API  {


        function __construct($config = 'rest') {
            parent::__construct($config);
            $this->load->model('students_model');
        }

    public function index_get($id = NULL) {
        
        $result['result'] = $this->students_model->get_students($id);
            if(count($result)>0)  {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];              
                $result['columns']=array_keys((array)$first_record);
            }
        $this->response($result,API::HTTP_OK);
    
    }
    // Handels both update or insert request based on the wether id parameter is set 
    public function index_post($id = NULL) {

        $this->load->library("form_validation");
        $result['success'] = false;

        $this->form_validation->set_rules("full_name", "Full Name", "required");
        $this->form_validation->set_rules("gender", "Gender", "required");
        
          if($this->form_validation->run() === FALSE) {
                $this->response($this->validation_errors(), API::HTTP_OK);
          } else {
                $data = array(
                    'id' => $id, 
                    'full_name' => $this->input->post('full_name'),
                    'gender' => $this->input->post('gender'),
                    'blood_group' => $this->input->post('blood_group'),
                    'birthdate' => $this->input->post('birthdate'),
                    
                );
            $result['success'] = ($this->students_model->save_student($this->input->post(), $id)) ? true : false;
            $this->response($result, API::HTTP_OK);
          }      

    }

    public function index_delete($id) {        
        $result['sucess'] = ($this->students_model->delete_student($id)) ? true: false;
        $this->response($result, API::HTTP_OK);
    }
    
    


}
