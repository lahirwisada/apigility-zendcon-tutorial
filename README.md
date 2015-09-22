# Apigility Workshop
## at ZendCon 2015 - Las Vegas (NV)

This is the hands-on part of the *Develop RESTful API in PHP using Apigility*
workshop presented by [Matthew Weier O'Phinney](https://mwop.net) and [Julien Guittard](http://julien.guittard.io) at the
[ZendCon 2015](http://zendcon.com/) conference in Las Vegasj
(NV).

The slides of the workshop are reported [here](http://www.zimuel.it/slides/phpsummer2015)

Prerequisties
---
- Install the latest version of [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
- Install the latest version of [Vagrant](https://www.vagrantup.com/downloads.html)
- Set **apigility** to point to **192.168.33.10** in your hosts file


## Installation

CD to your project folder and launch Vagrant: 

```sh 
vagrant up
```

Once box is setup and provisioned, login in ssh:

```sh 
vagrant ssh
```

Your project folder is synchronised with **/vagrant** folder in the virtual box.
CD to this folder and launch Phing:

```sh 
cd /vagrant && phing init
```

Open your browser at [http://apigility](http://apigility) and start to
use Apigility!

The first exercise of the workshop is reported [here](http://www.zimuel.it/slides/phpsummer2015/#/26).
