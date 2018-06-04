<?php

namespace App\Models{
    
    class Users{

        private $id;
        private $name;
        private $email;
        private $password;
        private $birthdate;
        private $zip;
        private $image;
        private $type;
        private $points;

        public function getId(){
            return $this->id;
        }

        public function setId($id = ""){
            $this->id = $id;
        }

        public function getName(){
            return $this->name;
        }

        public function setName($name = ""){
            $this->name = $name;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email = ""){
            $this->email = $email;
        }

        public function getPassword(){
            return $this->password;
        }

        public function setPassword($password = ""){
            $this->password = $password;
        }

        public function getBirthdate(){
            return $this->birthdate;
        }

        public function setBirthdate($birthdate = ""){
            $this->birthdate = $birthdate;
        }

        public function getZip(){
            return $this->zip;
        }

        public function setZip($zip = ""){
            $this->zip = $zip;
        }

        public function getImage(){
            return $this->image;
        }

        public function setImage($image = ""){
            $this->image = $image;
        }

        public function getType(){
            return $this->type;
        }

        public function setType($type = ""){
            $this->type = $type;
        }

        public function getPoints(){
            return $this->points;
        }

        public function setPoints($points = ""){
            $this->points = $points;
        }
    }
}