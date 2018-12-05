Aku *sedang* belajar **menulis** dengan [markdown](https://en.wikipedia.org/wiki/Markdown)



# CAIS JSON

# JSON Structure
* Project Manifest
    * Moduls
      ​    * Pages
      ​          * Page Elements
      ​* Forms
      ​* Process
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
 ### Form Field Select
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
 ### Form Field Datepicker
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
 ### Form Field Text
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
 ### Form Field Text View
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
 ### Form Field Email
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
 ### Form Field Text Area
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
 ### Form Field Richtext
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
 ### Form Field File
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
 ### Form Field Image Upload
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

 ### Form Field Image
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
 ### Form Field Button
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

### Form Validation Minlength
```json
{
   "type": "minlength",
   "length": "1",
   "message": ""
}
```

### Form Validation Email
```json
{
  "type": "email",
  "message": ""
}
```
### Form Validation Number
```json
{
  "type": "number",
  "message": ""
}
```

# Variable

### Declaring Variable
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

# Process

### Conditional
```json
{
        "type": "condition"
        ,"from_engine": false
        ,"id":null
        ,"check_condition": [
          {
            "check":{
            "var_name": "_SESSION"
            ,"index":["akun_email"]},"operator":"==","value":{
            "var_name": "hasil_get_akun"
            ,"index":["email"]}
  }
        ]
        ,"ontrue":{
          "process": []
}
        ,"runifnotnull": []
}
```

### URL Catcher
```json
{
            "from_engine": false,
            "runifnotnull": [],
            "type": "url_catcher",
            "catch": "id",
            "variable": "hotel_id",
            "returnpackage": {}
}
```
### Database Table Insert
```json

        {
            "type": "table",
            "from_engine": false,
            "runifnotnull": [
{
"var_type": "variable",
"var_name": "data_file_param_api_fotoprofil_filename",
"index": [],
"returnpackage": {}
}
            ],
            "table_name": "tb_siswa",
            "execute": "execute",
            "id": null,
            "process_name": "insert",
            "param": [
{
"var_type": "variable",
"var_name": "param_api_tingkat_id",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_kelas_id",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_nama",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_email",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_alamat",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_sertifikat",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_handphone",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "data_file_param_api_fotoprofil_filename",
"index": [],
"returnpackage": {}
}
            ],
            "array_data": [
{
"index": "kelas_id",
"value": {
    "var_type": "variable",
    "var_name": "param_api_kelas_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "tingkat_id",
"value": {
    "var_type": "variable",
    "var_name": "param_api_tingkat_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "nama",
"value": {
    "var_type": "variable",
    "var_name": "param_api_nama",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "email",
"value": {
    "var_type": "variable",
    "var_name": "param_api_email",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "alamat",
"value": {
    "var_type": "variable",
    "var_name": "param_api_alamat",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "sertifikat",
"value": {
    "var_type": "variable",
    "var_name": "param_api_sertifikat",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "handphone",
"value": {
    "var_type": "variable",
    "var_name": "param_api_handphone",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "fotoprofil",
"value": {
    "var_type": "variable",
    "var_name": "data_file_param_api_fotoprofil_filename",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
}
            ],
            "where": [],
            "outputVariable": "hasil_insert_siswa",
            "returnpackage": {}
},
```
### Database Table Update
```json
{
            "type": "table",
            "from_engine": false,
            "runifnotnull": [],
            "table_name": "tb_siswa",
            "execute": "execute",
            "process_name": "update",
            "param": [
{
"var_type": "variable",
"var_name": "param_api_siswa_id",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_tingkat_id",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_kelas_id",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_nama",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_email",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_alamat",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_sertifikat",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_handphone",
"index": [],
"returnpackage": {}
}
            ],
            "array_data": [
{
"index": "kelas_id",
"value": {
    "var_type": "variable",
    "var_name": "param_api_kelas_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "tingkat_id",
"value": {
    "var_type": "variable",
    "var_name": "param_api_tingkat_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "nama",
"value": {
    "var_type": "variable",
    "var_name": "param_api_nama",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "email",
"value": {
    "var_type": "variable",
    "var_name": "param_api_email",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "alamat",
"value": {
    "var_type": "variable",
    "var_name": "param_api_alamat",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "sertifikat",
"value": {
    "var_type": "variable",
    "var_name": "param_api_sertifikat",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "handphone",
"value": {
    "var_type": "variable",
    "var_name": "param_api_handphone",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
}
            ],
            "where": [
{
"index": "id",
"operator": "=",
"value": {
    "var_type": "variable",
    "var_name": "param_api_siswa_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
}
            ],
            "outputVariable": "hasil_updatedata_siswa",
            "returnpackage": {}
}
```
### Database Table Delete
```json
{
            "type": "table",
            "from_engine": false,
            "runifnotnull": [
{
"var_type": "variable",
"var_name": "data_diri_siswa",
"index": [],
"returnpackage": {}
}
            ],
            "table_name": "tb_siswa",
            "execute": "execute",
            "id": "delete_tb_siswa",
            "process_name": "delete",
            "param": [
{
"var_type": "variable",
"var_name": "param_api_siswa_id",
"index": [],
"returnpackage": {}
}
            ],
            "array_data": [
{
"index": "siswa_id",
"value": {
    "var_type": "variable",
    "var_name": "param_api_siswa_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
}
            ],
            "where": [
{
"index": "id",
"operator": "=",
"value": {
    "var_type": "variable",
    "var_name": "param_api_siswa_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
}
            ],
            "outputVariable": "hasil_deletedata_siswa",
            "returnpackage": {}
}
```

### Database Table List From Table
```json
{
            "type": "table",
            "from_engine": false,
            "runifnotnull": [],
            "table_name": "tb_siswa",
            "process_name": "select",
            "execute": "many",
            "output_generate": "manual",
            "param": [
{
"var_type": "variable",
"var_name": "param_api_tingkat_id",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "param_api_kelas_id",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "obj_table_tb_jem_pelajaran",
"index": [],
"returnpackage": {}
},
{
"var_type": "variable",
"var_name": "obj_table_tb_pelajaran",
"index": [],
"returnpackage": {}
}
            ],
            "array_data": [
"id",
"nama",
"email",
"handphone",
"alamat",
"fotoprofil"
            ],
            "where": [
{
"index": "kelas_id",
"operator": "=",
"value": {
    "var_type": "variable",
    "var_name": "param_api_kelas_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
},
{
"index": "tingkat_id",
"operator": "=",
"value": {
    "var_type": "variable",
    "var_name": "param_api_tingkat_id",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
}
            ],
            "outputVariable": "hasil_get_students",
            "output": "[\"v{'var_type':'variable','var_name':'qhasil_get_students','index':['id'],'returnpackage':{}}v\",\"v{'var_type':'variable','var_name':'qhasil_get_students','index':['nama'],'returnpackage':{}}v\",\"v{'var_type':'variable','var_name':'qhasil_get_students','index':['email'],'returnpackage':{}}v\",\"v{'var_type':'variable','var_name':'hasilbridge','index':[],'returnpackage':{}}v\",\"<a href={cais_web_url}\/admin\/tabel_siswa\/edit_siswa\/id\/v{'var_type':'variable','var_name':'qhasil_get_students','index':['id'],'returnpackage':{}}v>Edit ID v{'var_type':'variable','var_name':'qhasil_get_students','index':['id'],'returnpackage':{}}v<\/a>\",\"<a href={cais_web_url}\/admin\/tabel_siswa\/delete_siswa\/id\/v{'var_type':'variable','var_name':'qhasil_get_students','index':['id'],'returnpackage':{}}v>Delete ID v{'var_type':'variable','var_name':'qhasil_get_students','index':['id'],'returnpackage':{}}v<\/a>\"]",
            "output_divider": ",",
            "process": [
{
"type": "table",
"from_engine": false,
"runifnotnull": [],
"table_name": "tb_jem_pelajaran",
"process_name": "select",
"execute": "many",
"output_generate": "manual",
"param": [
    {
        "var_type": "variable",
        "var_name": "qhasil_get_students",
        "index": [],
        "returnpackage": {}
    },
    {
        "var_type": "variable",
        "var_name": "obj_table_tb_pelajaran",
        "index": [],
        "returnpackage": {}
    }
],
"array_data": [
    "id",
    "idp",
    "ids"
],
"where": [
    {
        "index": "ids",
        "operator": "=",
        "value": {
            "var_type": "variable",
            "var_name": "qhasil_get_students",
            "index": [
"id"
            ],
            "returnpackage": {}
},
        "returnpackage": {}
    }
],
"outputVariable": "hasilbridge",
"output": "v{'var_type':'variable','var_name':'hasilpelajaran','index':[],'returnpackage':{}}v",
"output_divider": ",",
"process": [
    {
        "type": "table",
        "from_engine": false,
        "runifnotnull": [],
        "table_name": "tb_pelajaran",
        "process_name": "select",
        "execute": "many",
        "output_generate": "manual",
        "param": [
            {
"var_type": "variable",
"var_name": "qhasilbridge",
"index": [],
"returnpackage": {}
}
        ],
        "array_data": [
            "id",
            "nama"
        ],
        "where": [
            {
"index": "id",
"operator": "=",
"value": {
"var_type": "variable",
"var_name": "qhasilbridge",
"index": [
"idp"
],
"returnpackage": {}
},
"returnpackage": {}
}
        ],
        "outputVariable": "hasilpelajaran",
        "output": "v{'var_type':'variable','var_name':'qhasilpelajaran','index':['nama'],'returnpackage':{}}v",
        "output_divider": ",",
        "process": [],
        "engine": [],
        "returnpackage": {}
    }
],
"engine": [],
"returnpackage": {}
}
            ],
            "engine": [],
            "returnpackage": {}
}
```
### Database Table JSON From Table
```json
{
            "type": "table",
            "from_engine": false,
            "runifnotnull": [],
            "table_name": "tb_siswa",
            "id": null,
            "process_name": "select",
            "output_generate": "auto",
            "param": [
{

"var_type": "variable",
"var_name": "data_file_param_api_fotoprofil_filename",
"index": [],
"returnpackage": {}
}
            ],
            "array_data": [
"id"
            ],
            "where": [
{
"index": "fotoprofil",
"operator": "=",
"value": {
    
    "var_type": "variable",
    "var_name": "data_file_param_api_fotoprofil_filename",
    "index": [],
    "returnpackage": {}
},
"returnpackage": {}
}
            ],
            "execute": "one",
            "outputVariable": "hasil_get_id",
            "returnpackage": {}
}
```

### Database Table Array Index Value From Table
```json
{
            "type": "table",
            "from_engine": false,
            "runifnotnull": [],
            "table_name": "tb_tingkat",
            "execute": "many",
            "process_name": "select",
            "output_generate": "auto",
            "param": [],
            "array_data": [
"id",
"nama"
            ],
            "where": [],
            "to_array": {
"index": "id",
"value": "nama"
},
            "outputVariable": "daftar_tingkat",
            "returnpackage": {}
}
```

### Database Table Bridge
```json
{
            "type": "table",
            "from_engine": false,
            "runifnotnull": [
{

"var_type": "variable",
"var_name": "hasil_get_id",
"index": [],
"returnpackage": {}
}
            ],
            "process_name": "bridge",
            "table_name": "tb_jem_pelajaran",
            "id": null,
            "param": [
{

"var_type": "variable",
"var_name": "hasil_get_id",
"index": [
    "id"
],
"returnpackage": {}
},
{

"var_type": "variable",
"var_name": "param_api_pelajaran_favorit",
"index": [],
"returnpackage": {}
}
            ],
            "left_bridge_column": "ids",
            "right_bridge_column": "idp",
            "left_table": "tb_siswa",
            "left_table_id": "id",
            "right_table": "tb_pelajaran",
            "right_table_id": "id",
            "left_id": {

"var_type": "variable",
"var_name": "hasil_get_id_id",
"index": [],
"returnpackage": {}
},
            "right_array": {

"var_type": "variable",
"var_name": "param_api_pelajaran_favorit",
"index": [],
"returnpackage": {}
},
            "outputVariable": "hasil_bridge_pelajaran",
            "returnpackage": {}
}
```

### File Upload
```json
{
            "from_engine": false,
            "runifnotnull": [],
            "type": "fileupload",
            "id": null,
            "field": "param_api_fotoprofil",
            "file_name": "foto_profil_siswa_{param_api_nama}",
            "extension": "jpg",
            "returnpackage": {},
            "param": []
}
```

### File Delete
```json
{
            "from_engine": false,
            "runifnotnull": [
{
"var_type": "variable",
"var_name": "data_diri_siswa",
"index": [],
"returnpackage": {}
}
            ],
            "type": "file_delete",
            "id": "delete_foto_profil",
            "file_name": {
"var_type": "variable",
"var_name": "data_diri_siswa",
"index": [
"fotoprofil"
],
"returnpackage": {}
},
            "returnpackage": {},
            "param": []
}
```

# Voids

### Call Function
```json
{
"func_type": "callfunction",
"func_name": "set_idx_select_pilih_kelas",
"param": [
    "1"
],
"returnpackage": {}
}
```
### API Shooter
```json
{
"func_name": "get_pilihan_kelas",
"func_type": "api_shooter",
"type": "api_shooter",
"content_generate": "auto",
"modul": "report",
"action": "get_kelas",
"param": [
    {
        "index": "tingkat_id",
        "slash": "",
        "value": "pilihan_tingkat",
        "returnpackage": {}
    }
],
"onAPIReturn": [
    {
        "func_type": "json_extracter",
        "func_name": "extractJSONKelas",
        "type": "json_extracter",
        "func_param": [
            "this_html_response",
            "\"response_data\""
        ],
        "variable": "hasilExtractJSONKelas",
        "returnpackage": {}
    },
    {
        "func_name": "set_dropdown_pilihan_kelas",
        "func_type": "setter_dropdown",
        "type": "setter_dropdown",
        "func_param": [
            "hasilExtractJSONKelas"
        ],
        "dropdown_id": "pilih_kelas",
        "returnpackage": {}
    }
],
"returnpackage": {}
}
```
### JSON Extracter
```json
{
            "func_type": "json_extracter",
            "func_name": "extractJSONKelas",
            "type": "json_extracter",
            "func_param": [
"this_html_response",
"\"response_data\""
            ],
            "variable": "hasilExtractJSONKelas",
            "returnpackage": {}
}
```

### Change Datatable By JSON
```json
{
"func_type": "change_datatable_by_json",
"func_name": "set_isi_tabel_siswa",
"type": "change_datatable_by_json",
"func_param": [
    "hasilExtractJSON"
],
"content_generate": "auto",
"table_id": "tabel_siswa",
"returnpackage": {}
}
```
### Setter Dropdown
```json
{
"func_name": "set_dropdown_pilihan_kelas",
"func_type": "setter_dropdown",
"type": "setter_dropdown",
"func_param": [
    "hasilExtractJSONKelas"
],
"dropdown_id": "pilih_kelas",
"returnpackage": {}
}
```
### Page Jumper
```json
{
"func_name": "jumpketabel",
"func_type": "page_jumper",
"type": "page_jumper",
"page_jumper_package": [],
"func_param": [
    "\"tabel_hotel\"",
    "\"daftar_hotel\""
],
"returnpackage": {}
}
```