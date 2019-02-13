<?php
 Class Friends_model extends CI_Model
 {
     public function add_friend(){
         $data = array(
             "friend_name" => $this->input->post("firstname"),
             "friend_age" => $this->input->post("age"),
             "friend_gender" => $this->input->post("gender"),
             "friend_hobby" => $this->input->post("hobby"),
         );

         if($this->db->insert("friend",$data))
         {
             return $this->db->insert_id();
         }else
         {
             return FALSE;
         }


     }

     public function get_friends()
     {
         $this->db->order_by("created","DESC");
         return $this->db->get("friend");
     }
     public function get_single_friend($friend_id)
     {
         $this->db->where("friend_id",$friend_id);
         return $this->db->get("friend");
     }

     //pagination function
     public function record_count(){
         return $this->db->count_all("friend");
     }

     public function fetch_friend ($limit, $start)
     {
         $this->db->limit($limit, $start);
         $query = $this->db->get("friend");

         if ($query->num_rows() > 0) 
         {
            foreach ($query->result() as $row)
            {
                $data[] = $row;
            }

            return $data;
         }
     }
     //end of pagination

     //edit button
    //  public function edit_friend($friend_id)
    //  {
    //     $update = array(
    //         "friend_name" => $this->input->post("firstname"),
    //          "friend_age" => $this->input->post("age"),
    //          "friend_gender" => $this->input->post("gender"),
    //          "friend_hobby" => $this->input->post("hobby"),
    //         );
    //     $this->db->where('friend_id',$friend_id);
    //     return $this->db->update('friend', $update);
    //  }

    public function update_friend( $friend_id)
{
$data = array (
//how its in db..............how its in form
"friend_name"=>$this->input->post("Name"),
"friend_age"=>$this->input->post("age"),
"friend_gender"=>$this->input->post("gender"),
"friend_hobby"=>$this->input->post("hobby")
);
 
$this->db->set($data);
$this->db->where('friend_id', $friend_id);
if ($this->db->update('friend')) {
# code...
return TRUE;
}else {
# code...
return FALSE;
}
 
//var_dump($data);die();
}
     //end of edit button
     
 }
?>
