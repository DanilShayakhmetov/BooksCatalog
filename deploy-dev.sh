wget -O /tmp/docker.sh http://get.docker.com;
bash /tmp/docker.sh;
echo "docker successfully installed"
sudo apt-get install -y python3-pip;
sudo pip3 install docker-compose
echo "docker compose successfully installed"
sudo docker-compose up --build -d