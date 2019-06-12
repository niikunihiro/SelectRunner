<?php
namespace Nielsen\SelectRunner\Resource\Page;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    protected function setUp() : void
    {
        $this->resource = (new AppInjector('Nielsen\SelectRunner', 'app'))->getInstance(ResourceInterface::class);
    }

    public function testOnGet()
    {
        $ro = $this->resource->get('page://self/index');
        $this->assertSame(200, $ro->code);
        $this->assertSame('', $ro->body['query']);
    }
}
