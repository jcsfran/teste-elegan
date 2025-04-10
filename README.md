Elegan
===

Este pacote tem como objetivo padronizar a documentação das rotas do projeto e criar os arquivos de
documentação por meio do terminal. Os arquivos criados são do tipo **.yaml**.

Só é necessário instalar o pacote e publicar os arquivos.

Foi desenvolvido para o [Laravel](https://laravel.com/) e utiliza como base o [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger).

Instalação
---

Utilize o comando abaixo no terminal.
```bash
composer require jcsfran/elegan
```


Após a instalação do pacote, será preciso publicar os arquivos para que o Elegan funcione. Utilize o seguinte comando no terminal:
```console
php artisan vendor:publish --provider "Jcsfran\Elegan\EleganServiceProvider"
```

### Após a instalação
Ao acessar a rota `http://127.0.0.1:8000/api/docs` no navegador a documentação deverá ser exibida, conforme a imagem abaixo:

![image](/uploads/68c040616cf21ed871f9528ebeed4c87/image.png)

Configurações
---
Os arquivos `config/elegan.php` e `config/l5-swagger.php` podem ser alterados de acordo com a sua preferência.

### Rota de acesso
Para configurar a rota de acesso da documentação, entre no arquivo _config/l5-swagger.php_ e altere o valor de `api`.
```php
// config/l5-swagger.php

'routes' => [
  'api' => 'novo/caminho'
]
```

Bloqueando o acesso
---
### Middleware de segurança:
Adicione o middleware de segurança na variável `$routeMiddleware` em _Http/Kernel.php_.
```php
// Http/Kernel.php

'access_docs' => \Jcsfran\Elegan\ValidateAccessEleganRoutes::class,
```

Acesse o arquivo _config/l5-swagger.php_ e adicione o  middleware `access_docs`.
```php
// config/l5-swagger.php

'middleware' => [
  'api' => ['access_docs'],
],
```

### Configuração do provedor
Acesse o arquivo _Providers/RouteServiceProvider.php_ e adicione o seguinte código na função `configureRateLimiting()`:

```php
// Providers/RouteServiceProvider.php

RateLimiter::for('docs_ip_address', function (Request $request) {
  RateLimiter::hit($request->ip(), config('elegan.decay_minutes') * 60);

  return Limit::perMinutes(
    config('elegan.decay_minutes'),
    config('elegan.rate_limit')
  )->by($request->ip());
});
```
O limite máximo de requisições por minuto e o tempo de timeout podem ser ajustados no arquivo de configuração _config/elegan.php_.

### Rota de acesso
No arquivo de rotas _routes/web.php_, adicione a rota de acesso ao formulário de acesso da documentação:

```php
// routes/web.php

Route::middleware(['throttle:docs_ip_address'])->group(function () {
  Route::view('/access-docs', 'elegan.form')
    ->name('access-docs');
});
```

### Chave da documentação
Adicione a variável `ELEGAN_KEY` no arquivo _.env_, esta variável é a senha da documentação.
```makefile
# .env

ELEGAN_KEY=chave_de_acesso
```
Caso a variável `ELEGAN_KEY` não seja adicionada, a senha padrão será `elegan`.

Arquivos de rota
---
Por padrão, os arquivos **.yaml** utilizam o mesmo padrão dos **nomes** dos métodos de um **controller** (index, store, show, update e destroy). Esses **nomes** são chamados de `Actions` nesta documentação.

- A **index** e a **show** utilizam o método `GET`
- O **store** utiliza o método `POST`
- O **update** utiliza o método `PUT`
- O **destroy** utiliza o método `DELETE`

Cada **Action** possui sua configuração base de arquivo.

Observação: esses nomes podem ser alterados no arquivo `config/elegan.php`.

Comandos
___
Use um dos comandos a seguir para criar um arquivo chamado actions.yaml, utilize o caminho retornado no terminal e coloque-o como referência na área de paths:

### Comandos básicos
- `php artisan docs:route example store` cria apenas o arquivo **store**.
- `php artisan docs:route example index` cria apenas o arquivo **index**.
- `php artisan docs:route example show` cria apenas o arquivo **show**.
- `php artisan docs:route example update` cria apenas o arquivo **update**.
- `php artisan docs:route example destroy` cria apenas o arquivo **destroy**.

``` yaml
# index.yaml

paths:
  /caminhoDaRota:
    $ref: example/actions.yaml
```

Observação: o nome **actions.yaml** pode ser alterado no arquivo `config/elegan.php`.

### Parâmetros
Para adicionar parâmetros a uma rota, utilize o caractere "`:`" seguido pelo nome do parâmetro. É possível adicionar mais de um parâmetro na mesma rota.

Quando um parâmetro é adicionado, ele é automaticamente incluído na **action** correspondente. Por exemplo, para adicionar um parâmetro "**id**" à rota "example" e à action "**show**", utilize o comando abaixo:

```cmd
# show.yaml

php artisan docs:route example/:id show
```

A estrutura de pastas para essa rota seria a seguinte:
```makefile
 ------------------
|- exemple
|-- id
|--- actions.yaml
|--- show.yaml
 ------------------
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

### Autenticação:
Adicione o parâmetro `--auth` no comando para indicar que a rota precisa de um token de autenticação.

```cmd
php artisan docs:route example show --auth
```
O atributo "**security**" é adicionado automaticamente ao arquivo **show.yaml**, como mostrado abaixo:
```yaml
# show.yaml

security:
  - bearerAuth: []
```

### Comando completo
O comando a seguir mostra todas as opções de configuração para `docs:route`
```cmd
php artisan docs:route example/:id index show store update destroy --auth`
```

A estrutura de pastas para essa rota e action seria a seguinte:
```makefile
 ------------------
|- example
|-- id
|--- actions.yaml
|--- index.yaml
|--- store.yaml
|--- show.yaml
|--- update.yaml
|--- destroy.yaml
 ------------------
```

#### Observações
Não é possível ter duas **Actions** com o mesmo método (por exemplo, index e show) no mesmo arquivo **actions.yaml**. Eles precisam estar em arquivos separados.

### Actions
- `destroy` gera um arquivo com o método **DELETE**.
- `show` gera um arquivo com o método **GET**.
- `index` gera um arquivo com o método **GET** e com o retorno paginado.
- `store` gera um arquivo com o método **POST** e com o as validações da requisição (adicionar manualmente), exemplos de requisições e com seu _status code_ 201.
- `update` gera um arquivo com o método **PUT** e com o as validações da requisição (adicionar manualmente), exemplos de requisições e com seu _status code_ 204.

### Renomear os arquivos yaml
- `php artisan docs:route example/:id store --name=login` gera um arquivo com o método **POST**, mas com o nome **login.yaml**.
- `php artisan docs:route example/:id store show --name=login --name=me` gera um arquivo com o método **POST**, mas com o nome **login.yaml** e um arquivo no método **GET** com o nome **me.yaml**.

Cada nome deve ser passado utilizando o `--name=` e na mesma ordem que foi informado as **Actions**.

Se o nome não é informado, o arquivo ficará com o nome da **Action** correspondente.

Notas de atualização
___
As notas de atualização servem para armazenar o histórico de atualização de sua documentação.

### Comandos
Para criar a estrutura base da nota de atualização, utilize o comando a seguir:
```cmd
php artisan docs:note nome
```

Caso necessite descrever mais rotas, utilize o parâmetro `--routes=numero_de_rotas`, exemplo:
```cmd
php artisan docs:note nome --routes=2
```

### Compatibilidade
Laravel - Versão 9.19 ou superior
