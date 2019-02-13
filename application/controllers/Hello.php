<?php
class Hello extends CI_Controller {

    function __construct()
    {
        parent:: __construct();
        $this->load->model("friend_model");
    }

    public function index()
    {
        $data=array
        (
            "all_friends"=>$this->friend_model->get_friend()
        );
        $this->load->view("hello_world",$data);
    }
    public function welcome($friend_id)
    {   
        $my_friend = $this->friend_model->get_single_friend($friend_id);
        if($my_friend->num_rows()>0)
        {
            $row = $my_friend->row();
            $friend = $row->friend_name;
            $age = $row->friend_age;
            $gender = $row->friend_gender;
            $hobby = $row->friend_hobby;

        
       //form validation

      // $this->form_validation->set_rules
       //("firstname","First Name","required");
       //$this->form_validation->set_rules
      // ("age","Age","required|numeric");
      // $this->form_validation->set_rules
      // ("gender","Gender","required");
      // $this->form_validation->set_rules
       //("hobby","Hobby","required");


      // if($this->form_validation->run())
      // {
         // $friend = $this->input->post("firstname");
         // $age = $this->input->post("age");
         // $gender = $this->input->post("gender");
        //  $hobby = $this->input->post("hobby");

        //}else{
       //    $validation_errors = validation_errors();

      // }
       
     $data = array(
         "friend_name"=> $friend,
         "friend_age"=>$age,
         "friend_gender"=>$gender,
         "friend_hobby"=>$hobby,

     );

        $this->load->view("welcome_here", $data); 
    }else{
        $this->session->set_flashdata("error_message","could not find your friend");
        redirect("hello");

    } 
}
//form validation
//set rules method is used to validate data it takes 3 parameters exact name of field,human name for field,validation rules for the form
public function new_friend(){
    $this->form_validation->set_rules ("firstname","First Name","required");
    $this->form_validation->set_rules ("age","Age","required|numeric");
    $this->form_validation->set_rules ("gender","Gender","required");
    $this->form_validation->set_rules ("hobby","Hobby","required");
   //run returns true only if all validation rules have been applied successfully otherwise return false 
 if($this->form_validation->run())
       {
         $friend_id = $this->friend_model->add_friend();
          if($friend_id >0)
          {
              $this->session->set_flashdata("success_message","New friend ID ".$friend_id." has been added");
          }
        
        else{
            $this->session->set_flashdata
            ("error_message", "unable to add friend");
           }
           redirect("hello");
        }

      $data["form_error"]=validation_errors(); 
     
     $this->load->view("add_friend",$data);
    }
    }
?>
