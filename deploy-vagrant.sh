wget -O /tmp/docker.sh http://get.docker.com;
bash /tmp/docker.sh;
echo "docker successfully installed"
sudo apt-get install -y python3-pip;
sudo pip3 install docker-compose
sudo adduser vagrant docker
echo "docker compose successfully installed"
sleep 5;
sudo docker-compose up --build -d ;
sudo dpkg  --configure -a ;
sudo docker run --rm -it --volume $(pwd):/app prooph/composer:7.2 install ;
sudo docker exec -i php.catalog bash -c "php bin/console doctrine:database:create" ;
sudo docker exec -i php.catalog bash -c "php bin/console doctrine:schema:create" ;
sudo docker exec -i php.catalog bash -c "php bin/console doctrine:fixtures:load" ;
sudo chown -R www-data:$USER var;
