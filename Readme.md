# Laravel Dspace


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

//...

'aliases' => [
    //...
    'LaravelDspace' => JorarMarfin\LaravelDspace\Facades\LaravelDspaceFacade::class
]
```
## Vendor publish
Publish file config
```bash
php artisan vendor:publish
```
## Parameters
* verb [ListRecords,ListMetadataFormats]
* metadataPrefix [oai_dc,qdc,didl,mods,ore,mets,oai_dc,rdf,marc,xoai,dim,etdms]
* resumptionToken [oai_dc,qdc,didl,mods,ore,mets,oai_dc,rdf,marc,xoai,dim,etdms]

## Examples
```
https://infohub.practicalaction.org/oai/request?verb=ListRecords&resumptionToken=oai_dc///com_11283_320273/0
```
Search for date
```
https://infohub.practicalaction.org/oai/request?verb=ListRecords&from=2020-02-12&until=2020-02-13&set=com_11283_320273&metadataPrefix=oai_dc

https://infohub.practicalaction.org/oai/request?verb=ListRecords&resumptionToken=oai_dc/2019-01-01T00:00:00Z/2019-12-30T00:00:00Z/com_11283_320273/100
```
