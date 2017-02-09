<?php

namespace Fluent\Test;

use function Fluent\create;
use function Fluent\extend;
use Fluent\PhpConfigLoader;
use Fluent\DefinitionHelper\ExtendDefinitionHelper;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Tests extend() definitions.
 */
class ExtendTest extends TestCase
{
	public function test_extend_with_class_name_provided()
    {
    	$parent = new class() {
            public function __construct()
            {
                $this->arguments = func_get_args();
            }
        };
        $parentClassName = get_class($parent);

        $child = new class() {
            public function __construct()
            {
                $this->arguments = func_get_args();
            }
        };
        $childClassName = get_class($child);

        $container = new ContainerBuilder;
        (new PhpConfigLoader($container))->load([
            'foo' => create($parentClassName)->arguments(3),
            'bar' => extend('foo', $childClassName)
        ]);
        $container->compile();
        self::assertEquals([3], $container->get('bar')->arguments);
    }

    public function test_create_with_class_name_as_array_key()
    {
    	$parent = new class() {
            public function __construct()
            {
                $this->arguments = func_get_args();
            }
        };
        $parentClassName = get_class($parent);

        $child = new class() {
            public function __construct()
            {
                $this->arguments = func_get_args();
            }
        };
        $childClassName = get_class($child);

        $container = new ContainerBuilder;
        (new PhpConfigLoader($container))->load([
            'foo' => create($parentClassName)->arguments(3),
             $childClassName => extend('foo')
        ]);
        $container->compile();
        self::assertEquals([3], $container->get($childClassName)->arguments);	
    }

    public function test_child_services_can_overwrite_injected_arguments()
    {
    	$parent = new class() {
            public function __construct()
            {
                $this->arguments = func_get_args();
            }
        };
        $parentClassName = get_class($parent);

        $child = new class() {
            public function __construct()
            {
                $this->arguments = func_get_args();
            }
        };
        $childClassName = get_class($child);

        $container = new ContainerBuilder;
        (new PhpConfigLoader($container))->load([
            'foo' => create($parentClassName)->arguments(3),
            'bar' => extend('foo', $childClassName)->argument(0, 12)
        ]);
        $container->compile();
        self::assertEquals([12], $container->get('bar')->arguments);
    }
}