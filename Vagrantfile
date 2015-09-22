# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.require_version ">= 1.7.4"
require 'time'

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "bento/ubuntu-14.04"
  config.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "www-data", mount_options: ['dmode=775', 'fmode=775']

  config.vm.define 'zendcon-api-box' do |node|
    node.vm.network "private_network", ip: "192.168.33.10"
    node.vm.hostname = "apigility"
    node.vm.network "forwarded_port", guest: 80, host: 8888
    node.vm.network "forwarded_port", guest: 10081, host: 10091
    node.vm.network "forwarded_port", guest: 10082, host: 10092
    node.hostmanager.aliases = %w(apigility)
  end

  config.vm.provision "chef_solo" do |chef|
    chef.version = "12.3.0"
    chef.cookbooks_path = ["cookbooks"]

    chef.json = {
      zendserver: {
        version: "8.5.1",
        phpversion: "5.6",
        basedirdeb: "deb_apache2.4",
        adminpassword: "admin",
        production: "false",
        apikeyname: "zendcon",
        apikeysecret: "2e0c359cbf036f0931e3556a0deb84cfba88eb052d32a90eb935890299e870a8", # Needs to be 64 alnum characters
        adminemail: "support@zend.com",
        directives: {
          error_reporting: "E_ALL",
          display_errors: "1",
          display_startup_errors: "1"
        }
      },
      apache: {
          mpm: "prefork"
      },
    }
    chef.run_list = [
      "recipe[build-essential]",
      "recipe[conf]",
      "recipe[zendserver::single]",
      "recipe[apache]",
      "recipe[git]",
      "recipe[tools::phing]",
      "recipe[tools::composer]"
    ]
  end
end

ENV['VAGRANT_DEFAULT_PROVIDER'] = 'virtualbox'