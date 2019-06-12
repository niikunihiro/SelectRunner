<?php
namespace Nielsen\SelectRunner\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    public $body = ['query' => ''];

    public function onGet() : ResourceObject
    {
        return $this;
    }

    public function onPost(string $query) : ResourceObject
    {
        $this->body['query'] = $query . PHP_EOL . $query;

        return $this;
    }
}
