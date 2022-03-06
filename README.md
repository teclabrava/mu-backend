# Mañu is based in Lumen
This project manage the Mañu's backend

## Requirements
- Docker, docker-compose *(optional local environment)*
## From the command line run
```bash
git clone https://github.com/teclabrava/mu-backend.git
cd mu-backend
git checkout develop
docker-compose up -d --build 
```
Opem web browser: http://localhost:8080
## Generate test data
### Generate test data in local environment
```bash
docker-compose exec api php artisan db:seed
```
### On DynamoDB in development environment
##Settings account AWS
Create and setting values in .env file with the following values
```bash
AWS_ACCESS_KEY_ID=<your access key>
AWS_SECRET_ACCESS_KEY=<your secret key>
AWS_DEFAULT_REGION=<your region>
STAGE=<your stage>
```
##Generate data in development environment
```bash
docker-compose up -d --build
docker-compose exec console vendor/bin/bref cli -r us-east-2 "player-develop-console" -- db:seed 
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
##Deployment manual
##Settings account AWS
Create and setting values in .env file with the following values
```bash
AWS_ACCESS_KEY_ID=<your access key>
AWS_SECRET_ACCESS_KEY=<your secret key>
AWS_DEFAULT_REGION=<your region>
STAGE=<your stage>
```
##Deployment in develop
```bash
docker-compose up -d --build
docker-compose exec console sls deploy --config=serverless.develop.yml --stage develop
```
