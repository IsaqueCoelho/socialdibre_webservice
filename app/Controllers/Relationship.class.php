<?php

namespace App\Controllers{

    use App\Controllers\Database;
    use App\Utility\Utility;
    use PDO;

    class Relationship{

        private static $db;

        function __construct(){ }

        public function getAll($page){ }

        public function get($id, $follower, $page){

            $result_query_data = array();
            $list_users = array();
            $return_data = array();

            $sql_final = ($follower == '1') ? "usr.id_user = rsp.id_follower AND rsp.id_user = ?" : "usr.id_user = rsp.id_user AND rsp.id_follower = ?";

            $page = ($page == 0) ? 1 : $page;

            $final_page = ($page - 1) * 10;

            self::$db = Database::conexao();

            $sql = "SELECT usr.id_user, usr.usr_name, usr.usr_image, usr.usr_points, (SELECT COUNT(DISTINCT usr_points) FROM user WHERE usr_points >= usr.usr_points) AS usr_position, (SELECT COUNT(ptp.id_user) FROM `participates` AS ptp WHERE ptp.id_user = usr.id_user) AS usr_teams FROM `user` AS usr INNER JOIN relationship AS rsp ON " . $sql_final . " ORDER BY rsp.rtp_date DESC LIMIT " . $final_page . ", 10";
            
            $search = self::$db->prepare($sql);
            $search->execute(array($id));
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
            
                $return_data = ["success" => 1, "page" => $page, "result" => $list_users, "message" => "relacionamentos encontrados!"];
            
            } else {

                $return_data = ["success" => 0, "page" => $page, "result" => "", "message" => "Nenhum relacionamento encontrado!"];

            }

            return $return_data;
            
        }

        public function create($data){
            
            /*$return_data = "";
            $return_array = array();

            self::$db = Database::conexao();

            self::$team = new Teams();

            self::$participate = new Participates();

            $utility = new Utility();

            self::$team->setId($utility->getGUID());
            self::$team->setName($data['name']);
            self::$team->setImage($data['image']);
            self::$team->setPoints(0);

            self::$participate->setUser($data['id_user']);
            self::$participate->setTeam(self::$team->getId());
            self::$participate->setCaptain($data['id_user']);

            $return_array = [
                "id_team" => self::$team->getId(),
                "name_team" => self::$team->getName(),
                "image_team" => self::$team->getImage(),
                "points_team" => self::$team->getPoints(),
                "user_participate" => self::$participate->getUser(),
                "team_participate" => self::$participate->getTeam(),
                "captain_participate" => self::$participate->getCaptain(),
            ];
            
            $sql = "SELECT COUNT(*) FROM `team` WHERE UPPER(tm_name) = UPPER(?)";
            
            $search = self::$db->prepare($sql);
            $search->execute(array(strtoupper(self::$team->getName())));
            $rows = $search->fetch(PDO::FETCH_NUM);

            if($rows[0] == 0){

                $sql = "call create_team(?,?,?,?,?,?,?);";

                $register = self::$db->prepare($sql);

                $register->bindValue(1,self::$team->getId(), PDO::PARAM_STR);
                $register->bindValue(2,self::$team->getName(), PDO::PARAM_STR);
                $register->bindValue(3,self::$team->getImage(), PDO::PARAM_STR);
                $register->bindValue(4,self::$team->getPoints(), PDO::PARAM_INT);
                $register->bindValue(5,self::$participate->getUser(), PDO::PARAM_STR);
                $register->bindValue(6,self::$participate->getTeam(), PDO::PARAM_STR);
                $register->bindValue(7,self::$participate->getCaptain(), PDO::PARAM_STR);

                $register->execute();
                
                $return_data = ["success" => 1, "result" => ["id" => self::$team->getId()], "message" => "Time Criado!"];

            } else {

                $return_data = ["success" => 0, "result" => "", "message" => "O Nome do Time já existe!"];

            }

            return $return_data;*/
        }

        public function update($id){
            
        }

        public function delete($id){
            
        }
    
    }

}