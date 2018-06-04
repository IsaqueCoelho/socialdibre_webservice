<?php

namespace App\Utility{

    class Utility
    {

        public function __construct(){

        }

        public function objtoarray(){
            
        }

        public function getGUID(){
            
            if (function_exists('com_create_guid')){
                
                return com_create_guid();
            
            }else{
                
                mt_srand((double)microtime()*10000); //optional for php 4.2.0 and up.
                
                $charid = strtoupper(md5(uniqid(rand(), true)));
                
                $uuid = substr($charid, 0, 8)
                    .substr($charid, 8, 4)
                    .substr($charid,12, 4)
                    .substr($charid,16, 4)
                    .substr($charid,20,12);
                
                return $uuid;

            }

        }

        public function zip_validate($zip_number){
        
            $result;

            $zip_result = (array) json_decode(file_get_contents("https://viacep.com.br/ws/" . $zip_number . "/json/"));

            return count($zip_result);

        }
        
    }    

}