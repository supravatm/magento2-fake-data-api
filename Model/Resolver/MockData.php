<?php

/**
 * Package:  SMG_MockDataGenerator
 * Author: Supravat Mondal <supravat.com@gmail.com>
 * license: MIT
 * Copyright: 2025
 * Description: MockData Resolver
 */

namespace SMG\MockDataGenerator\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use SMG\MockDataGenerator\Api\MockDataManagementInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Psr\Log\LoggerInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;

class MockData implements ResolverInterface
{
    /**
     * @var MockDataManagementInterface
     */
    private $mockDataManagementInterface;
    /**
     * @var searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * Constructor for MockData
     *
     * @param mockDataManagementInterface $mockDataManagementInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param LoggerInterface $logger
     */
    public function __construct(
        mockDataManagementInterface $mockDataManagementInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LoggerInterface $logger
    ) {
        $this->mockDataManagementInterface = $mockDataManagementInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger = $logger;
    }

    /**
     * Resolve function called by Magento GraphQL engine.
     *
     * @param Field $field
     * @param mixed $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return string
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ) {
        // Read query endpoint name
        $entity = $field->getName();

        // Extract numberOfItems argument
        $pageSize = (int) ($args['numberOfItems'] ?? 0);

        // Check max limit of numberOfItems
        if ($pageSize > 1000) {
            throw new GraphQlInputException(
                __("The 'numberOfItems' argument cannot exceed 1000. Given: %1", $pageSize)
            );
        }

        if ($pageSize <= 0) {
            throw new GraphQlInputException(
                __("The 'numberOfItems' argument must be greater than 0. Given: %1", $pageSize)
            );
        }

        // Map GraphQL field names to service methods
        $map = [
            'MockDataProduct'       => 'product',
            'MockDataOrder'     => 'order',
            'MockDataCustomer' => 'customer'
        ];
        if (!isset($map[$entity])) {
            $this->logger->error(sprintf("GraphQL Resolver error: Unknown entity '%s'", $entity));
            throw new GraphQlNoSuchEntityException(
                __('The requested resource could not be resolved.')
            );
        }
        $entityName = $map[$entity];

        $searchCriteria = $this->searchCriteriaBuilder
            ->setPageSize($pageSize)
            ->create();
        $searchResults = $this->mockDataManagementInterface->generate(
            $entityName,
            $pageSize,
            $searchCriteria
        );
        $items = $searchResults->getItems();
        
        return [
            'total_count' => $searchResults->getTotalCount(),
            'items' => $items
        ];
    }
}
