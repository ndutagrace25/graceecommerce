<?php
Class Friends extends MX_Controller {

    function __construct()
    {
        parent:: __construct();
        $this->load->model("friends_model");
        $this->load->model("site/site_model");
        $this->load->library("pagination");
    }

    public function index()
    {
         
            $v_data["all_friends"]=$this->friends_model->get_friends();
    
            $data = array("title" =>$this->site_model->display_page_title(),
            "content" =>$this->load->view("friends/all_friends",$v_data, TRUE)
        
        );
            $this->load->view("site/layouts/layout",$data);
            
    
           // $data=array
            //(
             //   "all_friends"=>$this->friends_model->get_friend()
            //);
          //  $this->load->view("hello_world",$data);
    }
    
    public function welcome($friend_id)
    {   
        $my_friend = $this->friends_model->get_single_friend($friend_id);
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

//add friend
public function new_friend(){
    $this->form_validation->set_rules ("firstname","First Name","required");
    $this->form_validation->set_rules ("age","Age","required|numeric");
    $this->form_validation->set_rules ("gender","Gender","required");
    $this->form_validation->set_rules ("hobby","Hobby","required");
    
 if($this->form_validation->run())
       {
         $friend_id = $this->friends_model->add_friend();
          if($friend_id > 0)
          {
              $this->session->set_flashdata("success_message","New friend ID ".$friend_id." has been added");
          }
        
        else{
            $this->session->set_flashdata
            ("error_message", "unable to add friend");
           }
           redirect("friends");
        }

      $data["form_error"]=validation_errors(); 
     
     $this->load->view("add_friend",$data);
    }

    // pagination function
    public function frienddata ()
    {
        $config = array ();
        $config["base_url"] = base_url()."friend/frienddata";
        $config["total_rows"] = $this->friend->record_count();
        $config["per_page"] =5;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->friends_model->fetch_friend($config["per_page"],$page);
        $data["links"] = $this->pagination->create_links();
    }
    // end of pagination

    // edit button
    // public function edited_friend ()
    // {
    //     $this->form_validation->set_rules ("firstname","First Name","trim|required");
    //     $this->form_validation->set_rules ("age","Age","trim|required|numeric");
    //     $this->form_validation->set_rules ("gender","Gender","trim|required");
    //     $this->form_validation->set_rules ("hobby","Hobby","trim|required");

    //     if ($this->form_validation->run() == FALSE)
    //     {
    //         echo "failed to edit friend";
    //     }
    //     else
    //     {
    //         $friend_id = $this->input->post("friend_id");
    //         $this->friends_model->edit_friend($friend_id);
    //         $this->session->set_flashdata("success_message","Friend ID ".$friend_id." has been edited");
    //     }

        
    
    // }
    public function edited_friend($friend_id)
    {
    ///server side validation
    $this->form_validation->set_rules("Name","Name", "required");
    $this->form_validation->set_rules("age","Age", "required|numeric");
    $this->form_validation->set_rules("gender","Gender", "required");
    $this->form_validation->set_rules("hobby","Hobby", "required");
    $validation_errors = "";
    // $friend, $age, $gender, $hobby;
     
    if($this->form_validation->run())
    {
    $update_status = $this->friends_model->update_friend($friend_id);
    if ($update_status) {
    # code...
    redirect("friends");
    }
    }
    else
    {
    //name from form is the unique identifier
    $my_friend = $this->friends_model->get_single_friend($friend_id);
    // var_dump($my_friend); die();
    if ($my_friend->num_rows() > 0) {
    $row = $my_friend->row();
    $friend = $row->friend_name;
    $age = $row->friend_age;
    $gender = $row->friend_gender;
    $hobby = $row->friend_hobby;
     
    $v_data["friend_name"] = $friend;
    $v_data["friend_age"] = $age;
    $v_data["friend_id"] = $friend_id;
    $v_data["friend_gender"] = $gender;
    $v_data["friend_hobby"] = $hobby;
    $data = array("title" => $this->site_model->display_page_title(),
    "content" => $this->load->view("friends/edit_friend", $v_data, true));
    // $data = array(
    // // "all_friends"=>$this->friend_model->get_friends()
    // );
    $this->load->view("site/templates/layouts/layout", $data);
     
    } else {
    $this->session->set_flashdata("error_message", "couldnt");
    redirect("friends");
    }
    }
    }

    // end of edit button
    
}
?>
