include_recipe "zendserver::single"

conf_plain_file '/etc/profile' do
  pattern  /\/usr\/local\/zend\/bin/
  new_line 'PATH=$PATH:/usr/local/zend/bin'
  action   :insert_if_no_match
end

conf_plain_file '/etc/profile' do
  pattern  /\/usr\/local\/zend\/lib/
  new_line 'LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/usr/local/zend/lib'
  action   :insert_if_no_match
end

conf_plain_file '/usr/local/zend/etc/php.ini' do
  current_line ';date.timezone ='
  new_line 'date.timezone = "America/Los_Angeles"'
  action   :replace
end

link "/usr/bin/php" do
  to "/usr/local/zend/bin/php"
  action :create
end

service "apache2" do
  action :restart
end