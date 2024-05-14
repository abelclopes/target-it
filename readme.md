# Projeto de Desenvolvimento para Teste Técnico

Este projeto foi desenvolvido como parte do processo seletivo para uma vaga de desenvolvimento. O objetivo é demonstrar a capacidade de análise, elaboração e implementação de uma solução web conforme as boas práticas de desenvolvimento de software.

## Princípios SOLID

Este projeto segue os princípios SOLID para garantir um código bem estruturado e fácil de manter:

- **S**ingle Responsibility Principle
- **O**pen/Closed Principle
- **L**iskov Substitution Principle
- **I**nterface Segregation Principle
- **D**ependency Inversion Principle

Para mais informações sobre os princípios SOLID, consulte [SOLID na Wikipedia](https://pt.wikipedia.org/wiki/SOLID).

## Funcionalidades Implementadas

O Web Service REST desenvolvido oferece as seguintes funcionalidades:

1. Autenticação com JWT
2. CRUD de usuários:
   - Criação de usuário
   - Edição de usuário
   - Exclusão lógica de usuário
   - Consulta de dados do usuário
3. Atribuição de permissões a usuários
4. Armazenamento de registros de endereço

## Tecnologias Utilizadas

- **Linguagem**: PHP 7.4
- **Framework**: Laravel
- **Banco de Dados**: MySQL
- **Testes**: PHPUnit para testes unitários

## Estrutura do Projeto


Aqui está um exemplo de um arquivo README.md para o teste técnico que você descreveu, focando em estrutura, clareza e boa documentação:

markdown
Copiar código
# Projeto de Desenvolvimento para Teste Técnico

Este projeto foi desenvolvido como parte do processo seletivo para uma vaga de desenvolvimento. O objetivo é demonstrar a capacidade de análise, elaboração e implementação de uma solução web conforme as boas práticas de desenvolvimento de software.

## Princípios SOLID

Este projeto segue os princípios SOLID para garantir um código bem estruturado e fácil de manter:

- **S**ingle Responsibility Principle
- **O**pen/Closed Principle
- **L**iskov Substitution Principle
- **I**nterface Segregation Principle
- **D**ependency Inversion Principle

Para mais informações sobre os princípios SOLID, consulte [SOLID na Wikipedia](https://pt.wikipedia.org/wiki/SOLID).

## Funcionalidades Implementadas

O Web Service REST desenvolvido oferece as seguintes funcionalidades:

1. Autenticação com JWT
2. CRUD de usuários:
   - Criação de usuário
   - Edição de usuário
   - Exclusão lógica de usuário
   - Consulta de dados do usuário
3. Atribuição de permissões a usuários
4. Armazenamento de registros de endereço

## Tecnologias Utilizadas

- **Linguagem**: PHP 7.4
- **Framework**: Laravel
- **Banco de Dados**: MySQL
- **Testes**: PHPUnit para testes unitários

## Estrutura do Projeto
```
/Target-IT
│
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ ├── Middleware/
│ ├── Models/
│ └── Services/
├── config/
├── database/
│ ├── migrations/
│ ├── seeds/
├── tests/
│ ├── Feature/
│ └── Unit/
└── vendor/
```

## Instalação

1. Clone o repositório:
2. Instale as dependências:
3. Configure o ambiente:

`cp .env.example .env`

`php artisan key:generate`

4. Configure o banco de dados no `.env` e execute as migrações:
5. Execute os testes para garantir que tudo está configurado corretamente:
`php artisan test`

## Uso

Após a instalação, você pode iniciar o servidor localmente:
Acesse [http://localhost:8000](http://localhost:8000). para interagir com a API conforme definido na documentação de endpoints.

## Documentação da API

A documentação detalhada dos endpoints está disponível no Swagger, que pode ser acessada em [http://localhost:8000](http://localhost:8000/api/documentation).

## Avaliação

O projeto será avaliado com base nos seguintes critérios:

- Implementação e organização do código
- Validação de dados
- Armazenamento e manipulação de dados
- Modularização
- Uso adequado dos verbos HTTP e dos códigos de status HTTP
- Histórico e organização dos commits no GIT

## OUTRA FORMA

# Sisauth

Este projeto utiliza o framework Laravel para implementar uma API RESTful com autenticação JWT. A API é documentada utilizando Swagger e inclui suporte adicional para depuração com Clockwork.

## 1.Requisitos

- PHP >= 7.4
- Docker 4.1.0
- Composer 2.0.8
- Laravel ^8.0
- jwt-auth ^1.0.2
- Swagger 8.3.2
- Clockwork 5.0.8

## Instalação

1. **Clonar o Repositório**

   Clone este repositório para sua máquina local ou baixe o arquivo zip.

   ```
   git clone [URL_DO_REPOSITÓRIO]
   ```
## 2. Navegar até o Diretório do Projeto
cd sisauth

## 3. Construir e Executar os Contêineres Docker
Use o Docker Compose para construir e iniciar os contêineres.
   ```
docker-compose build
docker-compose up -d
   ```

## 4. Configurar o Ambiente
Entre no contêiner Docker para realizar a configuração adicional.

```
docker exec -it sisauth sh
```

## 5. Atualizar o Composer e Definir a Chave da Aplicação

Dentro do contêiner, execute os seguintes comandos para atualizar o Composer e gerar a chave da aplicação.
   ```
composer update
php artisan key:generate
   ```

## Configurar JWT

## 6.Gere uma nova chave secreta para autenticação JWT.

   ```
php artisan jwt:secret
   ```
## 7.Gerar Documentação Swagger
Gere a documentação da API usando Swagger.

   ```
php artisan l5-swagger:generate
   
   ```
   Executar Migrações de Banco de Dados

## 8.Migre o banco de dados para configurar as tabelas necessárias.

   ```
php artisan migrate
   ```

## 9.Visitar o Localhost

O projeto agora deve estar em execução. Você pode acessá-lo visitando [http://localhost](http://localhost).

Configuração Adicional
Certifique-se de que seu arquivo .env está configurado corretamente, particularmente para as conexões de banco de dados, que são essenciais para a funcionalidade da API.
Solução de Problemas
Se você encontrar algum problema durante a configuração, certifique-se de que o Docker está funcionando corretamente e todas as variáveis de ambiente estão configuradas adequadamente no seu arquivo .env. Verifique os logs do Docker e do Laravel para mensagens de erro detalhadas.

Contato
Para quaisquer dúvidas sobre a configuração ou uso deste projeto, consulte a seção de problemas do repositório ou entre em contato diretamente por e-mail abellopes@gmail.com.