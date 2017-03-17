<?php
declare(strict_types = 1);

namespace Fluent\DefinitionHelper;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Helps defining how to create an instance of a class from a parent definition.
 *
 * @author Julien VITTE <vitte.julien@gmail.fr>
 */
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
        if ($className != null) {
            $this->definition->setClass($className);
        }
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

    /**
     * Define the entry as lazy.
     *
     * A lazy entry is created only when it is used, a proxy is injected instead.
     */
    public function lazy() : self
    {
        $this->definition->setLazy(true);

        return $this;
    }

    /**
     * Adds a tag to the current definition
     *
     * Can be used multiple times to declare multiple calls.
     *
     * @param string $name       The tag name
     * @param array  $attributes An array of attributes
     */
    public function tag(string $name, array $attributes = []) : self
    {
        $this->definition->addTag($name, $attributes);

        return $this;
    }

    /**

     * Mark the service as deprecated
     *
     * @param  string|null  $template Template message to use if the definition is deprecated
     *
     * @throws InvalidArgumentException
     */
    public function deprecate(string $template = null) : self
    {
        $this->definition->setDeprecated(true, $template);

        return $this;
    }

    /**
     * Marks the definition as private
     */
    public function private() : self
    {
        $this->definition->setPublic(false);

        return $this;
    }

}