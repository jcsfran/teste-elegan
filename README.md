Elegan
===

**Elegan** é um pacote desenvolvido para padronizar a documentação de rotas em projetos Laravel. Ele permite a criação de arquivos de documentação no formato **.yaml** diretamente via terminal.

Foi projetado para uso com o [Laravel](https://laravel.com/) e é baseado no pacote [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger).

Instalação
---

Execute o seguinte comando no terminal:
```bash
$ composer require jcsfran/elegan
```


Depois, publique os arquivos necessários:
```bash
$ php artisan vendor:publish --provider "Jcsfran\Elegan\EleganServiceProvider"
```

### 🚀 Acessando a Documentação
___
Após a instalação, acesse a URL:

```bash
$ http://127.0.0.1:8000/api/docs
```


### ⚙️ Configurações
___
#### Configuração de Rota
Altere o caminho de acesso à documentação no arquivo `config/elegan.php`:

```php
// config/elegan.php

'routes' => [
  'api' => 'novo/caminho'
]
```

#### Protegendo o Acesso
A documentação só se tornará privada quando a variável `ELEGAN_KEY` foi definida na `.env`

#### Limite de Requisições
O limite máximo de requisições por minuto e o tempo de timeout podem ser ajustados no arquivo de configuração _config/elegan.php_.

```php
// config/elegan.php

'rate_limit' => x,
'decay_minutes' => y,
```
#### Rota de acesso
Adicione a rota ao `routes/web.php`:

```php
// routes/web.php

Route::view('/access-docs', 'elegan::docs')->name('access-docs');
```

### 📄 Arquivos de rota
___

Cada **Action** representa um tipo de operação REST:

| Action   | Método HTTP |
|----------|-------------|
| `index`  | GET         |
| `show`   | GET         |
| `store`  | POST        |
| `update` | PUT         |
| `destroy`| DELETE      |

> Os nomes das Actions podem ser personalizados no arquivo `config/elegan.php`.
> Cada **Action** possui sua configuração base de arquivo.

### 🛠️ Comandos
___
Crie os arquivos de documentação usando os comandos abaixo:

#### Comandos individuais
- `php artisan docs:route example store` cria apenas o arquivo **store**.
- `php artisan docs:route example index` cria apenas o arquivo **index**.
- `php artisan docs:route example show` cria apenas o arquivo **show**.
- `php artisan docs:route example update` cria apenas o arquivo **update**.
- `php artisan docs:route example destroy` cria apenas o arquivo **destroy**.

Referência no seu arquivo **.yaml**:

``` yaml
# index.yaml

paths:
  /caminhoDaRota:
    $ref: routes/example/actions.yaml
```

Observação: o nome **actions.yaml** pode ser alterado no arquivo `config/elegan.php`.

#### Parâmetros
Para adicionar parâmetros à rota, inclua o caractere "`:`" seguido pelo nome do parâmetro. É possível adicionar mais de um parâmetro na mesma rota.

Quando um parâmetro é adicionado, ele é automaticamente incluído na **action** correspondente. Por exemplo, para adicionar um parâmetro "**id**" à rota "example" e à action "**show**", utilize o comando abaixo:

```cmd
# show.yaml

php artisan docs:route example/:id show
```

A estrutura de pastas para essa rota seria a seguinte:
```bash
example/
  └── id/
      ├── actions.yaml
      └── show.yaml
```
O parâmetro "**id**" é adicionado automaticamente ao arquivo **show.yaml**, como mostrado abaixo:
```yaml
parameters:
  - in: path
    name: id
    schema:
      type: string
    required: true
    description: ''
```

#### Autenticação:
Adicione o parâmetro `--auth` para incluir a obrigatoriedade do token de acesso:

```cmd
php artisan docs:route example show --auth
```
Referência no seu arquivo **.yaml**:
```yaml
# show.yaml

security:
  - bearerAuth: []
```

#### Comando completo
```cmd
php artisan docs:route example/:id index show store update destroy --auth`
```

Estrutura de saída:
```bash
example/
  └── id/
      ├── actions.yaml
      ├── index.yaml
      ├── store.yaml
      ├── show.yaml
      ├── update.yaml
      └── destroy.yaml
```

#### Observações
Não é possível ter duas **Actions** com o mesmo método (por exemplo, index e show) no mesmo arquivo **actions.yaml**. Eles precisam estar em arquivos separados.

### 🧱 Actions e Suas Funções
___
| Action   | Método HTTP | Descrição                                                                 |
|----------|-------------|---------------------------------------------------------------------------|
| `index`  | GET         | Retorna uma listagem paginada                                             |
| `show`   | GET         | Exibe os detalhes de um item                                              |
| `store`  | POST        | Cria um novo item com exemplos de requisição e código de status 201       |
| `update` | PUT         | Atualiza um item com exemplos de requisição e código de status 204        |
| `destroy`| DELETE      | Remove um item do sistema                                                 |

> As validações da requisição devem ser adicionadas manualmente para as actions `store` e `update`.

#### Renomeando Arquivos
```bash
$ php artisan docs:route example/:id store --name=login
```
Ou múltiplos nomes:
```bash
$ php artisan docs:route example/:id store show --name=login --name=me
```

A ordem dos --name= deve seguir a ordem das Actions.

Se o nome não é informado, o arquivo ficará com o nome da **Action** correspondente.

### 🗒️ Notas de atualização
___
Crie o histórico da documentação com:

```bash
$ php artisan docs:note nome
```
Especificar múltiplas rotas:
```bash
$ php artisan docs:note nome --routes=2
```

### ✅ Requisitos
___
Laravel - Versão 12 ou superior
