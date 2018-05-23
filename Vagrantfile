Vagrant.configure(2) do |config|

    config.vm.provider :virtualbox do |vb|
        vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    end

    config.vm.define "jenkins" do |jen|
        jen.vm.box = "ubuntu/xenial64"
        jen.vm.network "private_network", ip: "10.10.0.10"
        jen.vm.provider "virtualbox" do |v|
            v.memory = 4096
            v.cpus = 1
        end
    end

    config.vm.define "test" do |test|
        test.vm.box = "ubuntu/xenial64"
        test.vm.network "private_network", ip: "10.10.0.11"
        test.vm.provider "virtualbox" do |v|
            v.memory = 1024
            v.cpus = 1
        end
    end

    config.vm.define "staging" do |sta|
        sta.vm.box = "ubuntu/xenial64"
        sta.vm.network "private_network", ip: "10.10.0.12"
        sta.vm.provider "virtualbox" do |v|
            v.memory = 1024
            v.cpus = 1
        end
    end

    (1..2).each do |i|
        config.vm.define "prod#{i}" do |prod|
            prod.vm.box = "ubuntu/xenial64"
            prod.vm.network "private_network", ip: "10.10.0.#{20+i}"
            prod.vm.provider "virtualbox" do |v|
                v.memory = 1024
                v.cpus = 1
            end
        end
    end
    config.vm.provision "file", source: ".ssh/id_rsa", destination: "/home/vagrant/.ssh/id_rsa"
        public_key = File.read(".ssh/id_rsa.pub")
    config.vm.provision :shell, :inline =>"
        echo 'Copying ansible-vm public SSH Keys to the VM'
        mkdir -p /home/vagrant/.ssh
        chmod 700 /home/vagrant/.ssh
        echo '#{public_key}' >> /home/vagrant/.ssh/authorized_keys
        chmod -R 600 /home/vagrant/.ssh/authorized_keys
        echo 'Host 10.10.*.*' >> /home/vagrant/.ssh/config
        echo 'StrictHostKeyChecking no' >> /home/vagrant/.ssh/config
        echo 'UserKnownHostsFile /dev/null' >> /home/vagrant/.ssh/config
        chmod -R 600 /home/vagrant/.ssh/config
        ", privileged: false
    config.vm.provision "shell", inline: "sudo apt-get update && sudo apt-get -y install python"
    config.vm.provision :ansible do |ansible|
        ansible.inventory_path = "provision/inventory/local/hosts.yml"
        ansible.playbook = "provision/provision.yml"
    end
end

