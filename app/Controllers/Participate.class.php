<?php

namespace App\Controllers{

    use App\Controllers\Database;
    use App\Models\Teams;
    use App\Models\Participates;
    use App\Utility\Utility;
    use PDO;

    class Participate{

        private static $db;
        private static $team;
        private static $participate;

        function __construct(){
            
        }

        public function getAll($page){ }

        public function get($id){

            $result_query_data = array();
            $list_teams = array();
            $return_data = array();

            self::$db = Database::conexao();

            $sql = "SELECT tm.id_team, tm.tm_name, tm.tm_image, tm.tm_points, (SELECT COUNT(DISTINCT tm_points) FROM `team` WHERE tm_points >= tm.tm_points) As tm_position, (SELECT COUNT(ppt.id_user) FROM `participates` AS ppt WHERE ppt.id_team = tm.id_team) AS usr_players, (SELECT COUNT(clg.id_challenge) FROM `challenge` AS clg WHERE (clg.id_challenger = tm.id_team OR clg.id_challenged = tm.id_team) AND clg.clg_status = '1' ) AS tm_challenges FROM `team` AS tm INNER JOIN participates AS ppt ON tm.id_team = ppt.id_team AND ppt.id_user = ? ORDER BY tm_points DESC";
            
            $search = self::$db->prepare($sql);
            $search->execute(array($id));
            $result = $search->fetch(PDO::FETCH_ASSOC);

            if($result > 0){
                do{

                    $result_query_data['id'] = $result['id_team'];
                    $result_query_data['name'] = $result['tm_name'];
                    $result_query_data['image'] = $result['tm_image'];
                    $result_query_data['points'] = $result['tm_points'];
                    $result_query_data['position'] = $result['tm_position'];
                    $result_query_data['players'] = $result['usr_players'];

                    array_push($list_teams, $result_query_data);

                }while($result = $search->fetch(PDO::FETCH_ASSOC));
            
                $return_data = ["success" => 1, "result" => $list_teams, "message" => "Lista de Times que participa!"];
            
            } else {

                $return_data = ["success" => 0, "result" => "", "message" => "Nenhum Time encontrado para usuário solicitado!"];

            }

            return $return_data;
            
        }

        public function create($data){
            
            $return_data = "";
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

            return $return_data;
        }

        public function update($data){
            
        }

        public function delete($id){
            
        }
    
    }

}