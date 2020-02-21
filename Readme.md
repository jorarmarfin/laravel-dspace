# Laravel Dspace
[![Latest Stable Version](https://poser.pugx.org/jorarmarfin/laravel-dspace/v/stable)](https://packagist.org/packages/jorarmarfin/laravel-dspace) 
[![Total Downloads](https://poser.pugx.org/jorarmarfin/laravel-dspace/downloads)](https://packagist.org/packages/jorarmarfin/laravel-dspace)
[![Latest Unstable Version](https://poser.pugx.org/jorarmarfin/laravel-dspace/v/unstable)](https://packagist.org/packages/jorarmarfin/laravel-dspace)
[![License](https://poser.pugx.org/jorarmarfin/laravel-dspace/license)](https://packagist.org/packages/jorarmarfin/laravel-dspace)
[![Monthly Downloads](https://poser.pugx.org/jorarmarfin/laravel-dspace/d/monthly)](https://packagist.org/packages/jorarmarfin/laravel-dspace)
[![Daily Downloads](https://poser.pugx.org/jorarmarfin/laravel-dspace/d/daily)](https://packagist.org/packages/jorarmarfin/laravel-dspace)
[![composer.lock](https://poser.pugx.org/jorarmarfin/laravel-dspace/composerlock)](https://packagist.org/packages/jorarmarfin/laravel-dspace)

## Installation
The LaravelYoutube service provider can be installed via [composer](http://getcomposer.org) by requiring the `jorarmarfin/laravel_youtube` package in your project's composer.json.

Laravel 5.5+ will use the auto-discovery function.

```json
{
    "require": {
        "jorarmarfin/laravel-dspace": "0.0.1"
    }
}
```

If you don't use auto-discovery you will need to include the service provider / facade in `config/app.php`.


```php
'providers' => [
    //...
    JorarMarfin\LaravelDspace\LaravelDspaceServiceProvider::class,
]
```
## Vendor publish
By default, LaravelDspace will connect to https://mydspace.com, you can change this and the other settings in the configuration file. You can add the elasticquent.php config file at /app/config/dspace.php, this package has a table (resource) where to harvest the information from the dspace that is why you must run the migration before using the method
```bash
php artisan vendor:publish --provider="JorarMarfin\LaravelDspace\LaravelDspaceServiceProvider"
```
```php
<?php

return[

    /*
    |--------------------------------------------------------------------------
    | url enlace del repositorio
    |--------------------------------------------------------------------------
    |
    | Enlace de conexion al repositorio Dspace que desea cosechar
    |
    */

    'url' => env('DSPACE_URL', 'https://infohub.practicalaction.org/'),



];
```
```bash
php artisan migrate
```
## How to use it
To gather information from dspace we must know the nomenclature of oai-pmh
## Parameters
* verb [ListRecords,ListMetadataFormats]
* metadataPrefix [oai_dc,qdc,didl,mods,ore,mets,oai_dc,rdf,marc,xoai,dim,etdms]
* resumptionToken [oai_dc,qdc,didl,mods,ore,mets,oai_dc,rdf,marc,xoai,dim,etdms]
### Methods
* getData : return data format json
* Harvest : retriv data to table resource, no acepta el parametro verb, por defecto cosecha del metadataPrefix etdms, but you can send this value to harvest from another metadataPrefix, also accepts the from and until parameters to harvest by dates
## Commands

### Examples
```php
use LaravelDspace;

public function index()
{
    $data = LaravelDspace::getData(['verb'=>'ListRecords','set'=>'com_11283_320273','metadataPrefix'=>'etdms'])
    $data1 = LaravelDspace::Harvest(['set'=>'com_11283_320273']);
    return $data;
}
```
## Examples
```
https://infohub.practicalaction.org/oai/request?verb=ListRecords&resumptionToken=oai_dc///com_11283_320273/0
```
Search for date
```
https://infohub.practicalaction.org/oai/request?verb=ListRecords&from=2020-02-12&until=2020-02-13&set=com_11283_320273&metadataPrefix=oai_dc

https://infohub.practicalaction.org/oai/request?verb=ListRecords&resumptionToken=oai_dc/2019-01-01T00:00:00Z/2019-12-30T00:00:00Z/com_11283_320273/100
```
