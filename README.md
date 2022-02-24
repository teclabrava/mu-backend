# Mañu esta basado en Lumen
Backend para la gestión de Jugadores para Creditú

## Requerimientos
- PHP 8.0
- Nodejs 14.x
- Severless 3.x
- awscliv2
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
sls dynamodb install --stage local 
sls dynamodb start --migrate --stage local
```
### S3 Local

Actualizar las variables de entorno:

````
BUCKET_KEY=S3RVER
BUCKET_SECRET=S3RVER
BUCKET_ENDPOINT=http://localhost:4569
````

```bash
sls offline
```

