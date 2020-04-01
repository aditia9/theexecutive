<?php

namespace Ranosys\Checkout\Model;

use Ranosys\Checkout\Api\CartCountInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\QuoteIdMaskFactory;


class CartCount implements CartCountInterface {

    /**
     * store config
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $quoteIdMaskFactory;
    protected $repository;
    protected $quoteRepository;

    public function __construct(
    \Magento\Quote\Model\QuoteRepository $quoteRepository,
    \Magento\Quote\Api\CartItemRepositoryInterface $repository,
    QuoteIdMaskFactory $quoteIdMaskFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getCartCount($cartId) {

        try {
            $quote = $this->quoteRepository->get($cartId);
        } catch (\Exception $ex) {
            throw new LocalizedException(__("No such entity with this cart id"));
        }
        
        $cartCount = (int)$quote->getItemsQty();
        return $cartCount;
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function getGuestCartCount($cartId) {

        try {
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            $cartId = $quoteIdMask->getQuoteId();
            $quote = $this->quoteRepository->get($cartId);
        } catch (\Exception $ex) {
            throw new LocalizedException(__("No such entity with this cart id"));
        }
        
        $cartCount = (int)$quote->getItemsQty();
        return $cartCount;
    }

}
