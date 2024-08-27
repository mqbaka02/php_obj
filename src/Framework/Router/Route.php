<?php
namespace Framework\Router;

/**
 * Class Route
 * Represents a matched route
 */
class Route
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var callable
     */
    private $callable;
    /**
     * @var array
     */
    private $params;

    public function __construct(string $name, callable $callable, array $params)
    {
        $this->name = $name;
        $this->callable = $callable;
        $this->params = $params;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }

    /**
     * Get the value of params
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
