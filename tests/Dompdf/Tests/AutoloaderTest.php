<?php
namespace Angrycolony\Tests;

use PHPUnit_Framework_TestCase;
use Angrycolony\Autoloader;

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
    public function testAutoload()
    {
        Autoloader::register();

        $declared = get_declared_classes();
        $declaredCount = count($declared);
        Autoloader::autoload('Foo');
        $this->assertEquals($declaredCount, count(get_declared_classes()), 'Angrycolony\\Autoloader::autoload() is trying to load classes outside of the Dompdf namespace');
        Autoloader::autoload('Angrycolony\Dompdf');
        $this->assertTrue(in_array('Angrycolony\Dompdf', get_declared_classes()), 'Angrycolony\\Autoloader::autoload() failed to autoload the Angrycolony\Dompdf class');
    }
}