Aku *sedang* belajar **menulis** dengan [markdown](https://en.wikipedia.org/wiki/Markdown)



# CAIS JSON

# JSON Structure
* Project Manifest
    * Moduls
      ​    * Pages
      ​          * Page Elements
      ​                * Forms
      ​                    * Process
      ​           * Process

       * daf_api

             * Moduls
                  ​	* Actions
                  ​         	* Process

## Project Manifest
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

## Page Element : Table
```json

{
   "type": "tabel",
   "id": "",
   "title": "",
   "columns": [],
   "listeners": [],
   "forms": []
}

```
## Page Element : Form
```json
{
   "type": "form",
   "id": "",
   "title": "",
   "link": {},
   "listeners": [],
   "forms": []
}

```
## Page Form
```json
{
   "id": "",
   "div_class": "box-body",
   "attribute": {
       "": ""
   },
   "field": []
}

```
## Form Field Select
```json
{
   "type": "select",
   "id": "",
   "label": "",
   "class": "",
   "theme": "admin",
   "first_option_label": "- select -",
   "first_option_value": "-1",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form Field Datepicker
```json
{
   "type": "datepicker",
   "id": "",
   "label": "",
   "class": "",
   "theme": "normal",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form Field Text
```json
{
   "type": "text",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form Field Text View
```json
{
   "type": "text_view",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form Field Email
```json
{
   "type": "email",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form FIeld Text Area
```json
{
   "type": "textarea",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form Field Richtext
```json
{
   "type": "richtext",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form Field File
```json
{
   "type": "file",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "src": "",
   "listeners": [],
   "validation": []
}
```
## Form Field Image Upload
```json
},
               {
   "type": "image_upload",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "listeners": [
       {
           "listen": "onchange",
           "functions": []
       }
   ],
   "validation": []
}
```

## Form Field Image
```json
{
   "type": "image",
   "id": "",
   "label": "",
   "class": "form-control",
   "theme": "admin",
   "attribute": {},
   "listeners": [],
   "validation": []
}
```
## Form Field Button
```json
{
   "type": "button",
   "id": "",
   "label": "",
   "class": "btn btn-primary",
   "theme": "admin",
   "attribute": {},
   "listeners": []
}
```

# Form Validation

## Form Validation Minlength
```json
{
   "type": "minlength",
   "length": "1",
   "message": ""
}
```

## Form Validation Email
```json
{
  "type": "email",
  "message": ""
}
```
## Form Validation Number
```json
{
  "type": "number",
  "message": ""
}
```

# Variable

## Declaring Variable
```json
 {
     "var_type": "variable",
     "var_name": "Name Of Variable",
     "index": [
       "Index if array",
       "Second Index if array"
     ]
}
```

# Logic

## Conditional
```json
"check_condition": [
          {
            "check":{
            "var_name": "_SESSION"
            ,"index":["akun_email"]},"operator":"==","value":{
            "var_name": "hasil_get_akun"
            ,"index":["email"]}
          }
        ]
```
