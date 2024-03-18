<?php

class CrudAjax extends CI_Model
{
    public function get_records($table){
        $result = $this->db->get($table)->result();
        return $result;
    }

    function get_post_details($table,$id)  {

        return $this->db->where('id',$id)->get($table)->result();
        
    }

    public function insert($table, $data) {
        $result = $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    public function update($table,$id,$data) {
        return $this->db->where('id',$id)->update($table,$data);
        
    }

    public function delete($table,$id) {
        return $this->db->where('id',$id)->delete($table);
        
    }

}