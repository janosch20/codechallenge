#!/usr/bin/env bash

if ! [ -L /var/www ]; then
  rm -rf /var/www/*
  ln -fs /vagrant/www /var/www/public
fi

mkdir /vagrant/www
echo "hello world" > /vagrant/www/index.html