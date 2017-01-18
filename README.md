


## FanCourier API Client

A simple FanCourier implementation for Laravel.

## Installation

Install the package through [Composer](http://getcomposer.org/). 

Run the Composer require command from the Terminal:

    composer require seniorprogramming/fancourier:dev-master

Now all you have to do is add the service provider of the package and alias the package. To do this open your `config/app.php` file.

Add a new line to the `providers` array:

	SeniorProgramming\FanCourier\Providers\ApiServiceProvider::class,

And optionally add a new line to the `aliases` array:

	'FanCourier' => SeniorProgramming\FanCourier\Facades\FanCourier::class,

Important, add in .env FanCourier credentials:

```env
FANCOURIER_USERNAME=
FANCOURIER_PASSWORD=
FANCOURIER_CLIENT_ID=
```

Now you're ready to start using the FanCourier API Client in your application.


## Overview
Look at one of the following topics to learn more about FanCourier API Clien

* [Usage](#usage)
* [Exceptions](#exceptions)
* [Example](#example)

## Usage

The FanCourier API Client gives you the following methods to use:

### FanCourier::city()

Retrieves cities based on county if specificed and other info.

```php
FanCourier::city()
```
**The `city()` method will return an array of objects with: judet, localitate, agentie, km, cod_rutare, id_localitate_fan.**

### FanCourier::streets()

Retrieves streets based on county or city if specificed and other info.

```php
FanCourier::streets()
```
**The `streets()` method will return an array of objects with: judet, localitate, strada, de_la, pana_la, paritate, cod_postal, tip, cod_cartare, numar_depozite.**

### FanCourier::price()

Retrieve price based on service, package and distance

```php
FanCourier::price()
```

**The `price()` method will return a double.**

### FanCourier::trackAwb()

Track expedition using AWB code. 

```php
FanCourier::trackAwb()
```

**The `trackAwb()` method will return a plain text.**


### FanCourier::generateAwb()

Send orders to generate AWB

```php
FanCourier::generateAwb()
```

**The `generateAwb()` method will return an array of objects with: line, awb, send_params, error_message.**


### FanCourier::order()

Place a order to a FanCourier Agent. The agent will come a pick-up the package at requested hour, in the same day

```php
FanCourier::order()
```

**The `order()` method will return a plain message if the request is made successfully **

### FanCourier::exportAwbErrors()

All FanCourier AWB with errors.

```php
FanCourier::exportAwbErrors()
```

**The `exportAwbErrors()` method will return an empty array  or with objects containing: nume, judet, localitate, telefon, plicuri, colete, greutate, descriere.**


### FanCourier::deleteAwb()

Deletes AWB only if the shipping process is not finished. 

```php
FanCourier::deleteAwb()
```

**The `deleteAwb()` method will return an int if the request is made successfully or the error message.**


### FanCourier::getAwb()

Returns documents containing shipping details. 

```php
FanCourier::getAwb()
```

**The `getAwb()` method will return a html page containing documents that can be printed if the request is made successfully or the error message.**

### FanCourier::downloadAwb()

Returns AWB document in jpg format.

```php
FanCourier::downloadAwb()
```

**The `downloadAwb()` method will return a jpg if the request is made successfully or the error message.**


### FanCourier::exportOrders()

All orders made within selected date through FanCourier::order method.

```php
FanCourier::exportOrders()
```

**The `exportOrders()` method will return an empty array  or with objects containing: nr._crt., data_ridicare_comanda, ora_de_la, ora_pana_la, persoana_contact, telefon, email, colete, numar_comanda, status.**

### FanCourier::exportBorderou()

All orders made within selected date through FanCourier::generateAwb method. 

```php
FanCourier::exportBorderou()
```

**The `exportBorderou()` method will return an empty array  or with objects containing: nr._crt., awb, ridicat, status, data_confirmarii, restituire, tip_serviciu, continut...**

### FanCourier::exportReports()

Returns all expeditions that have placed the total amount in the deposit account within selected date for the bank transfer.

```php
FanCourier::exportReports()
```

**The `exportReports()` method will return an empty array  or with objects containing: oras_destinatar, dat_awb, suma_incasata, numar_awb, numar_awb, expeditor, destinatar, continut, persoanaD, data_virament, persoanaE, ramburs_la_awb, awb_retur**

### FanCourier::exportObservations()

Returns all observations that can be set when an expedition is requested. 

```php
FanCourier::exportObservations()
```

**The `exportObservations()` method will return an empty array  or with objects containing: observatii_fan_courier**

### FanCourier::endBorderou()

Will close all orders made for the current date. 

```php
FanCourier::endBorderou()
```

**The `endBorderou()` method will return a html **


## Exceptions

The FanCourier package will throw exceptions if something goes wrong. This way it's easier to debug your code using the FanCourier package or to handle the error based on the type of exceptions. The FanCourier packages can throw the following exceptions:

| Exception                         | 
| ----------------------------------|
| *FanCourierInstanceException*     | 
| *FanCourierInvalidParamException* |                  
| *FanCourierUnknownModelException* |  


## Example

**FanCourier::city()**
To fetch specific county
```php
FanCourier::city(['judet'=>'Constanta', 'language'=>'RO'])
```
or to fetch all counties

```php
FanCourier::city()
```

**FanCourier::streets()**
To fetch specific county
```php
FanCourier::streets(['judet'=>'Bucuresti', 'localitate'=>'Bucuresti', 'language'=>'RO'])
```
or to fetch all streets from Romania

```php
FanCourier::streets()
```

**FanCourier::price()**
Internal service
```php
FanCourier::price([
    'serviciu' => 'standard',
    'localitate_dest' => 'Targu Mures',
    'judet_dest' => 'Mures',
    'plicuri' => 1,
    'colete' => 2,
    'greutate' => 5,
    'lungime' => 10,
    'latime' => 10,
    'inaltime' => 10,
    'val_decl' => 600,
    'plata_ramburs' => 'destinatar',
    'plata_la' => 'expeditor',
])
```

External service
```php
FanCourier::price([
    'serviciu' => 'export',
    'modtrim' => 'rutier', //aerian
    'greutate' => 10.22,
    'pliccolet' => 3,
    's_inaltime' => 50,
    's_latime' => 67,
    's_lungime' => 48,
    'volum' => 400,
    'dest_tara' => 'Bulgaria',
    'tipcontinut' => 1,
    'km_ext' => 400,
    'plata_la' => 'destinatar',
])
```


**FanCourier::order()**
Internal service
```php
FanCourier::generateAwb(['fisier' => [
    [
        'tip_serviciu' => 'standard', 
        'banca' => '',
        'iban' =>  '',
        'nr_plicuri' => 1,
        'nr_colete' => 0,
        'greutate' => 1,
        'plata_expeditie' => 'ramburs',
        'ramburs_bani' => 100,
        'plata_ramburs_la' => 'destinatar',
        'valoare_declarata' => 400,
        'persoana_contact_expeditor' => 'Test User',
        'observatii' => 'Lorem ipsum',
        'continut' => '',
        'nume_destinar' => 'Test',
        'persoana_contact' => 'Test',
        'telefon' => '123456789',
        'fax' => '123456789',
        'email' => 'example@example.com',
        'judet' => 'Galati',
        'localitate' => 'Tecuci',
        'strada' => 'Lorem',
        'nr' => '2',
        'cod_postal' => '123456',
        'bl' => '',
        'scara' => '',
        'etaj'  => '',
        'apartament' => '',
        'inaltime_pachet' => '',
        'lungime_pachet' => '',
        'restituire' => '',
        'centru_cost' => '',
        'optiuni' => '',
        'packing' => '',
        'date_personale' => ''
    ],
    [
        'tip_serviciu' => 'Cont colector',
        'banca' => 'Test',
        'iban' =>  'XXXXXX',
        'nr_plicuri' => 0,
        'nr_colete' => 1,
        'greutate' => 1,
        'plata_expeditie' => 'ramburs',
        'ramburs_bani' => 400,
        'plata_ramburs_la' => 'destinatar',
        'valoare_declarata' => 400,
        'persoana_contact_expeditor' => 'Test User',
        'observatii' => 'Lorem ipsum',
        'continut' => 'Fragil',
        'nume_destinar' => 'Test',
        'persoana_contact' => 'Test',
        'telefon' => '123456789',
        'fax' => '123456789',
        'email' => 'example@example.com',
        'judet' => 'Galati',
        'localitate' => 'Tecuci',
        'strada' => 'Lorem',
        'nr' => '2',
        'cod_postal' => '123456',
        'bl' => '',
        'scara' => '',
        'etaj'  => '',
        'apartament' => '',
        'inaltime_pachet' => '',
        'lungime_pachet' => '',
        'restituire' => '',
        'centru_cost' => '',
        'optiuni' => '',
        'packing' => '',
        'date_personale' => ''
    ]
]])
```

**FanCourier::trackAwb()**
```php
FanCourier::trackAwb([
    'AWB'=>'2337600120003', 
    'display_mode' => 3 //1 – last status, 2 – last record from history route, 3 – all history of the expedition
])
```

**FanCourier::order()**
Internal service
```php
FanCourier::order([
    'nr_colete' => 1, // or 'nr_plicuri' => 1
    'pers_contact' => 'Test',
    'tel' => 123456789,
    'email' => 'example@example.com',
    'greutate' => 1,
    'inaltime' => 10,
    'lungime' => 10,
    'latime' => 10,
    'ora_ridicare' => '18:00',
    'observatii' => '',
    'client_exp' => 'Test',
    'strada' => 'Test',
    'nr' => 1,
    'bloc' => 2,
    'scara' => 3,
    'etaj' => 7,
    'ap' => 78,
    'localitate' => 'Constanta',
    'judet' => 'Constanta',
])
```


**FanCourier::exportServices()**

```php
FanCourier::exportServices()
```

**FanCourier::exportAwbErrors()**

```php
FanCourier::exportAwbErrors()
```

**FanCourier::getAwb()**

```php
FanCourier::getAwb([
    'nr'=>'2337600120003', //AWB
])
```

**FanCourier::downloadAwb()**

```php
FanCourier::downloadAwb([
    'AWB'=>'2337600120003',
])
```

**FanCourier::exportOrders()**

```php
FanCourier::exportOrders(['data'=>'09.12.2016'])
```

**FanCourier::exportBorderou()**

```php
FanCourier::exportBorderou(['data'=>'09.12.2016', 'mode'=> 0])
```

**FanCourier::exportReports()**

```php
FanCourier::exportReports(['data'=>'09.12.2016'])
```


**FanCourier::exportObservations()**

```php
FanCourier::exportObservations()
```

**FanCourier::endBorderou()**

```php
FanCourier::endBorderou()
```
