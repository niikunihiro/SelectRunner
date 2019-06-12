<?php
namespace Nielsen\SelectRunner\Resource\Page;

use BEAR\Resource\ResourceObject;
use SqlFormatter;

class Index extends ResourceObject
{
    /** @var SqlFormatter */
    private $sqlFormatter;

    public $body = ['query' => ''];

    public function __construct(SqlFormatter $sqlFormatter)
    {
        $this->sqlFormatter = $sqlFormatter;
    }

    public function onGet() : ResourceObject
    {
        return $this;
    }

    public function onPost(string $query) : ResourceObject
    {
        $query = $this->sqlFormatter->format($query, false);
        $this->body['query'] = $query;

        return $this;
    }
}
