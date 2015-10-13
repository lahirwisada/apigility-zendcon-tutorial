# Apigility Workshop
## at ZendCon 2015 - Las Vegas (NV)

This is the hands-on part of the *Develop RESTful API in PHP using Apigility*
workshop presented by [Julien Guittard](http://julien.guittard.io) and
[Matthew Weier O'Phinney](https://mwop.net) at the
[ZendCon 2015](http://zendcon.com/) conference in Las Vegas (NV).

The (in-progress) slides for the workshop are 
[available online](http://weierophinney.github.io/apigility-zendcon-slides/)

## Prerequisites

- Install [VMWare Fusion for Mac](https://my.vmware.com/web/vmware/info/slug/desktop_end_user_computing/vmware_fusion/7_0)
  or [VMWare Workstation for Windows/Linux](https://my.vmware.com/web/vmware/info/slug/desktop_end_user_computing/vmware_workstation/11_0).
  **OR**

- Install the latest version of [VirtualBox](https://www.virtualbox.org/wiki/Downloads).

- Install [Vagrant](https://www.vagrantup.com/downloads.html).

- Install [Chef DK](http://downloads.chef.io/chef-dk).

- Install Berkshelf:

  ```bash
  $ gem install berkshelf
  ```

  Depending on how you have ruby and rubygems installed, you may have to do this
  as root:

  ```bash
  $ sudo gem install berkshelf
  ```

- Install the following Vagrant plugins:

  ```bash
  $ vagrant plugin install vagrant-hostmanager
  $ vagrant plugin install vagrant-omnibus
  $ vagrant plugin install vagrant-berkshelf
  ```

- If you are using VMWare, you will need to install the plugin and register your license:

  ```bash
  $ vagrant plugin install vagrant-vmware-fusion
  $ vagrant plugin license vagrant-vmware-fusion ~/license.lic
  ```

  or

  ```bash
  $ vagrant plugin install vagrant-vmware-workstation
  $ vagrant plugin license vagrant-vmware-workstation ~/license.lic
  ```

> ### Note: Ruby version
> 
> Depending on your distribution, you may get an error indicating that your
> version of Ruby is not recent enough. Make sure you have a Ruby v2 installed,
> and check for a `gem2`, `gem2.1`, or similarly named executable on your path,
> and use that in place of `gem` in the above instructions.
>
> If you do not see a `get2` or similar, this may be an indication that you need
> to install a v2 version of Ruby. Check to see if one is available in your
> distribution package repository.

## Installation

CD to your project folder and launch Vagrant: 

```sh 
$ vagrant up
```

Once te box is setup and provisioned, login in via ssh:

```bash 
$ vagrant ssh
```

Your project folder is synchronised with the `/vagrant` folder in the virtual
machine. CD to this folder and launch Phing:

```bash 
$ cd /vagrant && phing init
```

> Sometimes this will error, due to hitting API rate limits on GitHub. If this
> occurs, try running:
>
> ```bash
> $ /usr/local/bin/composer install
> ```
>
> Using this directly will give you information on setting up a GitHub token,
> and prompt you for its sha1, allowing the install to proceed normally.

Next, set the application into development mode:

```bash
$ cd /vagrant && php public/index.php development enable
```

Open your browser at [http://localhost:8888](http://localhost:8888) and start
using Apigility!

Now get started on the [first exercise of the workshop](http://weierophinney.github.io/apigility-zendcon-slides/#/29).
