<h1>Teste Técnico Desenvolvedor Pleno</h1>

## Objetivo
<p>Desenvolver um sistema para controle de finanças pessoais, com cadastro de usuários, lançamento de receitas e despesas, visualização de saldo e filtros.</p>

## Pré-requisitos
- Frontend: Angular 16+
- Backend: PHP 7.4+ (Slim ou Laravel)
- Banco de Dados: MySQL
- Hospedagem:
- Frontend: Vercel, SimplyFy, Netlify ou similar
- Backend: Railway, Render, Freehost ou similar

## Hospedagem
- Link do repositório do frontend: https://github.com/CaiocDeus/app-4UIT-teste
- Link do backend hospedado: https://api-4uit-teste-production.up.railway.app
- Link do frontend hospedado: https://app-4-uit-teste.vercel.app


## Tecnologias Utilizadas
![Laravel](https://img.shields.io/badge/Laravel-v12-FF2D20?style=for-the-badge&logo=laravel&logoColor=FF4A4A)
![MySQL](https://img.shields.io/badge/MySQL-73618F?style=for-the-badge&logo=mysql&logoColor=white)
![Eloquent](https://img.shields.io/badge/eloquent-ff5733?style=for-the-badge&color=FE2D20)
![Docker](https://img.shields.io/badge/docker-blue?style=for-the-badge&logo=docker)

<hr>

## 🎲 Banco de Dados

<p>
O banco de dados está estruturado da seguinte maneira:</p>

- users: id, name, email, password
- transactions: id, user_id, type, description, amount, transaction_date

<br>

## ✨ Funcionalidades
- Cadastro de usuário
- Login por e-mail e senha
- Cadastro de transações (receita ou despesa)
- Listagem de transações com filtros por período e tipo
- Edição e exclusão de transações
- Sumarização de: Saldo total, Total de receitas e Total de despesas

<p><strong>Observação</strong>: Todas as rotas exigem <strong>autenticação</strong> menos Login e Realizar Cadastro</p>

<br>

## ⚙️ Executando a aplicação

Para executar o projeto localmente, siga os passos abaixo:

### Instalação

1. Clone o repositório:

```
 git clone https://github.com/CaiocDeus/api-4UIT-teste.git
```

2. Vá para a pasta do projeto:

```
cd api-4UIT-teste
```

3. Instale as dependências do projeto:

```
composer install
```

4. Configurar o arquivo de ambiente (.env):

```
cp .env.example .env
```

5. Suba os containers do projeto com o comando: (É preciso ter o Docker instalado)

```
./vendor/bin/sail up -d
```

6. Rode o seguinte comando para criar as tabelas no BD:

```
./vendor/bin/sail artisan migrate
```

7. Rode o seguinte comando para preencher o BD com dados nas tabelas:

```
./vendor/bin/sail artisan db:seed
```

8. Após isso, você poderá fazer as requisições seguindo os passos da seção logo abaixo.

<br>

## 📑 Documentação da API

### Funcionalidades dos usuários em rotas públicas.

<details>
  <summary>Logar na rota /api/user/login</summary>

  <code>POST</code> <code>/api/user/login</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Content-Type` | `application/json` | **Obrigatório** -> Tipo de mídia dos dados que estão sendo enviados na requisição |

  | Parâmetros Body   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `email` | `string` | **Obrigatório** -> Email do usuário |
  | `password` | `string` | **Obrigatório** -> Senha do usuário |

  #### Exemplo de retorno

  <p>Status: 200 OK</p>
    {
      "token": "1|KNupIm0xOoPe3rC94EeWi9HcMFKg4ByqmP3ZpP5Bb3c8ec1d"
    }
</details>

<details>
  <summary>Realizar Cadastro na rota /api/user/register</summary>

  <code>POST</code> <code>/api/user</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Content-Type` | `application/json` | **Obrigatório** -> Tipo de mídia dos dados que estão sendo enviados na requisição |

  | Parâmetros Body   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `email` | `string` | **Obrigatório** -> Email do usuário |
  | `password` | `string` | **Obrigatório** -> Senha do usuário |

  #### Exemplo de retorno

  <p>Status: 201 Created</p>
    {
      "id": "5"
      "message": "Usuário criado"
    }
</details>

<hr>

### Funcionalidades das transações em rotas autenticadas.

<details>
  <summary>Obter informações das transações na rota /api/transaction</summary>

  <code>GET</code> <code>/api/transaction</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Authorization` | `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...` | **Obrigatório** -> Seu token gerado no login |

  #### Exemplo de retorno

  <p>Status: 200 OK</p>
    [
      {
        "id": 1,
        "user_id": 2,
        "type": "receita",
        "description": "Voluptatem quisquam culpa nemo accusantium eveniet.",
        "amount": "401.37",
        "transaction_date": "2002-12-01",
        "created_at": "2025-06-26T01:28:50.000000Z",
        "updated_at": "2025-06-26T01:28:50.000000Z"
      },
      {
        "id": 2,
        "user_id": 2,
        "type": "despesa",
        "description": "Asperiores id sunt ut illum assumenda cumque vero.",
        "amount": "595.96",
        "transaction_date": "1975-12-11",
        "created_at": "2025-06-26T01:28:50.000000Z",
        "updated_at": "2025-06-26T01:28:50.000000Z"
      }
    ]

</details>

<details>
  <summary>Obter informação de uma transação na rota /api/transaction/{id}</summary>

  <code>GET</code> <code>/api/transaction/{id}</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Authorization` | `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...` | **Obrigatório** -> Seu token gerado no login |

  | Parâmetro via Request   | Tipo       | Descrição               |
  | :---------- | :--------- | :---------------------------------- |
  | `id` | `string` | **Obrigatório** ->  ID da transação |

  #### Exemplo de retorno

  <p>Status: 200 OK</p>
    {
      "id": "24",
      "user_id": "5",
      "type": "receita",
      "description": "Voluptatem quisquam culpa nemo accusantium eveniet",
      "amount": "110.48",
      "transaction_date": "2002-12-01",
      "created_at": "2025-03-10T21:25:29.000000Z",
      "updated_at": "2025-03-10T21:25:29.000000Z",
    }
</details>

<details>
  <summary>Realizar uma transação na rota /api/transaction</summary>

  <code>POST</code> <code>/api/transaction</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Content-Type` | `application/json` | **Obrigatório** -> Tipo de mídia dos dados que estão sendo enviados na requisição |
  | `Authorization` | `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...` | **Obrigatório** -> Seu token gerado no login |

  | Parâmetros Body   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `type` | `string` | **Obrigatório** -> Tipo da transação |
  | `description` | `number` | **Obrigatório** -> Descrição da transação |
  | `amount` | `number` | **Obrigatório** -> Valor da transação |
  | `transaction_date` | `string` | **Obrigatório** -> Data da transação |

  #### Exemplo de retorno

  <p>Status: 200 OK</p>
    {
      "message": "Transação criada"
    }
</details>

<details>
  <summary>Alterar uma transação na rota /api/transaction</summary>

  <code>PUT</code> <code>/api/transaction</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Content-Type` | `application/json` | **Obrigatório** -> Tipo de mídia dos dados que estão sendo enviados na requisição |
  | `Authorization` | `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...` | **Obrigatório** -> Seu token gerado no login |

  | Parâmetros Body   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `type` | `string` | Tipo da transação |
  | `description` | `number` | Descrição da transação |
  | `amount` | `number` | Valor da transação |
  | `transaction_date` | `string` | Data da transação |

  #### Exemplo de retorno

  <p>Status: 200 OK</p>
    {
      "message": "Transação atualizada"
    }
</details>

<details>
  <summary>Exclusão de uma transação na rota /api/transaction/{id}</summary>

  <code>DELETE</code> <code>/api/transaction/{id}</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Authorization` | `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...` | **Obrigatório** -> Seu token gerado no login |

  | Parâmetro via Request   | Tipo       | Descrição               |
  | :---------- | :--------- | :---------------------------------- |
  | `id` | `string` | **Obrigatório** ->  ID da transação |

  #### Exemplo de retorno

  <p>Status: 200 OK</p>
    {
      "message": "Usuário deletada"
    }
</details>

<details>
  <summary>Sumarização de: Saldo total, Total de receitas e Total de despesas do usuário logado na rota /api/transaction/relatorio</summary>

  <code>GET</code> <code>/api/transaction/relatorio</code>

  | Headers   | Tipo       | Descrição                           |
  | :---------- | :--------- | :---------------------------------- |
  | `Authorization` | `Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...` | **Obrigatório** -> Seu token gerado no login |

  #### Exemplo de retorno

  <p>Status: 200 OK</p>
    {
        "total_receitas": "3138.64",
        "total_despesas": "1571.02",
        "saldo_total": "1567.62"
    }
</details>

<hr>

## Autor

Caio Cesar de Deus

<hr>

## 📫 Contato
[![Linkedin](https://img.shields.io/badge/linkedin-%230077B5.svg?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/caio-deus/)
[![Email](https://img.shields.io/badge/Microsoft_Outlook-0078D4?style=for-the-badge&logo=microsoft-outlook&logoColor=white)](mailto:caioc.deus@outlook.com)
