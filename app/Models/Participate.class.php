<?php

namespace App\Models{
    
    class Participates{

        private $user;
        private $team;
        private $captain;

        public function getUser(){
            return $this->user;
        }

        public function setUser($user = ""){
            $this->user = $user;
        }

        public function getTeam(){
            return $this->team;
        }

        public function setTeam($team = ""){
            $this->team = $team;
        }

        public function getCaptain(){
            return $this->captain;
        }

        public function setCaptain($captain = ""){
            $this->captain = $captain;
        }
    }
}