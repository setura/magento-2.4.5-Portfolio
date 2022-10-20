<?php

declare(strict_types=1);

namespace Amaro\PriceBookCatalog\Observer\Catalog;

use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Amaro\PriceBookCatalog\Model\ResourceModel\PriceBook as PriceBookResource;
use Amaro\PriceBookCustomer\Api\PriceBookInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

/**
 * ControllerProductInitAfter class
 */
class ControllerProductInitAfter implements ObserverInterface
{

    /**
     * @var HttpContext
     */
    private HttpContext $httpContext;
    /**
     * @var PriceBookResource
     */
    private PriceBookResource $priceBookResource;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var ResponseFactory
     */
    private ResponseFactory $responseFactory;
    /**
     * @var UrlInterface
     */
    private UrlInterface $url;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Dependency injection
     *
     * @param HttpContext $httpContext
     * @param PriceBookResource $priceBookResource
     * @param RequestInterface $request
     * @param ResponseFactory $responseFactory
     * @param UrlInterface $url
     * @param LoggerInterface $logger
     */
    public function __construct(
        HttpContext $httpContext,
        PriceBookResource $priceBookResource,
        RequestInterface $request,
        ResponseFactory $responseFactory,
        UrlInterface $url,
        LoggerInterface $logger
    ) {
        $this->httpContext = $httpContext;
        $this->priceBookResource = $priceBookResource;
        $this->request = $request;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
        $this->logger = $logger;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(
        Observer $observer
    ) {

        $userPriceBook = explode(",", $this->httpContext->getValue(PriceBookInterface::HTTP_CONTEXT_PRICE_BOOK));
        $productId = (int) $this->request->getParam('id');
        $productPriceBookAttributes = array_map(
            'strtolower',
            $this->priceBookResource->getPriceBookByProductId($productId)
        );

        try {
            if (!count(array_intersect($userPriceBook, $productPriceBookAttributes)) > 0) {
                $customerBeforeAuthUrl = $this->url->getUrl('noroute');
                $this->responseFactory->create()->setRedirect($customerBeforeAuthUrl)->sendResponse();
                throw new LocalizedException(__('You may need more permissions to access this product.'));
            }
        } catch (LocalizedException $exception) {
            $this->logger->info("Customer received this information: ".$exception->getMessage());
        }
    }
}
