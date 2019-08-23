<?php
namespace Maximnnn\Chain\Example;

use Maximnnn\Chain\Handler;

class ExampleHandler extends Handler
{

    public function handle($request, callable $next)
    {
        $request[rand(1,100)] = rand(1,100);
    }
}