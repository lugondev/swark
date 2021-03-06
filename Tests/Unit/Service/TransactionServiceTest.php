<?php

namespace Swark\Tests\Unit\Service;

use Shopware\Components\Test\Plugin\TestCase;
use Swark\Service\TransactionService;
use Swark\Tests\Mocks\ConnectionServiceMock;
use Swark\Tests\Mocks\LoggerMock;

/**
 * Class TransactionServiceTest
 */
class TransactionServiceTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'Swark' => [],
    ];

    public function test_construction()
    {
        $service = new TransactionService(
            new ConnectionServiceMock(),
            new LoggerMock(),
            new LoggerMock()
        );

        $this->assertInstanceOf(TransactionService::class, $service);
    }
}
