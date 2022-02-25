# Mañu esta basado en Lumen
Backend para la gestión de Jugadores para Creditú

## Requerimientos
- PHP 8.0
- Nodejs 14.x
- Severless 3.x
- awscliv2
- AWS account with S3, DynamoDB, Lambda, API Gateway and Route53
- Java 8 *(optional para ambiente local)*
## Levantar Localmente
La base de dynamoDB se guarda en memoria
### Dependencias
```bash
sudo npm install -g serverless
npm install 
composer install
```
### Servidor web
Copiar las variables de entorno .env.example.local a .env 
```bash
cp .env.example.local .env
bash init.sh
```
Abrir en el navegador: http://localhost:8080
## Levantar con Docker Compose
```bash
docker-compose up -d
```
Abrir en el navegador: http://localhost:8080
