<p align="center">
  <a href="" rel="noopener">
 <img width=200px height=200px src="https://i.imgur.com/6wj0hh6.jpg" alt="Project logo"></a>
</p>

<h3 align="center">Desafio ProConsult - Chamados </h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()

</div>

---

<p align="center"> Projeto desenvolvido para o desafio da ProConsult que consiste no cadastro, edição e exclusão de usuarios e chamados.
    <br> 
</p>

## 📝 Índice

- [Sobre](#about)
- [Getting Started](#getting_started)
- [Authors](#authors)

## 🧐 Sobre <a name = "about"></a>

A aplicação que você deverá criar consiste num sistema de suporte fornecido por uma empresa aos seus clientes.

Para a empresa conseguir dar assistência, os clientes devem abrir um chamado na plataforma que será desenvolvida. Após a abertura do chamado, um colaborador da empresa poderá responder.

Requisitos:

Fluxo de autenticação (cadastro e login apenas).

Devem existir dois tipos de usuários: Cliente e Colaborador.

Ambos os tipos de usuário precisarão de nome completo, CPF, e-mail e senha. CPF e e-mail devem ser únicos no sistema, ou seja, o sistema deve permitir apenas um cadastro com o mesmo CPF ou e-mail.

Apenas usuários do tipo Cliente devem conseguir abrir chamados.

Um chamado deve possuir título, descrição e anexos (opcional).

Os chamados devem possuir 3 possíveis status: Aberto, Em atendimento e Finalizado. Um chamado deve nascer com o status Aberto. Quando um colaborador responder o chamado, ele deve passar para Em atendimento. Quando o chamado for finalizado, independente do problema ter sido resolvido ou não, deve ir para o status de Finalizado.

Apenas usuários do tipo Colaborador devem conseguir responder os chamados abertos.

Considere o funcionamento de um tópico de um fórum como exemplo para criar o ciclo de vida de um chamado, ou seja, desde sua abertura até sua finalização.

## 🏁 Getting Started <a name = "getting_started"></a>

Instruções para ter uma cópia do repositório.

### Pré-requisitos

-   **PHP - Supported Versions:** >= 7.3 <= 8.0
-   **Laravel - 8
-   **Database:** MySQL
-   **Run-time environment:**: Node.js, Composer, npm, Vue & Laravel Framework

### Instalação

- Clone

O repositório onde se encontra o código fonte da aplicação está na branch **master**. Logo:

```bash
$ git clone https://github.com/maurorgrdev/desafio-proconsult.git
$ cd desafio-proconsult
$ git checkout master
```

- **Back-end**
É necessário criar a base de dados manualmente por meio do seu MySQL. O nome deverá ser `proconsult`.

-   **Back-end**

Estas ações devem ser realizadas dentro da pasta /api-chamados .

- Configuração

Faça uma cópia do arquivo env.example e o renomeie para .env
Em seguida altere as variáveis de acesso ao banco de dados com suas credênciais

```bash
APP_NAME=ProConsult

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prosconsult
DB_USERNAME=
DB_PASSWORD=
```

Instale as dependências via composer e gere sua chave: 

```bash
$ composer install
$ php artisan key:generate
```

Ainda no terminal execute:
```bash
$ php artisan optimize:clear
$ php artisan optimize
```

Para gerar as tabelas no banco de dados e gera usuario admin execute o seguinte comando:
```bash
$ php artisan migrate --seed
```

Será gerado um usuário com as seguintes credênciais:
```bash
nome: admin
email: admin@gmail.com
password: senha
cpf: 11806583887
perfil: admin
```

E por fim inicie a API:
```bash
$ php artisan serve --port=8000
```


-   **Front-end**

Estas ações devem ser realizadas dentro da pasta /fron-end.

- Framework

Instale o framework Quasar:

```bash
$ npm i -g @quasar/cli
```

- Configuração

Instale todas as depedências:

```bash
$ npm install
```

- Iniciar app em modo de desenvolvimento

```bash
$ quasar dev
```

A Aplicação deverá aparecer no seu navegador.

## ✍️ Authors <a name = "authors"></a>

- [@maurorgrdev](https://github.com/maurorgrdev) - Developer - mauroroger2020@gmail.com
