---
layout: post
title: Project Manifest
excerpt: "The structure of Project Manifest"
categories: articles
tags: [documentation]
comments: true
---
```json
{
    "project_name": "Name Of The Project",
    "project_subtitle": "Name Subtitle",
    "project_config": [
        {
            "config_type": "web",
            "database_host": "",
            "database_name": "",
            "database_username": "",
            "database_password": "",
            "web_url": "",
            "web_localpath": "Path to the web folder",
            "web_description": ""
},
        {
            "config_type": "weblaravel",
            "database_host": "",
            "database_name": "",
            "database_username": "",
            "database_password": "",
            "web_url": "",
            "web_localpath": "Path to the web folder",
            "web_description": ""
}
    ],
    "auth": [],
    "moduls": [],
    "global_variables": [],
    "libraries": [],
    "daf_api": []
}
```

## Project Config
```json
{
            "config_type": "output type (web or weblaravel)",
            "database_host": "",
            "database_name": "",
            "database_username": "",
            "database_password": "",
            "web_url": "",
            "web_localpath": "Path to the web folder",
            "web_description": ""

}
```

## Moduls
```json
{
            "id": "",
            "title": "",
            "subtitle": "",
            "ignore": false,
            "placement": [
{
"place": "sidemenu"
}
            ],
            "page": []
}

```

## Pages
```json
{
"title": "",
"subtitle": "",
"frame": "adminpage",
"id": "",
"ignore": false,
"placement": [
    {
   "place": "sidemenu"
    }
],
"elemen": [],
"functions": [],
"process": [],
"engine": []
}
```
