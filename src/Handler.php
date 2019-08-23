<?php


namespace Maximnnn\Chain;


abstract class Handler
{
    abstract public function handle($request, callable $next);
}