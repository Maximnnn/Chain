<?php
namespace Chain;

class Chain
{
    protected $handlers = [];
    protected $request;
    protected $result;

    /**
     * @return Chain
     */
    public static function instance()
    {
        return new Chain();
    }

    /**
     * @param $request
     * @return $this
     */
    public function pass($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return mixed
     */
    public function result()
    {
        return $this->result;
    }

    /**
     * @return $this
     */
    public function run()
    {
        $this->result = $this->next(0, $this->request);

        return $this;
    }

    /**
     * @param array $handlers
     * @return $this
     * @throws \Exception
     */
    public function through(array $handlers)
    {
        foreach ($handlers as $handler) {
            if (!is_subclass_of($handler, Handler::class)) {
                throw new \Exception(sprintf('listener is not instance of %s',Handler::class));
            } else {
                $this->handlers[] = $handler;
            }
        }

        return $this;
    }

    /**
     * @param $handler
     * @return Handler
     */
    private function createHandler($handler): Handler
    {
        if (is_string($handler)) {
            return new $handler();
        }

        return $handler;
    }

    /**
     * @param int $step
     * @param $request
     * @return mixed
     */
    private function next(int $step, $request)
    {
        if (isset($this->handlers[$step])) {
            $handler = $this->createHandler($this->handlers[$step]);
        } else {
            return $request;
        }

        return $handler->handle($request, function($request) use ($step) {
            return $this->next($step + 1, $request);
        });
    }
}