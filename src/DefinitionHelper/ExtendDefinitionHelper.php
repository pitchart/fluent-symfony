<?php
declare(strict_types = 1);

namespace Fluent\DefinitionHelper;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class ExtendDefinitionHelper implements DefinitionHelper
{
	/**
	 * @var DefinitionDecorator
	 */
	private $definition;

	/**
     * Helper for defining an object.
     *
     * @param string      $entryId   
     * @param string|null $className Class name of the object.
     *                               If null, the name of the entry (in the container) will be used as class name.
     */
    public function __construct(string $entryId, string $className = null)
    {
        $this->definition = new DefinitionDecorator($entryId);
        $this->definition->setClass($className);
    }

    public function register(string $entryId, ContainerBuilder $container)
    {
        if ($this->definition->getClass() === null) {
            $this->definition->setClass($entryId);
        }

        $container->setDefinition($entryId, $this->definition);
    }

    /**
     * Overwrite an existing argument of the parent definition.
     * 
     * @param  int    $index    the position of the argument to replace
     * @param  mixed  $argument the value of the argument
     */
    public function argument(int $index, $argument) : self
    {
    	$this->definition->replaceArgument($index, $argument);

    	return $this;
    }

}