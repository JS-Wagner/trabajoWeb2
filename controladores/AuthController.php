<?php
require_once './modelos/UserModel.php';
require_once './vistas/LogInView.php';
require_once './helpers/AuthHelper.php';

class AuthController
{
    private $view;
    private $model;

    function __construct()
    {
        $this->view = new LogInView();
        $this->model = new UserModel();
    }

    public function showLogin()
    {
        $this->view->showLogin();
    }

    public function auth()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            return;
        }

        // Buscar el usuario por nombre de usuario
        $user = $this->model->getByUsername($username);
        if ($user) {
            // Verificar la contraseña utilizando password_verify
            if (password_verify($password, $user->password)) {
                // La contraseña es válida, usuario autenticado
                AuthHelper::login($user);
                header('Location: ' . BASE_URL);
            } else {
                // La contraseña no es válida
                $this->view->showLogin('Contraseña incorrecta');
            }
        } else {
            // El usuario no existe
            $this->view->showLogin('Usuario no encontrado');
        }
    }

    public function logout()
    {
        AuthHelper::init();

        if (isset($_SESSION['USER_ID'])) {
            // El usuario está autenticado, procede con la desconexión
            AuthHelper::logout();
        }

        header('Location: ' . BASE_URL);
    }
}
