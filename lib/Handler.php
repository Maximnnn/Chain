<?php


namespace Chain;


abstract class Handler
{
    abstract public function handle($request, callable $next);
}