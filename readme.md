# FastRoute - Projeto Backend
O FastRoute é um projeto de backend que visa facilitar a inclusão de rotas em uma aplicação REST, permitindo a criação rápida de endpoints CRUD com operações básicas. O banco de dados utilizado é o SQLite para facilitar os testes e a configuração inicial. Este projeto não possui frontend, focando apenas no backend.

## Requisitos
- PHP 7.4+ ou superior
- Composer
- Banco de dados SQLite
- Postman ou Thunder Client (ou qualquer cliente de API REST)
## Estrutura do Projeto
A estrutura de pastas do projeto está organizada da seguinte forma:

```
/backend
    /Controllers
        - UserController.php
    /Database
        - config.php
        - Database.php
    /Http
        - HttpHeader.php
    /Models
        - User.php
    /Repositories
        - UserRepository.php
    /Rotas
        - rotas.php
        - Router.php
    - agenda.db
    - index.php
/vendor
.gitignore
composer.json
```
## Configuração
### Clone o repositório:

```
git clone https://github.com/faustinopsy/FastRoute.git
```
Baixe as dependencias do composer
```
composer install
```
Navegue até a pasta backend:

```
cd backend
```
### Inicialize o servidor PHP:

Inicie o servidor embutido do PHP dentro da pasta backend para facilitar o teste:

```
php -S localhost:8000
```

## Endpoints Disponíveis
O projeto inclui cinco operações CRUD nas mesmas rotas, variando apenas o método HTTP. Veja abaixo os endpoints disponíveis:

- GET /users - Retorna todos os usuários
- GET /users/{id} - Retorna um usuário específico pelo ID
- POST /users - Cria um novo usuário
- PUT /users/{id} - Atualiza um usuário existente pelo ID
- DELETE /users/{id} - Deleta um usuário existente pelo ID

## Exemplo de Requisição com JSON
Para testar os endpoints, você pode usar o Postman ou Thunder Client. 

### Exemplo para criar um novo usuário (POST /users):

Método: POST

URL: http://localhost:8000/users
Body (raw JSON):
```
{
  "nome": "seunomex",
  "email": "seunomex@gmail.com",
  "senha": "1234"
}
```

### Exemplo de Atualização de Usuário
Método: PUT
URL: http://localhost:8000/users/1
Body (raw JSON):

```
{
  "nome": "nomeatualizado",
  "email": "emailatualizado@gmail.com",
  "senha": "nova_senha"
}
```
### Exemplo de Deleção de Usuário
Método: DELETE
URL: http://localhost:8000/users/1