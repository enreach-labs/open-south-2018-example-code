Vagrant.configure(2) do |config|

    config.vm.provider :virtualbox do |vb|
        vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    end

    config.vm.define "develop" do |dev|
        dev.vm.box = "ubuntu/xenial64"
        dev.vm.network "private_network", ip: "10.10.0.10"
        dev.vm.provider "virtualbox" do |v|
            v.memory = 2096
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
    config.vm.provision "file",
        source: ".ssh/id_rsa",
        destination: "/home/vagrant/.ssh/id_rsa"
        public_key = File.read(".ssh/id_rsa.pub")

    config.vm.provision "shell",
        path: "provision/common.sh",
        privileged: false

    config.vm.provision "ansible" do |ansible|
        ansible.inventory_path = "provision/inventory/hosts.yml"
        ansible.playbook = "provision/provision.yml"
    end
end
