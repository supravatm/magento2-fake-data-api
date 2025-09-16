<?php

/**
 * Package:  src
 * Author: Supravat Mondal <supravat.com@gmail.com>
 * license: MIT
 * Copyright: 2025
 * Description: A brief description of the file's purpose.
 */

namespace SMG\MockDataGenerator\Model;

use Faker\Factory as FakerFactory;

class MockDataGenerator
{
    /**
     *
     * @var FakerFactory
     */
    protected FakerFactory $fakerFactory;
    /**
     * Constructor for Class MockDataGenerator
     *
     * @param FakerFactory $fakerFactory
     */
    public function __construct(FakerFactory $fakerFactory)
    {
        $this->fakerFactory = $fakerFactory;
    }
    /**
     * Generate Order
     *
     * @param int $numberOfItems
     * @return array
     */
    public function orderGenerate($numberOfItems): array
    {
        $faker = $this->fakerFactory->create("'en_US'");
        $order = [];
        for ($i = 0; $i < $numberOfItems; $i++) {
            $orderId     = $faker->unique()->numberBetween(1000, 99999);
            $customerId  = $faker->unique()->numberBetween(1, 5000);
            $qty         = $faker->numberBetween(1, 5);
            $price       = $faker->randomFloat(2, 10, 500);
            $rowTotal    = $qty * $price;
            $tax         = round($rowTotal * 0.18, 2); // 18% tax
            $grandTotal  = $rowTotal + $tax;

            $item = [
                'item_id'                => $faker->unique()->numberBetween(2000, 9999),
                'sku'                    => strtoupper($faker->bothify('SKU-###??')),
                'name'                   => $this->productName(),
                'product_id'             => $faker->unique()->numberBetween(100, 999),
                'qty_ordered'            => $qty,
                'price'                  => $price,
                'base_price'             => $price,
                'row_total'              => $rowTotal,
                'base_row_total'         => $rowTotal,
                'tax_amount'             => $tax,
                'base_tax_amount'        => $tax,
                'price_incl_tax'         => $price + ($tax / $qty),
                'base_price_incl_tax'    => $price + ($tax / $qty),
                'row_total_incl_tax'     => $grandTotal,
                'base_row_total_incl_tax' => $grandTotal,
            ];

            $order[] = [
                'entity_id'             => $orderId,
                'increment_id'          => (string) $faker->numerify('#########'),
                'state'                 => $faker->randomElement(['new', 'processing', 'complete', 'closed']),
                'status'                => $faker->randomElement(['pending', 'processing', 'complete']),
                'grand_total'           => $grandTotal,
                'base_grand_total'      => $grandTotal,
                'subtotal'              => $rowTotal,
                'base_subtotal'         => $rowTotal,
                'discount_amount'       => 0,
                'tax_amount'            => $tax,
                'shipping_amount'       => $faker->randomFloat(2, 0, 20),
                'order_currency_code'   => 'USD',
                'base_currency_code'    => 'USD',
                'customer_id'           => $customerId,
                'customer_email'        => $faker->unique()->safeEmail(),
                'customer_firstname'    => $faker->firstName(),
                'customer_lastname'     => $faker->lastName(),
                'customer_is_guest'     => false,
                'created_at'            => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'updated_at'            => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'total_item_count'      => $qty,
                'items'                 => [$item],
                'billing_address'       => [
                    'firstname'   => $faker->firstName(),
                    'lastname'    => $faker->lastName(),
                    'street'      => [$faker->streetAddress()],
                    'city'        => $faker->city(),
                    'region'      => $faker->state(),
                    'region_code' => strtoupper($faker->lexify('??')),
                    'postcode'    => $faker->postcode(),
                    'country_id'  => $faker->countryCode(),
                    'telephone'   => $faker->phoneNumber(),
                    'email'       => $faker->safeEmail(),
                ],
                'payment'               => [
                    'method'         => $faker->randomElement(['checkmo', 'paypal', 'banktransfer']),
                    'amount_paid'    => $grandTotal,
                    'amount_ordered' => $grandTotal,
                ],
                'status_histories'      => [
                    [
                        'comment'    => $this->generateComment(),
                        'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                        'status'     => $faker->randomElement(['pending', 'processing', 'complete']),
                    ]
                ],
            ];
        }
        return $order;
    }
    /**
     * Produce Product name
     *
     * @return string
     */
    private function productName(): string
    {
        $categories = ['Headphones', 'Laptop', 'Smartphone', 'Backpack', 'Wrist Watch'];
        $adjectives = ['Wireless', 'Ergonomic', 'Portable', 'Waterproof', 'Smart'];

        return $adjectives[array_rand($adjectives)] . ' ' . $categories[array_rand($categories)];
    }
    /**
     * Generate Customer
     *
     * @param int $numberOfItems
     * @return array
     */
    public function generateCustomer($numberOfItems): array
    {
        $faker = $this->fakerFactory->create();
        $customerData = [];
        for ($i = 0; $i < $numberOfItems; $i++) {
            $customerId = $faker->unique()->numberBetween(100, 999);
            $customerId = (int) $customerId;
            $customerData[] = [
                'id' => $customerId,
                'group_id' => 1,
                'default_billing' => $customerId,
                'default_shipping' => $customerId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_in' => 'Default Store View',
                'email' => $faker->unique()->safeEmail,
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'store_id' => 1,
                'website_id' => 1,
                'addresses' => [
                    [
                        'id' => $customerId,
                        'customer_id' => $customerId,
                        'region' => [
                            'region_code' => $faker->stateAbbr,
                            'region' => $faker->state,
                            'region_id' => $faker->numberBetween(1, 50)
                        ],
                        'country_id' => 'US',
                        'street' => [$faker->streetAddress],
                        'telephone' => $faker->phoneNumber,
                        'postcode' => $faker->postcode,
                        'city' => $faker->city,
                        'default_shipping' => true,
                        'default_billing' => false
                    ],
                    [
                        'id' => $customerId,
                        'customer_id' => $customerId,
                        'region' => [
                            'region_code' => $faker->stateAbbr,
                            'region' => $faker->state,
                            'region_id' => $faker->numberBetween(1, 50)
                        ],
                        'country_id' => 'US',
                        'street' => [$faker->streetAddress],
                        'telephone' => $faker->phoneNumber,
                        'postcode' => $faker->postcode,
                        'city' => $faker->city,
                        'default_shipping' => false,
                        'default_billing' => true
                    ]
                ],
                'disable_auto_group_change' => 0
            ];
        }

        return $customerData;
    }
    /**
     * Generate Product
     *
     * @param int $numberOfItems
     * @return array
     */
    public function generateProduct($numberOfItems): array
    {
        $faker = $this->fakerFactory->create();
        $products = [];
        for ($i = 0; $i < $numberOfItems; $i++) {
            $categories = ['Headphones', 'Laptop', 'Smartphone', 'Backpack', 'Wrist Watch'];
            $adjectives = ['Wireless', 'Ergonomic', 'Portable', 'Waterproof', 'Smart'];
            $features   = ['with long battery life', 'for gaming', 'with noise cancellation', 'for travel'];

            $productName = $adjectives[array_rand($adjectives)] . ' ' . $categories[array_rand($categories)];
            $description = "High-quality {$productName} {$features[array_rand($features)]}.";

            $color = $faker->safeColorName;
            $products[] = [
                "entity_id" => $i+1,
                "sku" => strtoupper($faker->bothify('FAKE-####??')),
                "name" => $productName,
                "attribute_set_id" => 4,
                "price" => $faker->randomFloat(2, 50, 1500),
                "status" => 1,
                "visibility" => 4,
                "type_id" => "simple",
                "created_at" => $faker->dateTimeThisYear()->format("Y-m-d H:i:s"),
                "updated_at" => $faker->dateTimeThisMonth()->format("Y-m-d H:i:s"),
                "weight" => $faker->randomFloat(2, 0.5, 5.0),
                "extension_attributes" => [
                    "website_ids" => [1],
                    "category_links" => [
                        [
                            "position" => 0,
                            "category_id" => (string)$faker->numberBetween(2, 20),
                            "extension_attributes" => new \stdClass()
                        ]
                    ],
                    "stock_item" => [
                        "item_id" => $i,
                        "product_id" => $i,
                        "stock_id" => 1,
                        "qty" => $faker->numberBetween(0, 200),
                        "is_in_stock" => $faker->boolean(),
                        "use_config_manage_stock" => true,
                        "manage_stock" => true,
                        "extension_attributes" => new \stdClass()
                    ],
                ],
                "product_links" => [],
                "options" => [],
                "media_gallery_entries" => [],
                "tier_prices" => [],
                "custom_attributes" => [
                    [
                        "attribute_code" => "description",
                        "value" => $description
                    ],
                    [
                        "attribute_code" => "short_description",
                        "value" => sprintf(
                            "Stylish %s available in %s.",
                            strtolower($productName),
                            $color
                        )
                    ],
                    [
                        "attribute_code" => "color",
                        "value" => $color
                    ]
                ]
            ];
        }
        return $products;
    }
    /**
     * Generate a human-like order comment
     */
    private function generateComment(): string
    {
        $templates = [
            "Customer called and requested update. Advised expected delivery by :date.",
            "Order confirmed, payment verified. Preparing for shipment.",
            "Spoke with customer service rep at :time, confirmed status.",
            "Package delayed due to :reason. Informed customer.",
            "Customer requested address verification: :address.",
            "Follow-up email sent regarding order update on :date."
        ];
        $faker = $this->fakerFactory->create("'en_US'");
        $template = $faker->randomElement($templates);

        // Replace placeholders with fake values
        $comment = str_replace(
            [':date', ':time', ':reason', ':address'],
            [
                $faker->dateTimeBetween('-2 days', '+5 days')->format('Y-m-d H:i'),
                $faker->time('H:i A'),
                $faker->randomElement(['weather conditions', 'carrier issues', 'inventory shortage']),
                $faker->address
            ],
            $template
        );
        return $comment;
    }
}
