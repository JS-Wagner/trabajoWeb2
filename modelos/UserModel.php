<?php
require_once './config.php';
require_once 'Model.php';

class UserModel extends Model
{
    public function getByUsername($username)
    {
        $db = $this->db;
        $query = $db->prepare('SELECT * FROM usuario WHERE username = ?');
        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
