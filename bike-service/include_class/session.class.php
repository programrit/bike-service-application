<?php

// session class
class Session{

    private function start(){
        session_start();
    }
    private  function unset(){
        session_unset();
    }
    private function destroy(){
        session_destroy();
    }
    private function set($key, $value){
        $_SESSION[$key]=$value;
    }
    private function delete($key){
        unset($_SESSION[$key]);
    }
    private function isset($key){
        return isset($_SESSION[$key]);
    }
    private function get($key, $default=false){
        if($this->isset($key)){
            return $_SESSION[$key];
        }else{
            return $default;
        }
    }


    public function start_access(){
        return $this->start();
    }
    public function unset_access(){
        return $this->unset();
    }
    public function destroy_access(){
        return $this->destroy();
    }
    public function set_access($key,$value){
        return $this->set($key,$value);
    }
    public function delete_access($key){
        return $this->delete($key);
    }
    public function isset_access($key){
        return $this->isset($key);
    }
    public function get_access($key){
        return $this->get($key);
    }
}




