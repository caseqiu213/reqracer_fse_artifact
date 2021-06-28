#!/bin/bash
if [ "$EUID" -ne 0 ]
  then echo "Please run with root privileges."
  exit
fi



REQRACER_ROOT=$(pwd)

export MYSQL_PASSWORD="reqracer-mysql"
export REQRACER_PREFIX=$REQRACER_ROOT/build

# apt update
apt install -y build-essential gcc g++ pkg-config \
  python-pip python-setuptools python-dev python3-pip \
  unzip git wget vim \
  libapr1-dev libaprutil1-dev libpcre3-dev \
  cmake libncurses5-dev libboost-program-options-dev \
  m4 autoconf libxml2-dev libpq-dev libpng-dev \
  libmcrypt-dev libreadline-dev libevent-dev \
  libmemcached-dev libmemcached-tools telnet \
  libcurl4-gnutls-dev libssl1.0-dev
pip3 install sqlparse untangle

mkdir -p build
## Apache HTTPD
echo "Installing Apache HTTPD"

cd $REQRACER_PREFIX/
if [ ! -f httpd-2.4.39.tar.gz ]; then
  wget https://archive.apache.org/dist/httpd/httpd-2.4.39.tar.gz
fi
tar zxvf httpd-2.4.39.tar.gz --no-same-owner
cd httpd-2.4.39
./configure --prefix=$REQRACER_PREFIX/apache --enable-so
make -j $(nproc)
make install
cd $REQRACER_PREFIX/apache

# Add ServerName 127.0.0.1 to httpd.conf
# find line Options Indexes FollowSymLinks and remove Indexes
# find line DirectoryIndex index.html and append index.php
# uncomment the line starting with LoadModule unique_id in APACHE_ROOT/conf/httpd.conf

sed -i -e '0,/#ServerName www.example.com:80/s//ServerName 127.0.0.1/' \
       -e '0,/Options Indexes FollowSymLinks/s//Options FollowSymLinks/' \
       -e '0,/DirectoryIndex index.html/s//DirectoryIndex index.html index.php/' \
       -e '0,/#LoadModule unique_id_module/s//LoadModule unique_id_module/' \
       -e '0,/Listen 80/s//Listen 8080/' \
       $REQRACER_PREFIX/apache/conf/httpd.conf

$REQRACER_PREFIX/apache/bin/apachectl -k start

echo "Apache HTTPD installed."

## End of installing HTTPD

## MySQL
echo "Installing MySQL"
cd $REQRACER_PREFIX/
if [ ! -f mysql-5.6.44.tar.gz ]; then
  wget https://downloads.mysql.com/archives/get/p/23/file/mysql-5.6.44.tar.gz
fi
tar zxvf mysql-5.6.44.tar.gz --no-same-owner
cd mysql-5.6.44
echo "Patching MySQL"
patch -p1 < ../../patch/mysql-patch.txt

./prepare_log_files.sh

# Preconfiguration setup
groupadd mysql
useradd -r -g mysql -s /bin/false mysql
# Beginning of source-build specific instructions
mkdir bld
cd bld
cmake ..
make -j $(nproc)
make install
# End of source-build specific instructions

# Postinstallation setup
cd /usr/local/mysql
./scripts/mysql_install_db --user=mysql
# Start MySQL
./bin/mysqld_safe --user=mysql &
# Setup password for root user
# Alternatively, you can run ./bin/mysql_secure_installation
sleep 5
./bin/mysqladmin -u root password "$MYSQL_PASSWORD"

# Create local client config file
cat > ~/.my.cnf <<EOL
[client]
user=root
EOL
echo "password=$MYSQL_PASSWORD">>~/.my.cnf

## End of installing MySQL

# Prepare curl for PHP
echo "Installing PHP"
ln -s /usr/include/x86_64-linux-gnu/curl /usr/include/curl

cd $REQRACER_PREFIX
# install bison 2.7
if [ ! -f bison-2.7.tar.xz ]; then
  wget https://ftp.gnu.org/gnu/bison/bison-2.7.tar.xz
fi
tar -xvf bison-2.7.tar.xz  --no-same-owner
cd bison-2.7/
chmod +x configure
mkdir build
./configure --prefix=$(pwd)/build
make -j $(nproc)
make install
sudo cp ./build/bin/bison /usr/bin/
# configure and install PHP
cd $REQRACER_PREFIX

if [ ! -f php-5.6.40.tar.gz ]; then
  wget https://www.php.net/distributions/php-5.6.40.tar.gz
fi
tar -zxvf php-5.6.40.tar.gz --no-same-owner
cd ./php-5.6.40
# echo "Patching PHP"
# patch -p1 < ../../patch/php-patch.txt
./buildconf --force

./configure --prefix=$REQRACER_PREFIX/php --with-apxs2=$REQRACER_PREFIX/apache/bin/apxs \
--with-mysql=mysqlnd --with-mysqli=mysqlnd '--enable-inline-optimization' '--disable-debug'\
'--enable-bcmath' '--enable-calendar' '--enable-ctype' '--enable-ftp' '--enable-gd-native-ttf'\
'--enable-magic-quotes' '--enable-shmop' '--disable-sigchild' '--enable-sysvsem' '--enable-sysvshm' '--enable-wddx'\
'--with-zlib=yes' '--with-kerberos' '--enable-phar' '--enable-mbstring=all' '--enable-sockets'\
'--enable-fileinfo' '--enable-zip' '--enable-intl' '--with-mcrypt' '--with-curl' '--with-gd'\
'--with-xmlrpc' '--with-openssl' '--with-pdo-mysql=mysqlnd'
make -j $(nproc)
make install
cp ./libs/libphp5.so $REQRACER_PREFIX/libphp5.orig.so
cp ./libs/libphp5.so $REQRACER_PREFIX/apache/modules 
# check if the line is uncommented: 
# LoadModule php5_module modules/libphp5.so
# paste the following two lines to the end of httpd.conf:
# AddType text/html .php
# AddHandler php5-script .php
sed -i -e '$aAddType text/html .php' \
  -e '$aAddHandler php5-script .php' \
  $REQRACER_PREFIX/apache/conf/httpd.conf

# install PHP extension xcache
echo "Installing PHP extension xcache"
cd $REQRACER_PREFIX
if [ ! -f xcache-3.2.0.tar.gz ]; then
  wget https://github.com/lighttpd/xcache/archive/refs/tags/3.2.0.tar.gz -O xcache-3.2.0.tar.gz
fi
tar -zxvf xcache-3.2.0.tar.gz --no-same-owner
cd xcache-3.2.0
$REQRACER_PREFIX/php/bin/phpize 
./configure -enable-xcache --with-php-config=$REQRACER_PREFIX/php/bin/php-config
make
make install
cp $REQRACER_ROOT/php.ini $REQRACER_PREFIX/php/lib

##
echo "Installing memcached"
cd $REQRACER_PREFIX
if [ ! -f memcached-1.6.9.tar.gz ]; then
  wget https://memcached.org/files/memcached-1.6.9.tar.gz
fi
tar -zxvf memcached-1.6.9.tar.gz --no-same-owner
cd memcached-1.6.9
./configure --prefix=$REQRACER_PREFIX/memcached
make
make install
cd memcached
echo "Starting memcached"
./bin/memcached -d -m 1024 -p 11211 -l localhost

echo "Installing PHP memcached extension"
cd $REQRACER_PREFIX
unzip ../php-memcached-REL2_0.zip
cd ./php-memcached-REL2_0/
$REQRACER_PREFIX/php/bin/phpize 
./configure --with-php-config=$REQRACER_PREFIX/php/bin/php-config
make
cp ./modules/memcached.so $REQRACER_PREFIX/php/lib/php/extensions/no-debug-zts-20131226/

## Install goreply
cd $REQRACER_PREFIX
if [ ! -f gor_1.0.0_x64.tar.gz ]; then
  wget https://github.com/buger/goreplay/releases/download/v1.0.0/gor_1.0.0_x64.tar.gz
fi
tar -zxvf gor_1.0.0_x64.tar.gz --no-same-owner
cp ./gor /usr/local/bin/

## Install phpMyAdmin
cd $REQRACER_ROOT
unzip phpMyAdmin-4.8.5-all-languages.zip -d $REQRACER_PREFIX/apache/htdocs/
cd $REQRACER_PREFIX/apache/htdocs/
mv phpMyAdmin-4.8.5-all-languages phpMyAdmin
mv phpMyAdmin/config.sample.inc.php phpMyAdmin/config.inc.php
cd $REQRACER_ROOT

## Create empty databases for wordpress bugs
/usr/local/mysql/bin/mysql < ./wordpress_db.sql

echo "Restarting Apache HTTPD"
$REQRACER_PREFIX/apache/bin/apachectl -k stop
$REQRACER_PREFIX/apache/bin/apachectl -k start
