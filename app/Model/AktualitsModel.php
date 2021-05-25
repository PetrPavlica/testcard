<?php

namespace App\Model;

class AktualitsModel extends BaseModel{
    
    public function allAktualits() {
        
        return $this->database->table('aktualits');
        
    }
}