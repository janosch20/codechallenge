Vagrant.configure("2") do |config|
  config.vm.box = "scotch/box"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "private_network", type: "dhcp"
  config.vm.provision :shell, path: "install.sh"
end
