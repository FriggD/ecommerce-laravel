## Lista de comandos

### Instalar laravel localmente
``` php
 $ composer global require laravel/installer
```

### Criar projeto
``` php
 $ composer create-projetc <project_name>
 $ laravel new <project_name>
 ```

### Subir servidor localmente
 ``` php
 $ php artisan serve
```

### Informações sobre o projeto
 ``` php
 $ php artisan about
```

### Todos os comandos disponíveis do `artisan`
 ``` php
 $ php artisan list
```

### Ver todos os comandos disponíveis de um grupo específico
- ex.: `make`
 ``` php
 $ php artisan make help
```

### Verificar a descrição, uso, argumentos e opções de um comando específico
- ex.: `controller` do grupo `make`
 ``` php
 $ php artisan make:controller --help
```

### Verificar quais arquivos de config estão "escondidos".
``` php
 $ php artisan config:publish
 $ php artisan vendor:publish
```

### Lista de rotas do projeto
```php
 $ php artisan route:list
```
### Criação de versão com cache
```php
 $ php artisan route:cache
```
### Limpar cache
```php
 $ php artisan route:clear
```

### Criar controller
```php
 $ php artisan make:controller <nameController>
```