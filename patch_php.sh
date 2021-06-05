#!/bin/bash
if [ "$EUID" -ne 0 ]
  then echo "Please run with root privileges."
  exit
fi

echo "Run this script after finish installing all bug cases."

export REQRACER_ROOT=$(pwd)
export REQRACER_PREFIX=$REQRACER_ROOT/build

cd $REQRACER_PREFIX
cd ./php-5.6.40
echo "Patching PHP"
patch -p1 < ../../patch/php-patch.txt

make -j $(nproc)
make install
cp ./libs/libphp5.so $REQRACER_PREFIX/libphp5.patched.so
cp ./libs/libphp5.so $REQRACER_PREFIX/apache/modules 

echo "Restarting Apache HTTPD"
$REQRACER_PREFIX/apache/bin/apachectl -k restart
