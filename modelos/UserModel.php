<?php
require_once './config.php';
class UserModel
{

    function connectToDatabase()
    {
        try {
            $db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
            return $db;
        } catch (PDOException $e) {
            // Manejo de errores, (conexion fallida)
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    public function getByUsername($username)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('SELECT * FROM usuario WHERE username = ?');
        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
