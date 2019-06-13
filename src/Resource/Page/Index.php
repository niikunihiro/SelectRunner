<?php
namespace Nielsen\SelectRunner\Resource\Page;

use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\StatusCode;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;
use SqlFormatter;

class Index extends ResourceObject
{
    use AuraSqlInject;

    /** @var SqlFormatter */
    private $sqlFormatter;
    /** @var FormInterface */
    protected $form;

    public $body = ['query' => '', 'result' => [], 'error' => ''];

    /**
     * Index constructor.
     * @param SqlFormatter  $sqlFormatter
     */
    public function __construct(SqlFormatter $sqlFormatter)
    {
        $this->sqlFormatter = $sqlFormatter;
    }

    /**
     * @param FormInterface $form
     *
     * @Inject
     * @Named("query_form")
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
    }

    public function onGet() : ResourceObject
    {
        $this->body['form'] = $this->form;

        return $this;
    }

    /**
     * @param string $query
     * @return ResourceObject
     *
     * @FormValidation()
     */
    public function onPost(string $query) : ResourceObject
    {
        try {
            $results = $this->pdo->fetchAll($query);
            if (!empty($results)) {
                $this->body['results'] = $results;

                $this->body['headers'] = array_keys($results[0]);
            }
            $query = $this->sqlFormatter->format($query, false);
        } catch (\Exception $e) {
            $this->body['error'] = $e->getMessage();
        }

        $this->form->query = $query;
        $this->body['form'] = $this->form;

        return $this;
    }

    public function onPostValidationFailed() : ResourceObject
    {
        $this->code = StatusCode::BAD_REQUEST;

        return $this->onGet();
    }
}
