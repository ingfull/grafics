<?php

    class DatabaseConnection{
        private $connection;
        private $configuration;

        public function __construct($configuration){
            $this->configuration = $configuration;
            
        }

        public function getConnection(){
            if($this->connection === NULL){
                
                $this->connection = new PDO($this->configuration->getSourceString(), $this->configuration->getUser(), $this->configuration->getPass());
            }

            return $this->connection;
            
        }
    }