<?php

namespace App\Models{
    
    class Teams{

        private $id;
        private $name;
        private $image;
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

        public function getImage(){
            return $this->image;
        }

        public function setImage($image = ""){
            $this->image = $image;
        }

        public function getPoints(){
            return $this->points;
        }

        public function setPoints($points = ""){
            $this->points = $points;
        }
    }
}