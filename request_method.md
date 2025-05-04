## Request Methods
### resumo:
``` php
Route::get($uri, $callback); => pegar informação;
Route::post($uri, $callback); => criar a informação;
Route::put($uri, $callback); => atualizar a informação;
Route::patch($uri, $callback); => atualizar a informação;
Route::delete($uri, $callback); => deletar a informação;
Route::options($uri, $callback); => pegar mais informações sobre uma rota específica;
Route::match(['get', 'post'], '/', function(){...}); => define rotas que 'ouvem' multiplos métodos;
Route::any('/', function(){...}); => define rotas que 'ouvem' todos os métodos;
Route::redirect('/home', '/'); => redireciona rotas( primeiro argumento é a rota que será ouvida e o segundo argumento é a rota que o usuário deve ser redirecionado);[status code 302];
Route::redirect('/home', '/', 301); ~mesmo que~ Route::permanentRedirect('/home', '/');
Route::view('/contact', 'contact'); => ouve a rota '/contact' e tenta renderizar a view chamada 'contact';
Route::view('/contact', 'contact', ['phone' => '+5500987654321']); => ouve a rota '/contact' e tenta renderizar a view chamada 'contact' e insere o valor do parametro;
```
| Método              | Uso principal                                                  |
| ------------------- | -------------------------------------------------------------- |
| `get()`             | Buscar dados                                                   |
| `post()`            | Criar dados                                                    |
| `put()` / `patch()` | Atualizar recursos                                             |
| `delete()`          | Excluir recursos                                               |
| `options()`         | Permitir CORS / declarar métodos aceitos                       |
| `match()`           | Combinar múltiplos métodos para uma única rota                 |
| `any()`             | Aceitar todos os métodos HTTP (não recomendado para APIs REST) |

### detalhado:

### 1. `Route::get($uri, $callback)`

Usado para **buscar informações** (requisições HTTP GET).

```php
Route::get('/usuarios', function () {
    return ['João', 'Maria', 'Ana'];
});
```

Acessado via navegador:

```bash
http://localhost:8000/usuarios
```

---

### 2. `Route::post($uri, $callback)`

Usado para **criar novos dados** (requisições HTTP POST).

```php
Route::post('/usuarios', function (Illuminate\Http\Request $request) {
    return 'Usuário criado: ' . $request->input('nome');
});
```

Envio com `curl`:

```bash
curl -X POST -d "nome=Gláucia" http://localhost:8000/usuarios
```

---

### 3. `Route::put($uri, $callback)`

Usado para **substituir completamente um recurso existente**.

```php
Route::put('/usuarios/{id}', function ($id, Illuminate\Http\Request $request) {
    return "Usuário {$id} atualizado com PUT: " . $request->input('nome');
});
```

Envio com `curl`:

```bash
curl -X PUT -d "nome=Gláucia Atualizada" http://localhost:8000/usuarios/1
```

---

### 4. `Route::patch($uri, $callback)`

Usado para **atualizar parcialmente um recurso**.

```php
Route::patch('/usuarios/{id}', function ($id, Illuminate\Http\Request $request) {
    return "Usuário {$id} atualizado parcialmente com PATCH: " . $request->input('nome');
});
```

Envio com `curl`:

```bash
curl -X PATCH -d "nome=Novo Nome" http://localhost:8000/usuarios/1
```

---

### 5. `Route::delete($uri, $callback)`

Usado para **excluir um recurso**.

```php
Route::delete('/usuarios/{id}', function ($id) {
    return "Usuário {$id} excluído.";
});
```

Envio com `curl`:

```bash
curl -X DELETE http://localhost:8000/usuarios/1
```

---

### 6. `Route::options($uri, $callback)`

Usado para responder às **requisições OPTIONS**, que geralmente são usadas por navegadores para verificar as permissões CORS antes de uma requisição real.

```php
Route::options('/usuarios', function () {
    return response('', 200)
        ->header('Allow', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
```

Envio:

```bash
$ -X OPTIONS -i http://localhost:8000/usuarios
```

### 📘 O que é?

O método `options` define uma rota para lidar com **requisições HTTP do tipo OPTIONS**, que geralmente são usadas por navegadores **antes de requisições reais (pré-flight request)**, como parte do mecanismo de **CORS (Cross-Origin Resource Sharing)**.

### 📌 Quando usar?

* Quando sua API será acessada por **origens diferentes (domínios diferentes)**.
* Para permitir que navegadores verifiquem quais métodos e headers são permitidos antes de fazer a requisição real (POST, PUT etc.).

### 🧪 Exemplo:

```php
Route::options('/usuarios', function () {
    return response('', 200)
        ->header('Allow', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});
```

📎 Esse retorno é importante em APIs REST que serão consumidas por frontends em JavaScript (React, Vue, etc).

### 🔧 Dica:

Se estiver usando Laravel com **middleware de CORS** (`\Fruitcake\Cors\HandleCors`), geralmente **não precisa definir manualmente o OPTIONS**, pois ele é tratado automaticamente.

---

## 🔁 `Route::match(array $methods, $uri, $callback)`

### 📘 O que é?

O método `match` permite que você defina **uma única rota** que responda a **múltiplos métodos HTTP** ao mesmo tempo.

### 📌 Quando usar?

* Quando você quer reutilizar uma lógica para mais de um tipo de requisição.
* Útil para endpoints que aceitam tanto `GET` quanto `POST`, por exemplo.

### 🧪 Exemplo:

```php
Route::match(['get', 'post'], '/contato', function (Illuminate\Http\Request $request) {
    if ($request->isMethod('post')) {
        return 'Formulário enviado: ' . $request->input('mensagem');
    }

    return 'Formulário de contato (GET)';
});
```

📎 Esse exemplo permite:

* Acessar via navegador com GET
* Enviar dados via POST para o mesmo endpoint

---

### ⚠️ Cuidados com `match()` e `any()`

* Embora convenientes, **podem ocultar regras de negócio importantes**.
* É melhor usar `match()` com clareza e somente quando o comportamento da rota realmente precisa aceitar mais de um método.


### Resumo

| Método  | Uso principal                       | Idempotente? | Exemplo de ação                |
| ------- | ----------------------------------- | ------------ | ------------------------------ |
| GET     | Buscar dados                        | ✅            | Listar ou visualizar           |
| POST    | Criar novo recurso                  | ❌            | Criar usuário                  |
| PUT     | Substituir recurso por completo     | ✅            | Atualizar usuário inteiro      |
| PATCH   | Atualizar parte do recurso          | ✅            | Atualizar só o nome do usuário |
| DELETE  | Remover recurso                     | ✅            | Excluir usuário                |
| OPTIONS | Consultar métodos permitidos (CORS) | ✅            | Pré-verificação do navegador   |

---

## 🔄 `Route::redirect()`

```php
Route::redirect('/home', '/', 301);
```

### 📘 O que faz?

Cria uma rota que **redireciona automaticamente** de uma URL para outra.
Nesse exemplo, qualquer acesso a `/home` será redirecionado para `/`.

### 🧠 Terceiro parâmetro: o código HTTP

O número `301` indica que esse é um redirecionamento **permanente**:

* `301` → redirecionamento permanente (salvo em cache por navegadores e motores de busca)
* `302` (padrão) → redirecionamento temporário

---

## 🔁 `Route::permanentRedirect()`

```php
Route::permanentRedirect('/home', '/');
```

### 📘 O que faz?

Exatamente o mesmo comportamento de:

```php
Route::redirect('/home', '/', 301);
```

Ou seja, cria um redirecionamento **permanente (HTTP 301)** da rota `/home` para `/`.

---

### ✅ Comparação direta

| Comando                                  | Código HTTP | Tipo       |
| ---------------------------------------- | ----------- | ---------- |
| `Route::redirect('/home', '/', 302)`     | 302         | Temporário |
| `Route::redirect('/home', '/', 301)`     | 301         | Permanente |
| `Route::permanentRedirect('/home', '/')` | 301         | Permanente |

---

### 📎 Quando usar qual?

* Use **`redirect()` com 302** para redirecionamentos temporários (ex: página em manutenção).
* Use **`redirect()` com 301** ou **`permanentRedirect()`** para redirecionamentos definitivos (ex: mudança de URL ou estrutura de site).


## Parametros requeridos de rotas
### Exemplos

``` php
Route::get(uri:'/product/{id}', action: function(string $id){
    return "Product id = $id";
});
```

``` php
Route::get(uri:'{lang}/product/{id}/review/{reviewId}', action: function(string $lang, string $id, string $reviewId){});
```

## Parametros opcionais de rotas
### Exemplos

``` php
Route::get(uri:'/product/{category?}', action: function(string $category = null){});
// precisa de um valor default, no caso, `null`
```

## Validações
### Exemplos
```php
Route::get("/product/{id}", function(string $id){})->whereNumber("id"); //apenas numeros
```
```php
Route::get("/user/{username}", function(string $username){})->whereAlpha("username"); //apenas letras A-Z
```
```php
Route::get("/user/{username}", function(string $username){})->whereAlphaNumeric("username"); //alfanumérico A-z 0-9
```
```php
Route::get("{lang}/product/{id}", function(string $lang, string $id){})->whereAlpha("lang")->whereNumber("id"); 
```
```php
Route::get("{lang}/product", function(string $lang){})->whereIn("lang", ["en", "ka", "in"]); 
```

## Regex - Parametros
### Exemplos
```php
Route::get('/user/{username}', function(string $username){
    //...
})->where('username', '[a-z]+');
```
```php
Route::get('{lang}/product/{id}', function(string $lang, string $id){

})->where(['lang'=> '[a-z]{2}', 'id'=>'\d{4,}']);
```
```php
Route::get('/search/{search}', function(string $search){
    return $search;
})->where('search', '.+');
```

## Named Routes com Parametros
### Exemplos
```php
Route::get('/user/profile', function(){})->name('profile');
Route::get('/current-user', function(){
    return to_route('profile');
    //return redirect()->route(profile);
});
```

## Grupos
### Exemplos
```php
Route::getprefix('admin')->group(function(){
    Route::get('/users', function(){
        return '/admin/users';
    });
});
```
```php
Route::name('admin.')->group(function(){
    Route::get('/users', function(){
        return '/users'; // mas o nome da rota é "admin.users"
    })->name('users');
})
```
## Fallback
### Exemplos
```php
Route::fallback(function() {
    return "Rota de fallback";
});
```