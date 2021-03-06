# KitPaginatorBundle
Support Native Sql Query for KnpPaginatorBundle


## Installation
 
### Step 1: Download the Bundle
---------------------------
 
Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:
 
	
	$ composer require kitlabs/kit-paginator-bundle

 
This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.
 
### Step 2: Enable the Bundle
---------------------------
 
Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

	<?php
	// app/AppKernel.php
	 
	// ...
	class AppKernel extends Kernel
	{
	    public function registerBundles()
	    {
	        $bundles = array(
	            // ...
	 
	            new Kit\PaginatorBundle\KitPaginatorBundle(),
	        );
	 
	        // ...
	    }
	 
	    // ...
	}

### Step 3: Configuration 

	# config.yml
## Usage

	$paginator = $this->get('kit_paginator');
    $pagination = $paginator->paginate($query, $page, $pagesize, $connection = null, $total = null);
