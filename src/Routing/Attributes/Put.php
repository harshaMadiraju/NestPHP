<?php

namespace NestPHP\Routing\Attributes;

use Attribute;


#[Attribute(Attribute::TARGET_METHOD)]
class Put extends Route {
    public function __construct(public string $path) {
        parent::__construct('PUT', $path);
    }
}