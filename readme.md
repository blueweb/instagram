# Instagram Extension

## Installation

Best way to install this is using composer:

	composer require blueweb/instagram
	
Then register extension:
	
	extensions:
        instagram: Blueweb\Instagram\DI\InstagramExtension
        
    instagram:
    	apiKey: <your_api_key>
        
## Usage

Register service:

    /**
     * @var Blueweb\Instagram\Client\InstagramClient
     * @autowire
     */
    protected $instagram;
	
and call `->fetchData`. Fetch data will return a **multidimensional array** or **throw RequestException**.
