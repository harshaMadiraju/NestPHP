<?php

namespace NestPHP\Routing\Attributes;

use Attribute;


#[Attribute(Attribute::TARGET_METHOD)]
class Delete extends Route {
    public function __construct(public string $path) {
        parent::__construct('DELETE', $path);
    }
}