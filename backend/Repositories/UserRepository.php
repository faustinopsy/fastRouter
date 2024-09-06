<?php

namespace Backend\Api\Repositories;

use Backend\Api\Database\Database;
use Backend\Api\Models\User;
use PDO;

class UserRepository {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }
    public function getUsuarioByEmail($email) {
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createUser(User $usuario) {
        $nome = $usuario->getNome();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);

        return $stmt->execute();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($usuario_id) {
        $query = "SELECT * FROM usuarios WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser(User $usuario) {
        $usuario_id = $usuario->getUsuarioId();
        $nome = $usuario->getNome();
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $query = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":usuario_id", $usuario_id);
    
        return $stmt->execute();
    }
    
    public function deleteUser($usuario_id) {
        $query = "DELETE FROM usuarios WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
}    

