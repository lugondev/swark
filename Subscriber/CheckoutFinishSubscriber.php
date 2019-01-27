<?php

namespace Swark\Subscriber;

use Swark\Helper\OrderHelper;
use Swark\Services\OrderService;

/**
 * Class CheckoutFinishSubscriber
 */
class CheckoutFinishSubscriber
{
    /**
     * @var string
     */
    private $viewDir;

    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @var OrderHelper
     */
    private $orderHelper;

    /**
     * @var array
     */
    private $pluginConfig;

    /**
     * @param string $viewDir
     * @param OrderService $orderService
     * @param OrderHelper $orderHelper
     * @param array $pluginConfig
     */
    public function __construct(
        string $viewDir,
        OrderService $orderService,
        OrderHelper $orderHelper,
        array $pluginConfig
    ) {
        $this->viewDir = $viewDir;
        $this->orderService = $orderService;
        $this->orderHelper = $orderHelper;
        $this->pluginConfig = $pluginConfig;
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    public function onPostDispatchSecureCheckout(\Enlight_Event_EventArgs $args): void
    {
        $subject = $args->getSubject();
        /** @var \Enlight_View_Default $view */
        $view = $subject->View();

        if ($subject->Request()->getActionName() !== 'finish') {
            return;
        }

        $payment = $view->getAssign('sPayment');

        if (!$this->orderService->checkPayment((int)$payment['id'])) {
            return;
        }

        $view->addTemplateDir($this->viewDir);

        $orderNumber = (int)$view->getAssign('sOrderNumber');
        $attributes = $this->orderHelper->getOrder($orderNumber)->getAttribute();
        $data = $this->orderHelper->getOrderAttributes($attributes);

        $view->assign('swarkConfirmations', $this->pluginConfig['confirmations']);
        $view->assign('swarkAttributes', $data);
        $view->extendsTemplate('frontend/plugins/swark/finish.tpl');
    }
}