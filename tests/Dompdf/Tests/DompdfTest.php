<?php
namespace Angrycolony\Tests;

use Angrycolony\Frame\FrameTree;
use Angrycolony\Options;
use PHPUnit_Framework_TestCase;
use Angrycolony\Dompdf;
use Angrycolony\Css\Stylesheet;
use DOMDocument;

class DompdfTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $dompdf = new Dompdf();
        $this->assertInstanceOf('Angrycolony\Adapter\Cpdf', $dompdf->getCanvas());
        $this->assertEquals('', $dompdf->getBaseHost());
        $this->assertEquals('', $dompdf->getBasePath());
        $this->assertInternalType('array', $dompdf->getCallbacks());
        $this->assertInstanceOf('Angrycolony\Css\Stylesheet', $dompdf->getCss());
        $this->assertNull($dompdf->getDom());
        $this->assertNull($dompdf->getHttpContext());
        $this->assertInstanceOf('Angrycolony\Options', $dompdf->getOptions());
        $this->assertNull($dompdf->getProtocol());
        $this->assertFalse($dompdf->getQuirksmode());
        $this->assertNull($dompdf->getTree());
    }

    public function testSetters()
    {
        $dompdf = new Dompdf();
        $dompdf->setBaseHost('test1');
        $dompdf->setBasePath('test2');
        $dompdf->setCallbacks(array('test' => array('event' => 'test', 'f' => function() {})));
        $dompdf->setCss(new Stylesheet($dompdf));
        $dompdf->setDom(new DOMDocument());
        $dompdf->setHttpContext(fopen(__DIR__ . "/_files/jamaica.jpg", 'r'));
        $dompdf->setOptions(new Options());
        $dompdf->setProtocol('test3');
        $dompdf->setTree(new FrameTree($dompdf->getDom()));

        $this->assertEquals('test1', $dompdf->getBaseHost());
        $this->assertEquals('test2', $dompdf->getBasePath());
        $this->assertCount(1, $dompdf->getCallbacks());
        $this->assertInstanceOf('Angrycolony\Css\Stylesheet', $dompdf->getCss());
        $this->assertInstanceOf('DOMDocument', $dompdf->getDom());
        $this->assertInternalType('resource', $dompdf->getHttpContext());
        $this->assertInstanceOf('Angrycolony\Options', $dompdf->getOptions());
        $this->assertEquals('test3', $dompdf->getProtocol());
        $this->assertInstanceOf('Angrycolony\Frame\FrameTree', $dompdf->getTree());
    }

    public function testLoadHtml()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<strong>Hello</strong>');
        $dom = $dompdf->getDom();
        $this->assertEquals('Hello', $dom->textContent);
    }

    public function testRender()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('<strong>Hello</strong>');
        $dompdf->render();

        $dom = $dompdf->getDom();
        $this->assertEquals('', $dom->textContent);
    }
}