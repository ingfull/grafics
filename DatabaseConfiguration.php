<?php
    class DatabaseConfiguration{
        private $host = 'localhost';
        private $user = 'root';
        private $pass = '';
        private $db_name = 'ibis';
       
        private $port = '3306';


        public function __construct(){}
     /*
        public function __construct($host, $user, $pass, $db_name, $port){
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->db_name = $db_name;
            $this->port = $port;
        }*/

        public function getSourceString(){
            return "mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->db_name.";charset=utf8";
        }

        public function getUser(){
            return $this->user;
        }

        public function getPass(){
            return $this->pass;
        }
    }

?>