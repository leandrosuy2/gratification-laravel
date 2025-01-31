# Gratification - Painel Administrativo

## Sobre o Projeto

Gratification é um sistema administrativo desenvolvido com Laravel, projetado para gerenciar usuários, permissões e outras funcionalidades relacionadas à plataforma.

## Como Rodar o Projeto

### Pré-requisitos
Certifique-se de ter instalado:
- PHP (>= 8.0)
- Composer
- Node.js & NPM (para frontend, se aplicável)

### Passos para Instalação

1. Clone o repositório:
   ```sh
   git clone https://github.com/leandrosuy2/gratification-laravel.git
   cd gratification-laravel
   ```

2. Instale as dependências:
   ```sh
   composer install
   ```

3. Configure o arquivo `.env`:
   ```sh
   cp .env.example .env
   ```
   Edite o `.env` e configure as credenciais do ambiente.

4. Gere a chave da aplicação:
   ```sh
   php artisan key:generate
   ```

5. Inicie o servidor local:
   ```sh
   php artisan serve
   ```

O sistema estará disponível em `http://localhost:8000`

## Documentação

O Laravel possui uma documentação abrangente disponível em [Laravel Docs](https://laravel.com/docs).

## Contribuição

Contribuições são bem-vindas! Caso encontre problemas ou tenha sugestões, sinta-se à vontade para abrir uma issue ou um pull request.

## Licença

Este projeto é open-source e está sob a licença [MIT](https://opensource.org/licenses/MIT).

