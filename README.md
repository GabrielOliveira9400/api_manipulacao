
# Instruçoes para rodar o projeto
Swagger rodará no /api/documentation após a execução 

O projeto encontra-se todo em docker

## Suba os containers do projeto 
docker compose up -d

## Crie o arquivo .env
cp .env.example .env

## Acesse o container app
docker compose exec app bash

## Instale as dependencias

composer install

npm install


