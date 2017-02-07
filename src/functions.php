<?php
declare(strict_types = 1);

namespace Fluent;

use Fluent\DefinitionHelper\AliasDefinitionHelper;
use Fluent\DefinitionHelper\CreateDefinitionHelper;
use Fluent\DefinitionHelper\FactoryDefinitionHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

// This `if` avoids errors if importing the file twice
if (!function_exists('Fluent\create')) {

    /**
     * Helper for defining a service created by instantiating a class.
     *
     * @param string|null $className Class name of the object.
     *                               If null, the name of the entry (in the container) will be used as class name.
     */
    function create(string $className = null) : CreateDefinitionHelper
    {
        return new CreateDefinitionHelper($className);
    }

    /**
     * Helper for defining an alias.
     */
    function alias(string $targetEntryId) : AliasDefinitionHelper
    {
        return new AliasDefinitionHelper($targetEntryId);
    }

    /**
     * Reference to another service.
     */
    function get(string $entryId) : Reference
    {
        return new Reference($entryId);
    }

    /**
     * Reference to another service or null if it does not exist
     *
     * @see https://symfony.com/doc/current/service_container/optional_dependencies.html#setting-missing-dependencies-to-null
     */
    function nullIfMissing(string $entryId) : Reference
    {
        return new Reference($entryId, ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }

    /**
     * Same as nullIfMissing() but the method call is removed in case of setter injection
     *
     * @see https://symfony.com/doc/current/service_container/optional_dependencies.html#ignoring-missing-dependencies
     */
    function ignoreIfMissing(string $entryId) : Reference
    {
        return new Reference($entryId, ContainerInterface::IGNORE_ON_INVALID_REFERENCE);
    }

    /**
     * Create a service using a factory
     *
     * @param string|array $factory A PHP function or an array containing a class/Reference and a method to call
     */
    function factory($factory) : FactoryDefinitionHelper
    {
        return new FactoryDefinitionHelper($factory);
    }

    /**
     * Import another configuration file.
     */
    function import(string $resource) : Import
    {
        return new Import($resource);
    }

    /**
     * Helper for defining a service created by instantiating a class and autowire it.
     *
     * @see http://symfony.com/doc/current/components/dependency_injection/autowiring.html
     *
     * @param string|null $className Class name of the object.
     */
    function autowire(string $className = null) : CreateDefinitionHelper
    {
        return new CreateDefinitionHelper($className, true);
    }

}
