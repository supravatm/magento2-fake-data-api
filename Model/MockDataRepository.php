<?php
/**
 * Package:  MockDataGenerator
 * Author: Supravat Mondal <supravat.com@gmail.com>
 * license: MIT
 * Copyright: 2025
 * Description: MockDataManagement Model class
 */

namespace SMG\MockDataGenerator\Model;

use SMG\MockDataGenerator\Api\MockDataManagementInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use SMG\MockDataGenerator\Model\MockDataGeneratorFactory;
use Psr\Log\LoggerInterface;

class MockDataRepository implements MockDataManagementInterface
{
    /**
     * @var SearchResultsInterfaceFactory
     */
    private SearchResultsInterfaceFactory $searchResultsFactory;
    /**
     * @var MockDataGeneratorFactory
     */
    private MockDataGeneratorFactory $mockDataGeneratorFactory;
     /**
      * @var LoggerInterface
      */
    private $logger;
    /**
     * Constructor for MockDataRepository
     *
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param MockDataGeneratorFactory $mockDataGeneratorFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        SearchResultsInterfaceFactory $searchResultsFactory,
        MockDataGeneratorFactory $mockDataGeneratorFactory,
        LoggerInterface $logger
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->mockDataGeneratorFactory = $mockDataGeneratorFactory;
        $this->logger = $logger;
    }

    /**
     * Generate method will generate MockData
     *
     * @param string $entity
     * @param int $numberOfItems
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterfaceFactory
     */
    public function generate(
        string $entity,
        int $numberOfItems,
        SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface {

        $this->logger->info(" ENTITIY: " . $entity);
        
        $mockDataGeneratorFactory = $this->mockDataGeneratorFactory->create();
        $items = [];

        if ($entity === 'customer') {
            // Customer entity
            $items = $mockDataGeneratorFactory->generateCustomer($numberOfItems);
        } elseif ($entity === 'product') {
            // For Product entity
            $items = $mockDataGeneratorFactory->generateProduct($numberOfItems);
        } elseif ($entity === 'order') {
            // For Order entity
            $items = $mockDataGeneratorFactory->orderGenerate($numberOfItems);
        }
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($items);
        $searchResults->setTotalCount($numberOfItems);
        $searchResults->setSearchCriteria($searchCriteria);

        return $searchResults;
    }
}
