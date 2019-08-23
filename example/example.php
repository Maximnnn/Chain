<?php

use Maximnnn\Chain\Chain as Chain;
use Maximnnn\Chain\Example\ExampleHandler as Handler;

$chain = Chain::instance();

$chain = $chain->pass([])->through([Handler::class, new Handler])->run();

$result = $chain->result();
