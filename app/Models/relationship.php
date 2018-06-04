<?php

namespace App\Models{
    
    class Relationships{

        private $user;
        private $follower;
        private $date;

        public function getUser(){
            return $this->user;
        }

        public function setUser($user = ""){
            $this->user = $user;
        }

        public function getFollower(){
            return $this->follower;
        }

        public function setFollower($follower = ""){
            $this->follower = $follower;
        }

        public function getDate(){
            return $this->date;
        }

        public function setDate($date = ""){
            $this->date = $date;
        }
    }
}