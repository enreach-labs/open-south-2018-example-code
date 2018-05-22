Vagrant.configure(2) do |config|

    config.vm.provider :virtualbox do |vb|
        vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    end

    config.vm.define "develop" do |dev|
        dev.vm.box = "ubuntu/xenial64"
        dev.vm.network "private_network", ip: "10.10.0.10"
        dev.vm.provider "virtualbox" do |v|
            v.memory = 4096
            v.cpus = 1
        end
        dev.vm.provision :ansible do |ansible|
            ansible.limit = "develop"
            ansible.inventory_path = "provision/inventory/hosts.yml"
            ansible.playbook = "provision/provision.yml"
        end
    end

    config.vm.define "test" do |test|
        test.vm.box = "ubuntu/xenial64"
        test.vm.network "private_network", ip: "10.10.0.11"
        test.vm.provider "virtualbox" do |v|
            v.memory = 1024
            v.cpus = 1
        end
        test.vm.provision :ansible do |ansible|
            ansible.limit = "test"
            ansible.inventory_path = "provision/inventory/hosts.yml"
            ansible.playbook = "provision/provision.yml"
        end
    end

    config.vm.define "staging" do |sta|
        sta.vm.box = "ubuntu/xenial64"
        sta.vm.network "private_network", ip: "10.10.0.12"
        sta.vm.provider "virtualbox" do |v|
            v.memory = 1024
            v.cpus = 1
        end
        sta.vm.provision :ansible do |ansible|
            ansible.limit = "staging"
            ansible.inventory_path = "provision/inventory/hosts.yml"
            ansible.playbook = "provision/provision.yml"
        end
    end


    (1..2).each do |node|
        config.vm.define "prod#{node}" do |prod|
            prod.vm.box = "ubuntu/xenial64"
            prod.vm.network "private_network", ip: "10.10.0.#{20+node}"
            prod.vm.provider "virtualbox" do |v|
                v.memory = 1024
                v.cpus = 1
            end
            prod.vm.provision :ansible do |ansible|
                ansible.inventory_path = "provision/inventory/hosts.yml"
                ansible.playbook = "provision/provision.yml"
            end
        end
    end

    config.vm.define "repository" do |repo|
        repo.vm.box = "ubuntu/xenial64"
        repo.vm.network "private_network", ip: "10.10.0.13"
        repo.vm.provider "virtualbox" do |v|
            v.memory = 1024
            v.cpus = 1
        end
        repo.vm.provision :ansible do |ansible|
            ansible.limit = "repository"
            ansible.inventory_path = "provision/inventory/hosts.yml"
            ansible.playbook = "provision/provision.yml"
        end
    end

    config.vm.provision "shell", inline: "sudo apt-get update && sudo apt-get -y install python"
end
