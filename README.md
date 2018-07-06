# BooksCatalog
This is test task for IFMO university internship


    Symfony 3.4 (php7.1 & postgres & nginx )

# Deploy:

 Запуск на железе(Ubuntu xenial 64):
 
        * [sh deploy-prod.sh ](подгружает докер, поднимает контейнеры, подгружает зависимости проекта, сидит бд)
        
        
 Запуск на Vagrant машине
 
        * [ Vagrant & virtualbox ] (vagrant init ubuntu/xenial64 ; vagrant up --provider=virtualbox; vagrant ssh)
        * [sh deploy-vagrant.sh ](подгружает докер, поднимает контейнеры, подгружает зависимости проекта, сидит бд)
       
        
