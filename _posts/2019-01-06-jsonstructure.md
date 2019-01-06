---
layout: post
title: JSON Structure
excerpt: "The structure of CAIS JSON"
categories: articles
tags: [documentation]
comments: true
---


```bash
Project Manifest              # Your admin settings, the main file
.
|-- Project Name
|-- Project Subtitle
|-- auth
|-- Global Variables
|-- Libraries
|-- Project Config            # Like Web URL, DB User, etc
|-- Moduls                    # The Moduls
|   |-- Pages                 # The Pages
|       |-- Page Elements     # The Page Elements
|           |-- Forms         # The Element's Forms
|       |-- Process           # The App Process
|-- daf_api                   # The APIs
|   |-- Moduls                # The API Modul
|       |-- Actions           # The Modul's Actions
|           |-- Process       # The API Process
```
