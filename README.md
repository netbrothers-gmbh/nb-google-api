# NetBrothers NbGoogleApi
This small library for Symfony sends requests to the GoogleMaps Places autocomplete.

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
composer require netbrothers-gmbh/nb-google-api
```

### Applications that don't use Symfony Flex


#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require netbrothers-gmbh/nbcsb-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    NetBrothers\NbGoogleApiBundle\NbGoogleApiBundle::class => ['all' => true],
];
```

## Configuration
1. Copy [`install/config/packages/netbrothers_google_api.yaml`](install/config/packages/netbrothers_google_api.yaml) 
to symfony's config path
2. Add required values to your `.env` (have a look into [install/env.default](install/env.default)):
```ymal
###> netbrothers-gmbh/netbrothers_google_api ###
NB_GOOGLE_API_ENABLE=1
NB_GOOGLE_API_PLACES_AUTOCOMPLETE_URI=https://maps.googleapis.com/maps/api/place/autocomplete/
NB_GOOGLE_API_PLACES_AUTOCOMPLETE_REQUEST_TYPE=json
NB_GOOGLE_PLACES_AUTOCOMPLETE_API_KEY=YOUR_API_KEY
###< netbrothers-gmbh/netbrothers_google_api ###
```
3. Clear symfony's cache. 

## Usage
For a first view just run the example command `bin/console netbrothers:example:google-autocomplete`.
Also have a look into [example/ExampleController.php](example/ExampleController.php) 

## Author

[Stefan Wessel, NetBrothers GmbH](https://netbrothers.de)

[![nb.logo](https://netbrothers.de/wp-content/uploads/2020/12/netbrothers_logo.png)](https://netbrothers.de)

## Licence

MIT
