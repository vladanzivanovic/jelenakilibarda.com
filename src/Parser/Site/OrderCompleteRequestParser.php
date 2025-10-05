<?php

declare(strict_types=1);

namespace App\Parser\Site;

use App\Entity\Address;
use App\Entity\Country;
use App\Entity\EntityInterface;
use App\Entity\OrderProduct;
use App\Entity\OrderProductTranslation;
use App\Entity\Payment;
use App\Entity\ProductTranslation;
use App\Entity\ShopOrder;
use App\Entity\User;
use App\Exception\OrderCompleteException;
use App\Repository\CountryRepository;
use App\Repository\PaymentRepository;
use App\Repository\ShippingRepository;
use App\Repository\ShopOrderRepository;
use App\Repository\UserRepository;
use App\Resolver\ShippingResolver;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class OrderCompleteRequestParser
{
    private ShopOrderRepository $orderRepository;

    private UserRepository $userRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    private PaymentRepository $paymentRepository;

    private ShippingRepository $shippingRepository;

    private CountryRepository $countryRepository;

    public function __construct(
        ShopOrderRepository $orderRepository,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        PaymentRepository $paymentRepository,
        ShippingRepository $shippingRepository,
        CountryRepository $countryRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->paymentRepository = $paymentRepository;
        $this->shippingRepository = $shippingRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * @param ParameterBag $bag
     * @param string       $orderToken
     *
     * @return ShopOrder
     * @throws \Doctrine\ORM\ORMException
     */
    public function parse(ParameterBag $bag, string $orderToken): ShopOrder
    {
        $order = $this->orderRepository->getByToken($orderToken);
        $order->setNote($bag->get('order_note'));
        $order->setCompletedAt(new \DateTime());

        $country = $this->countryRepository->find($bag->get('country'));

        $this->setUser($bag, $order);
        $this->setAddress($bag, $order, $country);
        $this->setProductsTranslation($order);
        $this->setPaymentAndShipping($order, $bag->getInt('country'), $bag->getInt('payment_type'));

        return $order;
    }

    /**
     * @param ParameterBag $bag
     * @param ShopOrder    $order
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMException
     */
    private function setUser(ParameterBag $bag, ShopOrder $order): void
    {
        $user = $this->userRepository->findOneBy([
            'email' => $bag->get('email'),
            'firstName' => $bag->get('first_name'),
            'lastName' => $bag->get('last_name'),
        ]);

        if (!$user instanceof User) {
            $user = new User();
            $user->setEmail($bag->get('email'));
            $user->setStatus(EntityInterface::STATUS_PENDING);
            $user->setFirstName($bag->get('first_name'));
            $user->setLastName($bag->get('last_name'));
        }

        if ($bag->get('create_account')) {
            $encodedPwd = $this->passwordEncoder->encodePassword($user, $bag->get('password'));
            $user->setPassword($encodedPwd);
            $user->setResetToken(bin2hex(openssl_random_pseudo_bytes(10)));
            $user->setResetRequestAt(new \DateTimeImmutable());
            $user->setRoles(['ROLE_USER']);
        }

        $user->addShopOrder($order);

        $order->setUser($user);
    }

    /**
     * @param ParameterBag $bag
     * @param ShopOrder    $order
     *
     * @return void
     */
    private function setAddress(ParameterBag $bag, ShopOrder $order, Country $country): void
    {
        if(null === $address = $order->getUser()->getAddress()) {
            $address = new Address();
            $address->setFirstName($bag->get('first_name'));
            $address->setLastName($bag->get('last_name'));
            $address->setEmail($bag->get('email'));
            $address->setCountry($country);
            $address->setCity($bag->get('city'));
            $address->setAddress($bag->get('address'));
            $address->setPhone($bag->get('mobile_phone'));
            $address->setZipCode((int) $bag->get('zip_code'));
        }

        $order->setBillingAddress($address);
        $order->setShippingAddress($address);
    }

    /**
     * @param ShopOrder $order
     *
     * @return void
     *
     * @throws \Exception
     */
    private function setProductsTranslation(ShopOrder $order): void
    {
        $orderProducts = $order->getOrderProducts();

        /** @var OrderProduct $orderProduct */
        foreach ($orderProducts->getIterator() as $orderProduct) {
            $productTrans = $orderProduct->getProduct()->getProductTranslations();

            /** @var ProductTranslation $trans */
            foreach ($productTrans->getIterator() as $trans) {
                $orderProductTrans = new OrderProductTranslation();

                $orderProductTrans->setTitle($trans->getTitle());
                $orderProductTrans->setSlug($trans->getSlug());
                $orderProductTrans->setLocale($trans->getLocale());
                $orderProductTrans->setOrderProduct($orderProduct);

                $orderProduct->addOrderProductTranslation($orderProductTrans);
            }
        }
    }

    private function setPaymentAndShipping(ShopOrder $order, int $countryId, int $paymentId)
    {
        $shipping = $this->shippingRepository->getByPaymentAndCountry($paymentId, $countryId);
        $payment = $this->paymentRepository->find($paymentId);

        $order->setShippingType($shipping);
        $order->setPayment($payment);
    }
}