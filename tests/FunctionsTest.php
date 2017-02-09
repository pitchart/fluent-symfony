<?php

namespace Fluent\Test;

use Fluent\DefinitionHelper\CreateDefinitionHelper;
use Fluent\DefinitionHelper\ExtendDefinitionHelper;
use function Fluent\create;
use function Fluent\extend;
use PHPUnit\Framework\TestCase;

/**
 * Tests the helper functions.
 */
class FunctionsTest extends TestCase
{
    /**
     * @test
     */
    public function including_functions_twice_should_not_error()
    {
        include __DIR__ . '/../src/functions.php';
        include __DIR__ . '/../src/functions.php';

        self::assertInstanceOf(CreateDefinitionHelper::class, create());
    }

    /**
     * @test
     */
    public function create_returns_a_helper()
    {
        $helper = create();

        self::assertInstanceOf(CreateDefinitionHelper::class, $helper);
    }

    public function extend_returns_a_helper()
    {
        $helper = extend('parent_service');

        self::assertInstanceOf(ExtendDefinitionHelper::class, $helper);   
    }
}
