<?php

class User{

    private $conn;

    public function __construct($db)
    {
        $this -> conn = $db;
    }

    public function register($nome, $email, $password, $perfil, $cpf, $nascimento, $endereco, $contato){
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "insert into usuario (nome, email, senha, perfil, CPF, data_nascimento, endereco, contato) VALUES (:nome, :email, :password, :perfil, :cpf, :nascimento, :endereco, :contato)";

        $stmt = $this -> conn->prepare($sql);

        $stmt -> bindParam(':nome',$nome);
        $stmt -> bindParam(':email',$email);
        $stmt -> bindParam(':password',$hash);
        $stmt -> bindParam(':perfil',$perfil);
        $stmt -> bindParam(':cpf',$cpf);
        $stmt -> bindParam(':nascimento',$nascimento);
        $stmt -> bindParam(':endereco',$endereco);
        $stmt -> bindParam(':contato',$contato);

        return $stmt -> execute();
    }

    public function login($email, $password){
        $sql = "SELECT * FROM usuario WHERE email = :email";


        $stmt = $this -> conn->prepare($sql);
        $stmt -> bindParam(':email',$email);
        $stmt -> execute();

        $user = $stmt -> fetch(PDO::FETCH_ASSOC);

        if($user && (password_verify($password,$user['senha']) || $password === $user['senha'])){
            return $user;
        }
        return false;
    }


    public function getUserById($userId){

        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this -> conn->prepare($sql);
        $stmt -> bindParam(':id', $userId);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);
    }
}
?>