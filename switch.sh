#!/bin/bash

sudo rm -r resources/assets/stylus/deployment/*
sudo rm -r resources/views/deployment/*

sudo php artisan vendor:publish --force
