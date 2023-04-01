<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

use Closure;

/**
 * [Description Stream]
 */
trait Stream
{
    /**
     * @var null
     */
    protected ?Closure $callback = null;

    /**
     * @return Closure
     */
    public function default(): Closure
    {
        return function ($ch, $data) {
            echo $data . PHP_EOL;
            echo PHP_EOL;
            ob_flush();
            flush();
            return mb_strlen($data);
        };
    }

    /**
     * Get the value of callback
     * @return Closure
     */
    public function getCallback(): Closure
    {
        return $this->callback ?? $this->default();
    }

    /**
     * Set the value of callback
     * @param Closure $callback
     *
     * @return self
     */
    public function setCallback(Closure $callback): self
    {
        $this->callback = $callback;

        return $this;
    }
}
