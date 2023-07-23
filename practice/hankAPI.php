<?php
class Member {
    private $id, $account, $realname, $photo;
    public function __construct($id, $account, $realname,$photo){
        $this->id = $id;
        $this->account = $account;
        $this->realname = $realname;
        $this->photo = $photo;
    }
    public function __get($id){
        // xxx->id
        return $this->id;
    }

    public function getId(){
        // xxx->getId()
        return $this->id;
    }
}
?>
