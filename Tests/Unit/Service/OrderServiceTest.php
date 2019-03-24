<?php

namespace Swark\Tests\Unit\Service;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Service\OrderService;
use Swark\Tests\Mocks\ExchangeServiceMock;
use Swark\Tests\Mocks\LoggerServiceMock;
use Swark\Tests\Mocks\ModelManagerMock;
use Swark\Tests\Mocks\OrderHelperMock;
use Swark\Tests\Mocks\PluginHelperMock;
use Swark\Tests\Mocks\TransactionServiceMock;

/**
 * Class OrderServiceTest
 *
 * @package Swark\Tests\Unit\Service
 */
class OrderServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $service = new OrderService(
            new ModelManagerMock(),
            new OrderHelperMock(),
            new PluginHelperMock(),
            new TransactionServiceMock(),
            [],
            new LoggerServiceMock(),
            new ExchangeServiceMock()
        );

        $this->assertInstanceOf(OrderService::class, $service);
    }
}
