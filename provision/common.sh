echo 'Copying ansible-vm public SSH Keys to the VM'
mkdir -p /home/vagrant/.ssh
chmod 700 /home/vagrant/.ssh
echo '#{public_key}' >> /home/vagrant/.ssh/authorized_keys
chmod -R 600 /home/vagrant/.ssh/authorized_keys
echo 'Host 10.10.*.*' >> /home/vagrant/.ssh/config
echo 'StrictHostKeyChecking no' >> /home/vagrant/.ssh/config
echo 'UserKnownHostsFile /dev/null' >> /home/vagrant/.ssh/config
chmod -R 600 /home/vagrant/.ssh/config

sudo apt-get update
sudo apt-get -y install python