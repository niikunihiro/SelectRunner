<?php
namespace Nielsen\SelectRunner\Resource\Page;

use BEAR\Resource\ResourceObject;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;
use SqlFormatter;

class Index extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    /** @var SqlFormatter */
    private $sqlFormatter;

    public $body = ['query' => '', 'result' => []];

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

        $results = $this->pdo->fetchAll($query);
        if (!empty($results)) {
            $this->body['results'] = $results;

            $this->body['headers'] = array_keys($results[0]);
        }

        return $this;
    }
}
