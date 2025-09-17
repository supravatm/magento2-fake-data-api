# 🧪 Magento 2 Mock Data Generator (GraphQL + REST API)

A lightweight and non-intrusive(no DB bloat unless you extend it to save) **developer-friendly Magento 2 module** to generate **fake customers, products, and orders** via **GraphQL & REST APIs**.
Powered by [FakerPHP](https://fakerphp.org/).

Useful when:  
✅ You need quick test data for local/staging development  
✅ Testing GraphQL storefronts (Vue, React, PWA Studio, etc.)  
✅ Avoiding manual CSV uploads or repetitive admin work  

---

## 🚀 Features

* Generate **Customers, Products, and Orders** with one API call
* Supports **REST (`/V1/mockdata/generate`)** and **GraphQL**
* Customizable `entity` and `numberOfItems` parameters
* Lightweight and non-intrusive (no DB bloat unless you extend it to save)

---

## 📦 Installation

1. Clone this repository inside `app/code/`:

  #### Composer
    ```bash
    composer require --dev supravatm/module-mock-data-generator
    bin/magento module:enable Supravatm_MockDataGenerator
    bin/magento setup:upgrade
  ```
  #### Manual
   ```bash
   mkdir -p app/code/SMG
   cd app/code/SMG
   git clone https://github.com/supravatm/magento2-fake-data-api.git MockDataGenerator
   ```

2. Enable the module:

   ```bash
   bin/magento module:enable SMG_MockDataGenerator
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

---

## 🔧 Usage

### ✅ REST API

**Endpoint:**

```
POST /rest/V1/mockdata/generate
```

**Body Example:**

```json
{
    "entity": "product",
    "numberOfItems": 1,
    "searchCriteria": {
        "pageSize": 10,
        "currentPage": 1
    }
}
```

**Response:**

```json
{
    "items": [
        {
            "entity_id": 1,
            "sku": "FAKE-8051WX",
            "name": "Portable Smartphone",
            "attribute_set_id": 4,
            "price": 893.19,
            "status": 1,
            "visibility": 4,
            "type_id": "simple",
            "created_at": "2025-03-02 06:40:17",
            "updated_at": "2025-09-14 22:45:57",
            "weight": 1.92,
            "extension_attributes": {
                "website_ids": [
                    1
                ],
                "category_links": [
                    {
                        "position": 0,
                        "category_id": "3",
                        "extension_attributes": {}
                    }
                ],
                "stock_item": {
                    "item_id": 0,
                    "product_id": 0,
                    "stock_id": 1,
                    "qty": 32,
                    "is_in_stock": false,
                    "use_config_manage_stock": true,
                    "manage_stock": true,
                    "extension_attributes": {}
                }
            },
            "product_links": [],
            "options": [],
            "media_gallery_entries": [],
            "tier_prices": [],
            "custom_attributes": [
                {
                    "attribute_code": "description",
                    "value": "High-quality Portable Smartphone with long battery life."
                },
                {
                    "attribute_code": "short_description",
                    "value": "Stylish portable smartphone available in navy."
                },
                {
                    "attribute_code": "color",
                    "value": "navy"
                }
            ]
        }
    ],
    "search_criteria": {
        "filter_groups": [],
        "page_size": 1,
        "current_page": 1
    },
    "total_count": 1
}
```

---

### ✅ GraphQL

**Query:**

```graphql
{
  MockDataProduct(numberOfItems: 1) {
    items {
      entity_id
      name
      price
      sku
      status
      type_id
      visibility
      weight
    }
    total_count
  }
}
```

**Response:**

```json
{
  "data": {
    "MockDataProduct": {
      "items": [
        {
          "entity_id": 1,
          "name": "Smart Backpack",
          "price": 531.97,
          "sku": "FAKE-0348VS",
          "status": 1,
          "type_id": "simple",
          "visibility": 4,
          "weight": 4.41
        }
      ],
      "total_count": 1
    }
  }
}
```
```graphql
{
  MockDataCustomer(numberOfItems: 1) {
    items {
      addresses
      {
        street
        country_id
      }
      id
      email
    }
    total_count
  }
}
```

**Response:**

```json
{
  "data": {
    "MockDataCustomer": {
      "items": [
        {
          "addresses": [
            {
              "street": [
                "23973 Maxime Grove"
              ],
              "country_id": "US"
            },
            {
              "street": [
                "9718 Jonathan Rapid Apt. 836"
              ],
              "country_id": "US"
            }
          ],
          "id": 540,
          "email": "hartmann.dexter@example.net"
        }
      ],
      "total_count": 1
    }
  }
}
```
```graphql
{
  MockDataOrder(numberOfItems: 1) {
    items {
      
      billing_address {
        street
        city
        country_id
      }
      customer_email
      increment_id
      grand_total
      items {
        sku
        name
        qty_ordered
      }
      payment {
        method
        amount_paid
      }
      shipping_amount
      state
      status
      status_histories {
        comment
        status
      }
    }
    total_count
  }
}

```

**Response:**

```json
{
  "data": {
    "MockDataOrder": {
      "items": [
        {
          "billing_address": {
            "street": [
              "4994 Jakubowski Bypass"
            ],
            "city": "Port Keatonville",
            "country_id": "SA"
          },
          "customer_email": "queen.osinski@example.net",
          "increment_id": "427471870",
          "grand_total": 1533.49,
          "items": [
            {
              "sku": "SKU-668UB",
              "name": "Ergonomic Laptop",
              "qty_ordered": 3
            }
          ],
          "payment": {
            "method": "paypal",
            "amount_paid": 1533.49
          },
          "shipping_amount": 13.93,
          "state": "closed",
          "status": "pending",
          "status_histories": [
            {
              "comment": "Package delayed due to carrier issues. Informed customer.",
              "status": "complete"
            }
          ]
        }
      ],
      "total_count": 1
    }
  }
}
```
---

## ⚙️ Supported Entities

* `customer`
* `product`
* `order`

*(You can extend this to support categories, reviews, invoices, etc.)*

---

## 🧑‍💻 Development Notes

* Uses [FakerPHP](https://fakerphp.org/) for data generation
* Data is **returned via API response** only (does not save to DB by default)
* You can extend `MockDataRepository.php` to insert generated entities into Magento DB

---

## 📝 License

MIT License. Feel free to fork, modify, and share.


