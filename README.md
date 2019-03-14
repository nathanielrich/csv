# NRich\CSV

A simple universal package to easily generate or import CSV files.

### Installation
Just run this on your terminal (project dir)
```
composer require nathanielrich/csv:@dev
```
that´s it.


## Export


### Basic usage (download)

```php
$data = [
    [
        'price' => 15.99,
        'name' => 'My Product',
        'availableAt' => '2015-01-16'
    ]
];

$csvExport = new NRich\CSV\Export();
$csvExport->build($data)
    ->download();
```

And a proper CSV file will be downloaded with headers of ```$data``` index.
 

### Basic usage (save as file)

```php
$data = [
    [
        'price' => 15.99,
        'name' => 'My Product',
        'availableAt' => '2015-01-16'
    ]
];

$csvExport = new NRich\CSV\Export();
$csvExport->build($data)
    ->save('__PATH__TO__TARGET__FILE');
```

And a proper CSV file will be created at your path with headers of ```$data``` index.
 


### Basic usage (get raw data)

```php
$data = [
    [
        'price' => 15.99,
        'name' => 'My Product',
        'availableAt' => '2015-01-16'
    ]
];

$csvExport = new NRich\CSV\Export();
$csvExport->build($data)
    ->getRawData('__PATH__TO__TARGET__FILE');
```

Will return a string with csv-file-data.

### Basic usage (symfony/laravel UploadedFile)

```php
$data = [
    [
        'price' => 15.99,
        'name' => 'My Product',
        'availableAt' => '2015-01-16'
    ]
];

$csvExport = new NRich\CSV\Export();
$csvExport->build($data)
    ->getSymfonyUploadedFile('__PATH__TO__TARGET__FILE');
```

Will return the class UploadedFile of symfony´s http-foundation library.


### Usage with non custom-indexed array

```php
$data = [
    [
        15.99,
        'My Product',
        '2015-01-16'
    ]
];

$csvExport = new NRich\CSV\Export();
$csvExport->build($data, [
    'price', 'name', 'availableAt'
])
    ->download();
```


### Windows/Excel defaults
At the current version of excel or other windows based software solutions. They expect an ```;``` instead of the standard ```,```. 

You can do customize it at the constructor:
```php
$data = [
    [
        15.99,
        'My Product',
        '2015-01-16'
    ]
];

$csvExport = new NRich\CSV\Export(';');
...

```
Or you can choose the predefined windows option:
```php
$data = [
    [
        15.99,
        'My Product',
        '2015-01-16'
    ]
];

$csvExport = new NRich\CSV\Export();
$csvExport->windows()
    ->build($data)
    ->download();
...
```



## Import

### Basic usage 

```php

$csvImport = new NRich\CSV\Import();
$data = $csvImport->execute('__PATH__TO__YOUR__FILE');

print_r($data);
```

will return an array of objects from your csv file. if you wanna have an nested array instead of object you can set the second param of execute() to ```true```.