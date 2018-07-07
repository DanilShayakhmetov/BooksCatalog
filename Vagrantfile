Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.synced_folder "var/cache", "/vagrant/var/cache", owner: "www-data", group: "vagrant", mount_options: ["dmode=775,fmode=664"]
  config.vm.synced_folder "var/logs", "/vagrant/var/logs", owner: "www-data", group: "vagrant", mount_options: ["dmode=775,fmode=664"]
end
