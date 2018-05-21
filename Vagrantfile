Vagrant.configure(2) do |config|

    config.vm.provider :virtualbox do |vb|
        vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    end

    config.vm.define "jenkins" do |jen|
        jen.vm.box = "ubuntu/xenial64"
        jen.vm.network "private_network", ip: "10.10.0.10"
    end

    config.vm.define "test" do |test|
        test.vm.box = "ubuntu/xenial64"
        test.vm.network "private_network", ip: "10.10.0.11"
    end

    config.vm.define "staging" do |sta|
        sta.vm.box = "ubuntu/xenial64"
        sta.vm.network "private_network", ip: "10.10.0.12"
    end

    config.vm.define "prod" do |prod|
        prod.vm.box = "ubuntu/xenial64"
        prod.vm.network "private_network", ip: "10.10.0.13"
    end

    config.vm.provision "shell", inline: "sudo apt-get update && sudo apt-get -y install python"
    config.vm.provision :ansible do |ansible|
        ansible.inventory_path = "provision/inventory/local/hosts.yml"
        ansible.playbook = "provision/provision.yml"
    end
end

