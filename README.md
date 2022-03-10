# Mañu is based in Lumen
This project manage the Mañu's backend  

## Requirements
- PHP 8.0
- Nodejs 16.x
- Severless 3.x
- awscliv2 
- AWS account with S3, DynamoDB, Lambda, API Gateway and Route53
- Java 8 *(optional local environment)*
- Docker, docker-compose *(optional local environment)*

## From the command line run
```bash
docker-compose up --build 
```
Web browser: http://localhost:8080
## Installation and Configuration locally
dynamoDBis saved on memory
### Dependencies
From the command line run:
```bash
sudo npm install -g serverless
npm install 
cd src
composer install
```
### Services init
Copiar las variables de entorno .env.example.local a .env
Copy .env.example.local  to .env
```bash
cd src
cp env.example.local .env
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
Web browser: http://localhost:8080
## Generate test data
### On DynamoDB
Configure AWS account to connect with lambda
```bash
aws configure
```
Run batch user creation 200 at a time
lambda function name is: player-<ENVIRONMENT>-console
```bash
cd src
"vendor\bin\bref" cli -r us-east-2 "player-develop-console" -- db:seed --class=PlayerSeeder
```
Clean the user table
```bash
cd src
"vendor\bin\bref" cli -r us-east-2 "player-develop-console" -- db:seed --class=PlayerClearSeeder
```
Create 3000 players
```bash
i=1
while [ $i -le 20 ]
do
  players=$(( $i * 100 ));
  echo "Creating $players playes";
  "vendor\bin\bref" cli -r us-east-2 "player-develop-console" -- db:seed --class=PlayerSeeder
  i=$(( $i + 1 ));
done
```
##Run Lint tests
```bash
cd src
composer install 
composer require overtrue/phplint:^4.0 --dev -vvv
vendor\bin\phplint 
```
##Run unit tests
It has been implemented in the folder src/tests/unit the unit test  for actions index, show, and delete
```bash
cd src
composer install 
vendor\bin\phpunit
```
