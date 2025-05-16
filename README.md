## Requisitos

* PHP 8.2 ou superior
* Composer
* Node.js 22 ou superior

## Como rodar o projeto baixado
Duplicar o arquivo "env.example" e renomear para ".env".<br>

Instalar dependencias do PHP
```
compose install
```

Gerar a chave para o arquivo ".env"
```
php artisan key:generate
```

## Sequencia para criar o projeto
Criar o projeto com Laravel
```
composer create-project laravel/laravel
```

Iniciar o projeto criado com Laravel
```
php artisan server
```