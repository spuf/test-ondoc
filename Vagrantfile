Vagrant.require_version ">= 1.8.7"

Vagrant.configure("2") do |config|

    config.vm.box = "ubuntu/trusty64"

    project_root = "/data"

    config.vm.network "private_network", type: "dhcp"
    config.vm.synced_folder ".", project_root, type: "nfs"

    config.vm.provider "virtualbox" do |vb|
        vb.memory = "512"
    end

    config.vm.provision "shell", keep_color: true, privileged: false, inline: <<-SHELL
        sudo apt-get -q -y update
        sudo apt-get -q -y upgrade

        sudo add-apt-repository -y ppa:ondrej/php
        sudo apt-get -q -y update
        sudo apt-get -q -y install git php7.0 php7.0-dom php7.0-mbstring php7.0-zip

        [ ! -d $HOME/bin ] && mkdir $HOME/bin

        if [ ! -f $HOME/bin/composer ]; then
            cd $HOME/bin
            php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
            php -r "if (hash_file('SHA384', 'composer-setup.php') === 'aa96f26c2b67226a324c27919f1eb05f21c248b987e6195cad9690d5c1ff713d53020a02ac8c217dbf90a7eacc9d141d') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
            php composer-setup.php
            php -r "unlink('composer-setup.php');"
            mv composer.phar composer
            cd -
        fi;

        for s in 'export PATH="$PATH:$HOME/bin:#{project_root}/vendor/bin"' 'cd #{project_root}'; do
            grep -q -F "$s" $HOME/.bashrc || echo "$s" >> $HOME/.bashrc
        done

    SHELL

end
