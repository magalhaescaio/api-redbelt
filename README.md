backend

git clone https://github.com/magalhaescaio/api-redbelt.git

Acesse a pasta da api\
cd .\api-redbelt\

composer install\

git submodule add https://github.com/Laradock/laradock.git\

copie o arquivo .env-laradock para dentro da pasta .\laradock e \
altere o nome do arquivo para .env\

Acesse a pasta do laradock\
cd .\laradock\


docker-compose up -d nginx mysql phpmyadmin\

docker-compose exec --user=laradock workspace bash\

php artisan migrate

