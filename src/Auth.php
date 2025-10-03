<?php

class Auth{

    public function isLoggedIn(){
        return isset($_SESSION['id_usuario']);
    }

    public function loginUser($user){
        $_SESSION ['id_usuario'] = $user['id_usuario'];
        $_SESSION ['nome'] = $user['nome'];
        $_SESSION['perfil'] = $user['perfil'];

    }

    public function logout(){
        session_destroy();
        header("Location: index.php");
    }

}

?>