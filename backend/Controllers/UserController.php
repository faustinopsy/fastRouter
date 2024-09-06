<?php

namespace Backend\Api\Controllers;

use Backend\Api\Models\User;
use Backend\Api\Repositories\UserRepository;

class UserController {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function getAllUsers() {
        $users = $this->userRepository->getAllUsers();
        http_response_code(200);
        echo json_encode($users);
    }

    public function getUserById($id) {
        $user = $this->userRepository->getUserById($id);
        if ($user) {
            http_response_code(200);
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['status' => false, 'message' => 'Usuário não encontrado']);
        }
    }

    public function createUser() {
        $input = json_decode(file_get_contents('php://input'), true);
        if($this->userRepository->getUsuarioByEmail($input['email'])){
            echo json_encode(['status' => false, 'message' => 'Usuário já existe']);
            exit;
        }
        $user = new User();
        $user->setNome($input['nome']);
        $user->setEmail($input['email']);
        $user->setSenha($input['senha']);
        $createdUser = $this->userRepository->createUser($user);
       if($createdUser){
        http_response_code(201);
        echo json_encode(['status' => true, 'message' => 'Usuário criado']);
       }
        
    }

    public function updateUser($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        if($this->userRepository->getUsuarioByEmail($input['email'])){
            echo json_encode(['status' => false, 'message' => 'existe uma restrição, e-mail único']);
            exit;
        }
        $userid = $this->userRepository->getUserById($id);
        if ($userid) {
            $user = new User();
            $user->setUsuarioId($id ?? $user->getUsuarioId());
            $user->setNome($input['nome'] ?? $user->getNome());
            $user->setEmail($input['email'] ?? $user->getEmail());
            $user->setSenha($input['senha'] ?? $user->getSenha());
            
            $updatedUser = $this->userRepository->updateUser($user);
            if($updatedUser){
                http_response_code(200);
                echo json_encode(['status' => true, 'message' => 'Usuário atualizado']);
            }
            
        } else {
            http_response_code(404);
            echo json_encode(['status' => false, 'message' => 'Usuário não encontrado']);
        }
    }

    public function deleteUser($id) {
        if ($this->userRepository->deleteUser($id)) {
            http_response_code(200);
            echo json_encode(['status' => true, 'message' => 'Usuário excluído']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => false, 'message' => 'Usuário não encontrado']);
        }
    }
}
