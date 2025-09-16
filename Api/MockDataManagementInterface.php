<?php
/**
 * Package:  MockDataGenerator
 * Author: Supravat Mondal <supravat.com@gmail.com>
 * license: MIT
 * Copyright: 2025
 * Description: Mock Data Generator Interface.
 */

namespace SMG\MockDataGenerator\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface MockDataManagementInterface
{
    /**
     * Generate mock data for entity
     *
     * @param string $entity
     * @param int $numberOfItems
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function generate(
        string $entity,
        int $numberOfItems,
        SearchCriteriaInterface $searchCriteria
    ): SearchResultsInterface;
}
