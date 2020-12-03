<?php


namespace App;


class Request
{
    private $urlParams = [];
    private $POST;

    /**
     * Request constructor.
     * @param array $urlParams
     * @param $POST
     */
    public function __construct(array $urlParams, $POST)
    {
        $this->urlParams = $urlParams;
        $this->POST = $POST;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->urlParams;
    }
}
