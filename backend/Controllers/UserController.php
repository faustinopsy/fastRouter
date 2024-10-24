<?php

namespace Backend\Api\Controllers;

use Backend\Api\Models\User;
use Backend\Api\Repositories\UserRepository;
use Backend\Api\Rotas\Router;

class UserController {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }
    #[Router('/users/email/{email:.+}', methods: ['GET'])]
    public function getUserByEmail($email) {
        $user = $this->userRepository->getUsuarioByEmail($email);
        if ($user) {
            http_response_code(200);
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['status' => false, 'message' => 'Usuário não encontrado']);
        }
    }

        /*Regex Usada: /\{([a-zA-Z0-9_]+)(?::([^}]+))?\}/

        \{ e \}: Corresponde às chaves que delimitam o parâmetro.
        ([a-zA-Z0-9_]+): Captura o nome do parâmetro.
        (?::([^}]+))?: Opcionalmente captura a regex personalizada após o :.
        ([^}]+): Captura qualquer caractere que não seja }.
        */
    #[Router('/users/data/{dataini:\d{4}-\d{2}-\d{2}}/{datafim:\d{4}-\d{2}-\d{2}}', methods: ['GET'])]
    public function getUsersByDateRange($dataini, $datafim) {
        http_response_code(200);
            echo json_encode(['data inicial'=> $dataini, 'dataFinal'=>$datafim]);
    }
    #[Router('/users', methods: ['GET'])]
    public function getAllUsers() {
        $users = $this->userRepository->getAllUsers();
        http_response_code(200);
        echo json_encode($users);
    }
    #[Router('/users/{id}', methods: ['GET'])]
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
    

    #[Router('/users', methods: ['POST'])]
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
    #[Router('/users/{id}', methods: ['PUT'])]
    public function updateUser($id) {
        $input = json_decode(file_get_contents('php://input'), true);
       
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
    #[Router('/users/{id}', methods: ['DELETE'])]
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
