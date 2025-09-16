<?php
/**
 * Package:  SMG_MockDataGenerator
 * Author: Supravat Mondal <supravat.com@gmail.com>
 * license: MIT
 * Copyright: 2025
 * Description: A the minimal resolver
 */

namespace SMG\MockDataGenerator\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Hello implements ResolverInterface
{

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
        $name = isset($args['name']) && $args['name'] !== '' ? $args['name'] : 'World';
        return sprintf('Hello %s — from MockData HelloGraphQl!', $name);
    }
}
