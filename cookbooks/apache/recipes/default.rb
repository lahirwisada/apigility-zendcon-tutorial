template "/etc/apache2/sites-available/vagrant.conf" do
  source "vhost.erb"
end

file "/etc/apache2/sites-enabled/000-default" do
  action :delete
end

link "/etc/apache2/sites-enabled/vagrant.conf" do
  to "/etc/apache2/sites-available/vagrant.conf"
  action :create
end

service "apache2" do
  action :restart
end