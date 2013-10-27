#!/usr/bin/php
<?php
/*
 *
 */

if (file_exists($shell = __DIR__.'/../shell/abstract.php')) {
    require_once $shell;
} else {
  print ('Error: File not found: "'.$shell.'"'.PHP_EOL);
}

if (file_exists($autoload = __DIR__.'/../vendor/autoload.php')) {
    require_once $autoload;
} else {
  print ('Error: File not found: "'.$autoload.'", you need to run composer install first.'.PHP_EOL);
}

class Product {
  // Compute the client's temperature and stuff that value into the callback
  public function items($cb) {
    echo ("Hi! I'm the Client in php and the server as sayed that I must run this function!".PHP_EOL);
    $product_api = new Mage_Catalog_Model_Product_Api_V2();
    $cb($product_api->items());
  }
}

class DNode extends Mage_Shell_Abstract {
  public function run() {
    $loop = new React\EventLoop\StreamSelectLoop();

    $dnode = new DNode\DNode($loop, new Product);
    $dnode->connect(6060, function($remote, $connection) {
        // Ask server for temperature in Fahrenheit
        $remote->get_product_from_client(function() use ($connection) {
            echo "done\n";
            // Close the connection
            $connection->end();
        });
    });
    $loop->run();
  }
}

$dnode = new DNode();
$dnode->run();
?>