# Mañu esta basado en Lumen
Backend para la gestión de Jugadores para Creditú

## Requerimientos
- PHP 8.0
- Nodejs 16.x
- Severless 3.x
- awscliv2 
- AWS account with S3, DynamoDB, Lambda, API Gateway and Route53
- Java 8 *(optional para ambiente local)*
- Docker, docker-compose *(optional para ambiente local)*

## Levantar con Docker Compose para uso local
```bash
docker-compose up --build 
```
Abrir en el navegador: http://localhost:8080
## Levantar Localmente desde la terminal
La base de dynamoDB se guarda en memoria
### Dependencias
```bash
sudo npm install -g serverless
npm install 
composer install
```
### Arranque de Servicios
Copiar las variables de entorno .env.example.local a .env 
```bash
cp .env.example.local .env
```
#### Run Local S3
```bash
cd serverless
sls offline --stage local --config=serverless.local.yml >&2
```
#### Run Local dynamodb
```bash
cd serverless
sls dynamodb install --config=serverless.local.yml && sls dynamodb start --stage local --verbose --config=serverless.local.yml >&2 
```
#### Run Local web server
```bash
cd src
php -S 0.0.0.0:8080 -t public >&2
```
Abrir en el navegador: http://localhost:8080
