# 🧪 Magento 2 Mock Data Generator (GraphQL + REST API)

[![Magento 2](https://img.shields.io/badge/Magento-2.4-brightgreen.svg)](https://devdocs.magento.com/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-%5E7.4%20%7C%5E8.1-purple)](https://www.php.net/)

A **developer-friendly Magento 2 module** to generate **fake customers, products, and orders** via **GraphQL & REST APIs**.
Powered by [FakerPHP](https://fakerphp.github.io/).

Useful when:  
✅ You need quick test data for local/staging development  
✅ Testing GraphQL storefronts (Vue, React, PWA Studio, etc.)  
✅ Avoiding manual CSV uploads or repetitive admin work  

---

## 🚀 Features

* Generate **Customers, Products, and Orders** with one API call
* Supports **REST (`/V1/mockdata/generate`)** and **GraphQL**
* Customizable `entity` and `count` parameters
* Lightweight and non-intrusive (no DB bloat unless you extend it to save)

---

## 📦 Installation

1. Clone this repository inside `app/code/`:

   ```bash
   mkdir -p app/code/Supravat
   cd app/code/Supravat
   git clone https://github.com/yourusername/magento2-mockdata.git MockData
   ```

2. Enable the module:

   ```bash
   bin/magento module:enable Supravat_MockData
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
  "entity": "customer",
  "count": 5
}
```

**Response:**

```json
{
  "success": true,
  "message": "Generated 5 customer(s)",
  "data": [
    {"firstname":"John","lastname":"Doe","email":"john.doe@example.com"},
    {"firstname":"Alice","lastname":"Smith","email":"alice.smith@example.com"}
  ]
}
```

---

### ✅ GraphQL

**Mutation:**

```graphql
mutation {
  generateMockData(entity: "product", count: 3) {
    success
    message
  }
}
```

**Response:**

```json
{
  "data": {
    "generateMockData": {
      "success": true,
      "message": "Generated 3 product(s)"
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

* Uses [FakerPHP](https://fakerphp.github.io/) for data generation
* Data is **returned via API response** only (does not save to DB by default)
* You can extend `MockDataManagement.php` to insert generated entities into Magento DB

---

## 📌 Roadmap

* [ ] Add `category` mock generator
* [ ] Add option to **persist data in Magento DB**
* [ ] Add configurable attributes (stock qty, order status, tax classes)
* [ ] Add `faker` locale support (multi-language data)

---

## 📝 License

MIT License. Feel free to fork, modify, and share.


