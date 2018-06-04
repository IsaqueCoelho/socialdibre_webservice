<?php

namespace App\Controllers{

    use App\Controllers\Database;
    use App\Models\Users;
    use App\Utility\Contact;
    use App\Utility\Utility;
    use PDO;

    class User{

        private static $db;
        private static $user;

        function __construct(){
            
        }

        public function login($data){
            
            $return_data = "";

            self::$db = Database::conexao();

            self::$user = new Users();

            $sql = "SELECT id_user FROM user WHERE usr_email = ? AND usr_password = ?";
            
            $search = self::$db->prepare($sql);
            $search->execute(array($data['email'], $data['password']));
            $result = $search->fetch(PDO::FETCH_NUM);
            
            self::$user->setId($result[0]);

            if($result > 0){
                $return_data = ["success" => 1, "result" => self::$user->getId(), "message" => "Usuário encontrado!"];
            } else {
                $return_data = ["success" => 0, "result" => "", "message" => "Usuário ou Senha incorreto!"];
            }

            return $return_data;
        }

        public function getAll($page){

            $result_query_data = array();
            $list_users = array();
            $return_data = array();

            $page = ($page == 0) ? 1 : $page;

            $final_page = ($page - 1) * 10;

            self::$db = Database::conexao();

            self::$user = new Users();

            $sql = "SELECT usr.id_user, usr.usr_name, usr.usr_image, usr.usr_points, (SELECT COUNT(DISTINCT usr_points) FROM user WHERE usr_points >= usr.usr_points) AS usr_position, (SELECT COUNT(ptp.id_user) FROM `participates` AS ptp WHERE ptp.id_user = usr.id_user) AS usr_teams FROM `user` AS usr ORDER BY usr.usr_points DESC LIMIT " . $final_page . ", 10";
            
            $search = self::$db->prepare($sql);
            $search->execute();
            $result = $search->fetch(PDO::FETCH_ASSOC);

            if($result > 0){
                do{

                    $result_query_data['id'] = $result['id_user'];
                    $result_query_data['name'] = $result['usr_name'];
                    $result_query_data['image'] = $result['usr_image'];
                    $result_query_data['points'] = $result['usr_points'];
                    $result_query_data['position'] = $result['usr_position'];
                    $result_query_data['teams'] = $result['usr_teams'];

                    array_push($list_users, $result_query_data);

                }while($result = $search->fetch(PDO::FETCH_ASSOC));
            
                $return_data = ["success" => 1, "page" => $page, "result" => $list_users, "message" => "Ranking de usuários!"];
            
            } else {

                $return_data = ["success" => 0, "page" => $page, "result" => "", "message" => "Nenhum usuário encontrado!"];

            }

            return $return_data;

        }

        public function get($id){

            self::$db = Database::conexao();

            $sql = "SELECT usr.id_user, usr.usr_name, usr.usr_image, usr.usr_points, (SELECT COUNT(DISTINCT usr_points) FROM `user` WHERE usr_points >= usr.usr_points) As usr_position, (SELECT COUNT(rtp.id_follower) FROM `relationship` AS rtp WHERE rtp.id_user = usr.id_user) AS usr_followers , (SELECT COUNT(ptp.id_user) FROM `participates` AS ptp WHERE ptp.id_user = usr.id_user) AS usr_teams FROM `user` AS usr WHERE usr.id_user = ?";
            
            $search = self::$db->prepare($sql);
            $search->execute(array($id));
            $result = $search->fetch(PDO::FETCH_ASSOC);

            if($result > 0){

                $user_data = [
                    "id" => $result['id_user'],
                    "name" => $result['usr_name'],
                    "image" => $result['usr_image'],
                    "points" => $result['usr_points'],
                    "position" => $result['usr_position'],
                    "followers" => $result['usr_followers'],
                    "teams" => $result['usr_teams']
                ];
    
                $return_data = ["success" => 1, "result" => $user_data, "message" => "Usuário encontrado!"];

            } else {

                $return_data = ["success" => 0, "result" => "", "message" => "Usuário não encontrado!"];

            }

            return $return_data;
            
        }

        public function create($data){
            
            $return_data = "";
            $user_array = array();

            self::$db = Database::conexao();

            self::$user = new Users();

            $utility = new Utility();

            self::$user->setId($utility->getGUID());
            self::$user->setName($data['name']);
            self::$user->setBirthdate($data['birthdate']);
            self::$user->setEmail($data['email']);
            self::$user->setPassword($data['password']);
            self::$user->setZip($data['zip']);
            self::$user->setImage("default_user.png");            
            self::$user->setType($data['type']);
            self::$user->setPoints(0);

            $zip_valid = $utility->zip_validate(self::$user->getZip());

            if($zip_valid > 1){

                $sql = "SELECT COUNT(*) FROM user WHERE usr_email = ?";
            
                $search = self::$db->prepare($sql);
                $search->execute(array(self::$user->getEmail()));
                $rows = $search->fetch(PDO::FETCH_NUM);

                if($rows[0] == 0){

                    $sql = "INSERT INTO user (id_user, usr_name, usr_birthdate, usr_email, usr_password, usr_zip, usr_image, usr_type, usr_points)
                    VALUE (?,?,?,?,?,?,?,?,?);";
                
                    $register = self::$db->prepare($sql);
                    $register->execute(array(self::$user->getId(),
                                                self::$user->getName(),
                                                self::$user->getBirthdate(),
                                                self::$user->getEmail(),
                                                self::$user->getPassword(),
                                                self::$user->getZip(),
                                                self::$user->getImage(),
                                                self::$user->getType(),
                                                self::$user->getPoints()));
                    
                    $return_data = ["success" => 1, "operation_code" => 0, "result" => self::$user->getId(), "message" => "Usuário Criado!"];

                } else {

                    $return_data = ["success" => 0, "operation_code" => 2, "result" => "", "message" => "Usuário já existe!"];

                }

            } else {
                $return_data = ["success" => 0, "operation_code" => 1, "result" => "", "message" => "Cep inválido!"];
            }

            return $return_data;
        }

        public function update($id){
            
        }

        public function delete($id){
            
        }
    
    }

}