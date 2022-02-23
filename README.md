# Mañu esta basado en Lumen
Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Requerimientos
- PHP 8.0
- Nodejs 14.x
- Severless 3.x
- aws-cliv2
- AWS account with S3, DynamoDB, Lambda, API Gateway and Route53
- Java 8 *(optional para ambiente local)*
## Instalación
### Dependencias
```bash
npm install -g serverless
npm install 
composer install
```
## Levantar Localmente
### Servidor web
```bash
php -S localhost:3000 -t public
```
### DynamoDB Local
```bash
sls dynamodb install
sls dynamodb start --migrate
```
### S3 Local
```bash
sls offline
```

