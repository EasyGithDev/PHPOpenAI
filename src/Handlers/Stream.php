<?php

namespace EasyGithDev\PHPOpenAI\Handlers;

trait Stream
{

    protected $callback = null;

    public function default()
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
     */
    public function getCallback()
    {
        return $this->callback ?? $this->default();
    }

    /**
     * Set the value of callback
     *
     * @return  self
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;

        return $this;
    }
}
