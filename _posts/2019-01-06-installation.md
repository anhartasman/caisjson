---
layout: post
title: Installation
excerpt: "How to install CAIS JSON"
categories: articles
tags: [documentation]
comments: true
---


## Vanilla
* Copy vanilla folder to your htdocs and rename as you like
* Copy contents of CB Folders/web to your vanilla folder

## Laravel

* Create laravel project with composer
* Create helper file with name helpers.php in app folder (app/helpers.php)
* Remove public from your url so it is become localhost/yourweb/admin and not localhost/yourweb/public/admin
* Copy contents of CB Folders/weblaraver to your laravel folder

# How to use it

* Write your JSON files inside caisjson/thejson
* access http://localhost/caisjson/?job=compile&platform=weblaravel&main_file=main_file from web
* platform=weblaravel is tell compiler to make laravel program
* main_file=main_file is to open thejson/main_file.json and execute it as the project manifest file
* You can create different main file for different project

# Documentations

For more documentations, read the wiki page :)
