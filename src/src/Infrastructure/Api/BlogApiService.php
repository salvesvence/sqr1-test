<?php

namespace Src\Infrastructure\Api;

class BlogApiService
{
    /**
     * @var BlogApiServiceInterface
     */
    private $service;

    /**
     * @param BlogApiServiceInterface $service
     */
    public function __construct(BlogApiServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function articles()
    {
        return $this->service->articles();
    }
}
