<?php

declare(strict_types=1);

namespace App\Parser\Site;

use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Entity\ProductExtension;
use App\Entity\ShopOrder;
use App\Repository\ImageRepository;
use App\Repository\OrderProductRepository;
use App\Repository\ProductColorRepository;
use App\Repository\ShopOrderRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

final class OrderEditRequestParser
{
    private OrderProductRepository $productRepository;

    private ProductColorRepository $colorRepository;

    private ImageRepository $imageRepository;

    private ShopOrderRepository $orderRepository;

    public function __construct(
        OrderProductRepository $orderProductRepository,
        ProductColorRepository $colorRepository,
        ImageRepository $imageRepository,
        ShopOrderRepository $orderRepository
    ) {
        $this->productRepository = $orderProductRepository;
        $this->colorRepository = $colorRepository;
        $this->imageRepository = $imageRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @return ShopOrder
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function parse(Request $request, ProductExtension $product): ShopOrder
    {
        $session = $request->getSession();
        $order = null;

        if (true === $session->isStarted() && $session->has('order')) {
            $order = $this->orderRepository->getByToken($session->get('order'));
        }

        if (!$order instanceof ShopOrder) {
            $order = $this->create();
            $order->setStatus(ShopOrder::STATUS_NEW);
            $order->setToken();
        }

        $this->setProduct($request->request, $product, $order);

        return $order;
    }

    private function setProduct(ParameterBag $bag, ProductExtension $product, ShopOrder $order): void
    {
        $color = $this->colorRepository->find($bag->getInt('color'));
        $orderProduct = $this->productRepository->findOneBy([
            'orderId'   => $order,
            'product'   => $product,
            'size'      => $bag->get('size'),
            'color'     => $color,
        ]);

        if (null == $orderProduct) {
            $orderProduct = new OrderProduct();
        }

        $orderProduct->setProduct($product);
        $orderProduct->setOrderId($order);
        $orderProduct->setColor($color);
        $orderProduct->setSize($bag->get('size'));
        $orderProduct->setQuantity($bag->getInt('quantity'));
        $orderProduct->setImage($this->imageRepository->getMainByProduct($product));
        $orderProduct->setPrice($product->getPrice());
        $orderProduct->setCode($product->getFirstCode()->getCode());
        $orderProduct->setDiscount($product->getDiscount());

        $order->addOrderProduct($orderProduct);
    }

    public function create(): ShopOrder
    {
        return new ShopOrder();
    }
}