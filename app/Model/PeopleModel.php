<?php

namespace App\Model;

class PeopleModel extends BaseModel{
    
    public function allPeople() {
       return $this->database->table('people');
    }
    
    public function allPeopleActive() {
       return $this->database->table('people')->where('active',1);
   }
    
   public function updatePeople($id,$data){
       $select = $this->database->table('people')->where('id',$id)->fetch();
       return $select->update($data);
   } 
    
    public function addPeople($data){
        return $this->database->table('people')->insert($data);
    }
    
    public function peopleById($id){
        return $this->database->table('people')->where('id',$id)->fetch();
    }
    
   public function isEmailExist($email){
     $count = $this->database->table('people')->where('email',$email)->count();
     if($count == 0){
        return FALSE; 
     }else{
         return TRUE;
     }
   }
}