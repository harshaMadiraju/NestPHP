<?php

namespace NestPHP\Routing\Attributes;

use Attribute;


#[Attribute(Attribute::TARGET_METHOD)]
class Get extends Route {
    public function __construct(public string $path) {
        parent::__construct('GET', $path);
    }
}