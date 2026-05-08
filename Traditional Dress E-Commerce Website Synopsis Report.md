# Synopsis Report

## Final Year Project

### **Traditional Dress E-Commerce Website**

---

## **Department of Computer Science / Information Technology**

### **Academic Year: 2024–2025**

---

## Table of Contents

1. Introduction
2. Problem Statement
3. Aim and Objectives
4. Scope of the Project
5. Literature Review
6. Proposed System
7. System Architecture
8. Methodology
9. Flowcharts
10. ER Diagram Description
11. Technology Stack & Technical Terminologies
12. Modules Description
13. System Requirements
14. Timeline / Project Schedule
15. Expected Outcomes
16. Conclusion
17. References

---

## 1. Introduction

The global fashion industry is rapidly transitioning toward digital platforms. However, traditional and ethnic clothing — such as sarees, lehengas, kurtas, sherwanis, kimonos, hanboks, and other culturally significant garments — often lacks dedicated online representation. Most mainstream e-commerce platforms treat traditional wear as a subcategory, failing to offer curated experiences, cultural context, or specialized filtering (by fabric, region, occasion, craft technique, etc.).

This project proposes the development of a **fully functional Traditional Dress E-Commerce Website** built using the **Laravel PHP framework**. The platform will serve as a dedicated marketplace where sellers can list traditional garments and buyers can discover, explore, and purchase ethnic clothing from various cultures and regions. The system will feature robust user authentication, product catalog management, a shopping cart, secure checkout, order management, and an admin dashboard.

By building this platform, we aim to bridge the gap between traditional artisans/sellers and a global customer base, preserving cultural heritage while leveraging modern web technologies.

---

## 2. Problem Statement

Despite the growing demand for traditional and ethnic wear, several challenges persist:

- **Lack of Dedicated Platforms:** Major e-commerce websites (Amazon, Flipkart, etc.) do not provide specialized categorization, filtering, or cultural context for traditional dresses.
- **Artisan Visibility:** Small-scale artisans and weavers struggle to reach a wider audience because they lack the technical resources to sell online.
- **Poor User Experience:** Existing solutions often fail to offer region-wise, fabric-wise, occasion-wise, or craft-wise filtering that is essential for traditional clothing.
- **Trust Deficit:** Buyers are often unsure about the authenticity, fabric quality, and craftsmanship of traditional garments purchased online.
- **No Centralized System:** There is no unified platform that aggregates traditional clothing from multiple cultures and regions under one roof.

This project addresses these challenges by creating a **dedicated, feature-rich, and user-friendly e-commerce platform** exclusively for traditional dresses.

---

## 3. Aim and Objectives

### **Aim**

To design and develop a responsive, secure, and scalable e-commerce web application dedicated to traditional dresses using the Laravel framework, enabling users to browse, search, and purchase ethnic and cultural garments seamlessly.

### **Objectives**

1. **To analyze** the existing e-commerce systems and identify the gaps in the traditional clothing segment.
2. **To design** an intuitive and culturally appealing user interface (UI) that enhances user experience (UX) for browsing traditional dresses.
3. **To develop** a full-stack web application using the Laravel (MVC) framework with features including:
   - User Registration & Authentication
   - Product Catalog with Advanced Filtering
   - Shopping Cart & Wishlist
   - Secure Checkout & Payment Gateway Integration
   - Order Tracking & Management
   - Admin Dashboard for Product, Order, and User Management
   - Seller Panel for listing and managing products
4. **To implement** role-based access control (RBAC) for Admin, Seller, and Customer roles.
5. **To integrate** a secure online payment gateway (Razorpay / Stripe / PayPal) for smooth transactions.
6. **To implement** search engine optimization (SEO) friendly URLs and metadata for better discoverability.
7. **To ensure** the application is responsive, mobile-friendly, and cross-browser compatible.
8. **To test** the application thoroughly using unit testing and browser testing to ensure reliability and performance.
9. **To deploy** the application on a live server and document the entire development process.

---

## 4. Scope of the Project

The scope of this project includes:

| Feature | Included |
|---|---|
| User Registration & Login (Email + Social Login) | ✅ |
| Product Listing with Images, Price, Description | ✅ |
| Category & Subcategory Management (Region, Fabric, Occasion) | ✅ |
| Advanced Search & Filters | ✅ |
| Shopping Cart & Wishlist | ✅ |
| Order Placement & Order History | ✅ |
| Payment Gateway Integration | ✅ |
| Admin Dashboard | ✅ |
| Seller Dashboard | ✅ |
| Product Reviews & Ratings | ✅ |
| Email Notifications (Order Confirmation, Shipping) | ✅ |
| Responsive Design | ✅ |
| Inventory Management | ✅ |
| Coupon / Discount Management | ✅ |
| Multi-language / Multi-currency Support | ❌ (Future Scope) |
| Mobile App | ❌ (Future Scope) |
| AI-based Recommendation Engine | ❌ (Future Scope) |

---

## 5. Literature Review

| S.No | Title / Platform | Author / Source | Key Observations |
|---|---|---|---|
| 1 | "E-Commerce Website Development Using Laravel" | IEEE Paper, 2021 | Demonstrated Laravel's effectiveness in building scalable e-commerce platforms using MVC architecture. |
| 2 | Amazon.in – Ethnic Wear Section | Amazon | Large product base but lacks cultural curation; traditional wear is lost among millions of products. |
| 3 | Jaypore.com | Jaypore | A good example of a curated traditional clothing platform; however, limited to Indian wear only. |
| 4 | "Online Shopping System using Laravel Framework" | IJERT, 2022 | Highlighted the advantages of using Eloquent ORM, Blade templating, and middleware for authentication. |
| 5 | AJIO.com – Indie Section | AJIO | Offers handpicked traditional clothing but operates as a subsection rather than a dedicated platform. |
| 6 | "Secure Payment Integration in Laravel E-Commerce" | Springer, 2023 | Discussed integration of Stripe and Razorpay with Laravel using API-based architecture. |

**Inference from Literature Review:** While several platforms exist, there is a clear gap for a **dedicated**, **multi-cultural traditional dress platform** that offers curated categorization, artisan-focused features, and a rich user experience.

---

## 6. Proposed System

The proposed system is a **web-based e-commerce application** with the following characteristics:

- **Three User Roles:** Customer, Seller, Admin
- **MVC Architecture** powered by Laravel
- **MySQL** relational database for data storage
- **Blade Templating Engine** for dynamic front-end rendering
- **RESTful Routes** for clean URL structure
- **Middleware-based Authentication & Authorization**
- **Payment Gateway** for secure transactions
- **Responsive Design** using Daisy UI / Tailwind CSS

### Advantages of the Proposed System over Existing Systems:

| Existing System | Proposed System |
|---|---|
| Generic e-commerce; traditional wear is a subcategory | Exclusively dedicated to traditional dresses |
| Limited filtering options | Advanced filters: Region, Fabric, Occasion, Craft Type, Color |
| No artisan/seller panels | Dedicated seller dashboard for artisans |
| No cultural context or storytelling | Product pages include cultural/historical descriptions |
| Cluttered UI | Clean, culturally themed, user-friendly UI |

---

## 7. System Architecture

```
┌─────────────────────────────────────────────────────────┐
│                      CLIENT SIDE                        │
│  ┌───────────────────────────────────────────────────┐  │
│  │   Browser (Chrome, Firefox, Safari, Edge)         │  │
│  │   ┌─────────────┐  ┌──────────┐  ┌────────────┐  │  │
│  │   │   HTML5      │  │  CSS3 /  │  │ JavaScript │  │  │
│  │   │   (Blade     │  │ Daisy UI│  │  (jQuery /  │  │  │
│  │   │  Templates)  │  │/Tailwind │  │  AJAX)     │  │  │
│  │   └─────────────┘  └──────────┘  └────────────┘  │  │
│  └───────────────────────────────────────────────────┘  │
│                          │ HTTP Request/Response         │
│                          ▼                               │
│  ┌───────────────────────────────────────────────────┐  │
│  │                  SERVER SIDE                       │  │
│  │          Laravel Framework (PHP 8.x)               │  │
│  │  ┌────────────────────────────────────────────┐   │  │
│  │  │              ROUTES (web.php / api.php)     │   │  │
│  │  └──────────────────┬─────────────────────────┘   │  │
│  │                     ▼                              │  │
│  │  ┌──────────┐  ┌────────────┐  ┌──────────────┐  │  │
│  │  │MIDDLEWARE│→ │ CONTROLLERS │→ │    MODELS     │  │  │
│  │  │(Auth,    │  │ (Business   │  │  (Eloquent    │  │  │
│  │  │ CSRF,    │  │  Logic)     │  │   ORM)        │  │  │
│  │  │ RBAC)    │  └──────┬─────┘  └───────┬───────┘  │  │
│  │  └──────────┘         │                │           │  │
│  │                       ▼                ▼           │  │
│  │              ┌─────────────┐   ┌──────────────┐   │  │
│  │              │    VIEWS    │   │   DATABASE   │   │  │
│  │              │  (Blade     │   │   (MySQL)    │   │  │
│  │              │ Templates)  │   │              │   │  │
│  │              └─────────────┘   └──────────────┘   │  │
│  └───────────────────────────────────────────────────┘  │
│                          │                               │
│                          ▼                               │
│  ┌───────────────────────────────────────────────────┐  │
│  │              THIRD-PARTY SERVICES                  │  │
│  │  ┌────────────┐  ┌───────────┐  ┌──────────────┐ │  │
│  │  │  Payment   │  │  Email    │  │   Cloud      │ │  │
│  │  │  Gateway   │  │  Service  │  │   Storage    │ │  │
│  │  │(Razorpay/  │  │ (SMTP/    │  │ (S3/Local)   │ │  │
│  │  │ Stripe)    │  │ Mailgun)  │  │              │ │  │
│  │  └────────────┘  └───────────┘  └──────────────┘ │  │
│  └───────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

---

## 8. Methodology

The project follows the **Agile Software Development Methodology (Iterative & Incremental Model)** combined with the **MVC (Model-View-Controller) architectural pattern** provided by the Laravel framework.

### 8.1 Why Agile?

- Allows iterative development with continuous feedback.
- Each module (authentication, product catalog, cart, checkout, admin panel) is developed as a **sprint**.
- Testing is performed at the end of each sprint.
- Changes and enhancements can be incorporated easily.

### 8.2 Development Phases

| Phase | Activity | Duration |
|---|---|---|
| **Phase 1: Requirement Analysis** | Gather requirements, study existing systems, define features | Week 1–2 |
| **Phase 2: System Design** | ER Diagram, Database Schema, Wireframes, UI/UX Design | Week 3–4 |
| **Phase 3: Environment Setup** | Install Laravel, configure database, set up Git repository | Week 5 |
| **Phase 4: Sprint 1 – Authentication Module** | User registration, login, password reset, role-based access | Week 6 |
| **Phase 5: Sprint 2 – Product & Category Module** | CRUD for products, categories, subcategories, image upload | Week 7–8 |
| **Phase 6: Sprint 3 – Shopping Cart & Wishlist** | Add to cart, update quantity, remove items, wishlist | Week 9 |
| **Phase 7: Sprint 4 – Checkout & Payment** | Address management, order placement, payment gateway integration | Week 10–11 |
| **Phase 8: Sprint 5 – Admin & Seller Dashboard** | Dashboard analytics, order management, user management | Week 12–13 |
| **Phase 9: Sprint 6 – Reviews, Search & Filters** | Product reviews/ratings, advanced search, filtering | Week 14 |
| **Phase 10: Testing** | Unit testing, integration testing, UAT (User Acceptance Testing) | Week 15 |
| **Phase 11: Deployment & Documentation** | Deploy to live server, write documentation, prepare report | Week 16 |

### 8.3 MVC Pattern in Laravel

```
┌──────────────────────────────────────────────────────┐
│                    USER REQUEST                       │
│                    (Browser URL)                      │
└──────────────────────┬───────────────────────────────┘
                       │
                       ▼
              ┌─────────────────┐
              │     ROUTES      │
              │  (web.php)      │
              │  Maps URL to    │
              │  Controller     │
              └────────┬────────┘
                       │
                       ▼
              ┌─────────────────┐
              │   CONTROLLER    │
              │  (Handles       │
              │   business      │       ┌──────────────┐
              │   logic)        │ ◄────►│    MODEL      │
              │                 │       │  (Eloquent   │
              └────────┬────────┘       │   ORM -      │
                       │                │   Database   │
                       │                │   Queries)   │
                       ▼                └──────────────┘
              ┌─────────────────┐
              │      VIEW       │
              │  (Blade         │
              │   Template -    │
              │   HTML Response)│
              └─────────────────┘
                       │
                       ▼
              ┌─────────────────┐
              │  HTTP RESPONSE  │
              │  (Rendered HTML │
              │   to Browser)   │
              └─────────────────┘
```

---

## 9. Flowcharts

### 9.1 General User Flow (Customer)

```
                        ┌───────────┐
                        │   START   │
                        └─────┬─────┘
                              │
                              ▼
                     ┌─────────────────┐
                     │  Visit Website  │
                     └────────┬────────┘
                              │
                              ▼
                    ┌──────────────────┐
                    │  Browse Products │
                    │  / Search /      │
                    │  Apply Filters   │
                    └────────┬─────────┘
                              │
                              ▼
                   ┌───────────────────┐
                   │  View Product     │
                   │  Details Page     │
                   └────────┬──────────┘
                              │
                              ▼
                  ┌────────────────────────┐
                  │  Add to Cart /         │
                  │  Add to Wishlist?      │
                  └───────────┬────────────┘
                              │
                    ┌─────────┴─────────┐
                    ▼                   ▼
            ┌──────────────┐   ┌──────────────┐
            │ Add to Cart  │   │Add to Wishlist│
            └──────┬───────┘   └──────────────┘
                   │
                   ▼
          ┌─────────────────┐
          │  View Cart      │
          │  (Update Qty /  │
          │   Remove Item)  │
          └────────┬────────┘
                   │
                   ▼
        ┌──────────────────────┐
        │  Proceed to Checkout │
        └──────────┬───────────┘
                   │
                   ▼
           ┌───────────────┐       ┌───────────────────┐
           │  Logged In?   │──NO──►│  Login / Register  │
           └───────┬───────┘       └─────────┬─────────┘
                   │ YES                      │
                   ◄──────────────────────────┘
                   │
                   ▼
        ┌──────────────────────┐
        │  Enter / Select      │
        │  Shipping Address    │
        └──────────┬───────────┘
                   │
                   ▼
        ┌──────────────────────┐
        │  Apply Coupon Code   │
        │  (Optional)          │
        └──────────┬───────────┘
                   │
                   ▼
        ┌──────────────────────┐
        │  Select Payment      │
        │  Method (Online /    │
        │  COD)                │
        └──────────┬───────────┘
                   │
                   ▼
        ┌──────────────────────┐
        │  Payment Processing  │
        └──────────┬───────────┘
                   │
          ┌────────┴────────┐
          ▼                 ▼
   ┌────────────┐   ┌────────────┐
   │  Payment   │   │  Payment   │
   │  Success   │   │  Failed    │
   └─────┬──────┘   └─────┬─────┘
         │                 │
         ▼                 ▼
  ┌──────────────┐  ┌──────────────┐
  │ Order Placed │  │ Retry / Go   │
  │ Successfully │  │ Back to Cart │
  └──────┬───────┘  └──────────────┘
         │
         ▼
  ┌──────────────┐
  │ Order        │
  │ Confirmation │
  │ Email Sent   │
  └──────┬───────┘
         │
         ▼
  ┌──────────────┐
  │ Track Order  │
  │ in Dashboard │
  └──────┬───────┘
         │
         ▼
     ┌───────┐
     │  END  │
     └───────┘
```

### 9.2 Admin Workflow

```
                    ┌───────────┐
                    │   START   │
                    └─────┬─────┘
                          │
                          ▼
                  ┌───────────────┐
                  │  Admin Login  │
                  └───────┬───────┘
                          │
                          ▼
               ┌─────────────────────┐
               │   Admin Dashboard   │
               │  (Analytics &       │
               │   Statistics)       │
               └──────────┬──────────┘
                          │
          ┌───────┬───────┼───────┬────────┐
          ▼       ▼       ▼       ▼        ▼
     ┌────────┐┌───────┐┌──────┐┌───────┐┌────────┐
     │Manage  ││Manage ││Manage││Manage ││Manage  │
     │Products││Orders ││Users ││Categ- ││Coupons │
     │        ││       ││      ││ories  ││        │
     └───┬────┘└───┬───┘└──┬───┘└───┬───┘└───┬────┘
         │         │       │        │         │
         ▼         ▼       ▼        ▼         ▼
     ┌────────┐┌────────┐┌──────┐┌───────┐┌────────┐
     │Add/    ││View/   ││View/ ││Add/   ││Create/ │
     │Edit/   ││Update  ││Block/││Edit/  ││Edit/   │
     │Delete  ││Status/ ││Delete││Delete ││Delete  │
     │Products││Cancel  ││Users ││Categ. ││Coupons │
     └────────┘└────────┘└──────┘└───────┘└────────┘
                          │
                          ▼
                     ┌────────┐
                     │  END   │
                     └────────┘
```

### 9.3 Seller Workflow

```
                    ┌───────────┐
                    │   START   │
                    └─────┬─────┘
                          │
                          ▼
              ┌───────────────────┐
              │ Seller Registers  │
              │ / Logs In         │
              └─────────┬─────────┘
                        │
                        ▼
              ┌───────────────────┐      ┌────────────────┐
              │ Admin Approval    │─NO──►│ Wait for       │
              │ Granted?          │      │ Approval       │
              └─────────┬─────────┘      └────────────────┘
                        │ YES
                        ▼
              ┌───────────────────┐
              │ Seller Dashboard  │
              └─────────┬─────────┘
                        │
            ┌───────────┼───────────┐
            ▼           ▼           ▼
     ┌────────────┐┌──────────┐┌──────────┐
     │ Add / Edit ││ View     ││ View     │
     │ Products   ││ Orders   ││ Earnings │
     │ (Name,     ││ Received ││ & Sales  │
     │  Price,    ││          ││ Reports  │
     │  Images,   ││          ││          │
     │  Stock)    ││          ││          │
     └────────────┘└──────────┘└──────────┘
                        │
                        ▼
                   ┌────────┐
                   │  END   │
                   └────────┘
```

### 9.4 Authentication Flow

```
                    ┌───────────┐
                    │   START   │
                    └─────┬─────┘
                          │
                          ▼
                ┌──────────────────┐
                │ User clicks      │
                │ Login/Register   │
                └────────┬─────────┘
                         │
               ┌─────────┴─────────┐
               ▼                   ▼
      ┌──────────────┐    ┌──────────────┐
      │   LOGIN      │    │  REGISTER    │
      └──────┬───────┘    └──────┬───────┘
             │                    │
             ▼                    ▼
    ┌─────────────────┐  ┌─────────────────┐
    │ Enter Email &   │  │ Enter Name,     │
    │ Password        │  │ Email, Password │
    └────────┬────────┘  │ Phone, Role     │
             │           └────────┬────────┘
             ▼                    ▼
    ┌─────────────────┐  ┌─────────────────┐
    │ Validate        │  │ Validate Input  │
    │ Credentials     │  │ & Check Unique  │
    └────────┬────────┘  │ Email           │
             │           └────────┬────────┘
        ┌────┴────┐          ┌────┴────┐
        ▼         ▼          ▼         ▼
   ┌────────┐┌────────┐┌────────┐┌────────┐
   │Valid   ││Invalid ││Valid   ││Invalid │
   └───┬────┘└───┬────┘└───┬────┘└───┬────┘
       │         │         │         │
       ▼         ▼         ▼         ▼
  ┌─────────┐┌────────┐┌─────────┐┌────────┐
  │Redirect ││Show    ││Create   ││Show    │
  │to Dash- ││Error   ││Account &││Error   │
  │board    ││Message ││Send     ││Message │
  │(based   ││        ││Verify   ││        │
  │on role) ││        ││Email    ││        │
  └─────────┘└────────┘└─────────┘└────────┘
```

---

## 10. ER Diagram Description

The database design consists of the following key entities and their relationships:

### Key Tables:

| Table Name | Description | Key Fields |
|---|---|---|
| **users** | Stores all registered users | id, name, email, password, role (customer/seller/admin), phone, avatar, email_verified_at |
| **categories** | Product categories | id, name, slug, description, image, parent_id (self-referencing for subcategories) |
| **products** | Product listings | id, seller_id (FK→users), category_id (FK→categories), name, slug, description, price, discount_price, stock, fabric, region, occasion, craft_type, status |
| **product_images** | Multiple images per product | id, product_id (FK→products), image_path, is_primary |
| **carts** | Shopping cart items | id, user_id (FK→users), product_id (FK→products), quantity |
| **wishlists** | Wishlist items | id, user_id, product_id |
| **orders** | Order records | id, user_id, order_number, total_amount, status (pending/processing/shipped/delivered/cancelled), payment_method, payment_status, shipping_address_id |
| **order_items** | Individual items in an order | id, order_id (FK→orders), product_id, quantity, price |
| **addresses** | User shipping addresses | id, user_id, full_name, phone, address_line1, address_line2, city, state, zip_code, country |
| **reviews** | Product reviews & ratings | id, user_id, product_id, rating (1-5), comment |
| **coupons** | Discount coupons | id, code, type (percentage/fixed), value, min_order_amount, expiry_date, usage_limit |
| **payments** | Payment transaction records | id, order_id, transaction_id, payment_gateway, amount, status |

### Relationships:

```
users (1) ──────────── (M) products        [A seller has many products]
users (1) ──────────── (M) orders          [A customer has many orders]
users (1) ──────────── (M) reviews         [A user has many reviews]
users (1) ──────────── (M) carts           [A user has many cart items]
users (1) ──────────── (M) addresses       [A user has many addresses]
categories (1) ────────(M) products        [A category has many products]
categories (1) ────────(M) categories      [Self-referencing: parent-child]
products (1) ──────────(M) product_images  [A product has many images]
products (1) ──────────(M) reviews         [A product has many reviews]
products (1) ──────────(M) order_items     [A product in many order items]
orders (1) ────────────(M) order_items     [An order has many items]
orders (1) ────────────(1) payments        [An order has one payment]
```

---

## 11. Technology Stack & Technical Terminologies

### 11.1 Technology Stack

| Layer | Technology |
|---|---|
| **Back-End Framework** | Laravel 10.x / 11.x (PHP 8.1+) |
| **Front-End** | HTML5, CSS3, JavaScript, jQuery, AJAX |
| **CSS Framework** | Daisy UI / Tailwind CSS |
| **Templating Engine** | Laravel Blade |
| **Database** | MySQL 8.0 |
| **ORM** | Eloquent ORM (Laravel) |
| **Authentication** | Laravel Breeze / Laravel Fortify / Laravel Sanctum |
| **Payment Gateway** | Razorpay / Stripe API |
| **Mail Service** | Laravel Mail (SMTP / Mailgun / Mailtrap) |
| **File Storage** | Laravel Filesystem (Local / AWS S3) |
| **Version Control** | Git & GitHub |
| **Package Manager** | Composer (PHP) & NPM (JS) |
| **Web Server** | Apache / Nginx |
| **Development Environment** | XAMPP / Laragon / Laravel Valet / Docker |
| **Deployment** | Shared Hosting / VPS / Laravel Forge / Heroku |
| **API Testing** | Postman |
| **Testing Framework** | PHPUnit (Laravel Built-in) |

### 11.2 Technical Terminologies

| Term | Description |
|---|---|
| **MVC (Model-View-Controller)** | A software architectural pattern that separates the application into three interconnected components: Model (data/logic), View (UI), and Controller (request handling). Laravel is built on MVC. |
| **Eloquent ORM** | Laravel's built-in Object-Relational Mapping tool that allows developers to interact with the database using PHP objects instead of writing raw SQL queries. |
| **Blade Templating Engine** | Laravel's lightweight yet powerful templating engine that provides template inheritance, sections, and control structures directly in views. |
| **Migration** | Version control for the database. Laravel migrations allow you to define and modify database tables using PHP code, making database changes trackable and reversible. |
| **Seeder** | A Laravel feature to populate the database with sample/test data using PHP classes. |
| **Middleware** | A filtering mechanism in Laravel that intercepts HTTP requests before they reach the controller. Used for authentication, CSRF protection, logging, etc. |
| **CSRF (Cross-Site Request Forgery)** | A security vulnerability where unauthorized commands are submitted from a trusted user. Laravel includes built-in CSRF protection using tokens. |
| **RESTful Routing** | A web architecture style where routes correspond to CRUD operations (GET, POST, PUT/PATCH, DELETE) on resources. |
| **API (Application Programming Interface)** | A set of protocols for building and integrating application software. Used for payment gateway integration and potentially mobile app connectivity. |
| **RBAC (Role-Based Access Control)** | A method of regulating access based on the roles of individual users (Admin, Seller, Customer). |
| **AJAX (Asynchronous JavaScript and XML)** | A technique for creating asynchronous web applications, allowing data to be sent/received from the server without reloading the page (e.g., add to cart). |
| **SMTP (Simple Mail Transfer Protocol)** | An internet standard communication protocol for email transmission. Used for sending order confirmation and notification emails. |
| **Payment Gateway** | A technology that captures and transfers payment data from the customer to the acquirer (bank). Examples: Razorpay, Stripe, PayPal. |
| **SSL (Secure Sockets Layer)** | A security protocol that encrypts data transmitted between the web server and the browser. Essential for e-commerce to protect payment information. |
| **Session** | A way to store information about a user across multiple pages. Laravel uses sessions for cart data, user authentication state, etc. |
| **Composer** | A dependency management tool for PHP. Used to install Laravel and its packages. |
| **NPM (Node Package Manager)** | A package manager for JavaScript. Used to install front-end dependencies like Daisy UI, Vue.js, etc. |
| **Artisan** | Laravel's command-line interface (CLI) that provides helpful commands for development (e.g., `php artisan make:model`, `php artisan migrate`). |
| **Factory (Laravel)** | A class used to generate fake data for testing purposes using the Faker library. |
| **Queue** | Laravel's built-in job queue system for deferring time-consuming tasks (e.g., sending emails) to be processed in the background. |
| **Pagination** | Dividing a large set of data into discrete pages. Laravel provides built-in pagination with Eloquent. |
| **Validation** | The process of ensuring user input meets specified rules before processing. Laravel offers a robust validation system. |
| **Accessor & Mutator** | Eloquent features that allow you to format/transform attribute values when retrieving (accessor) or setting (mutator) them. |
| **Soft Deletes** | A Laravel feature where records are not actually deleted from the database but are marked with a `deleted_at` timestamp, allowing recovery. |
| **Eager Loading** | An Eloquent feature to solve the N+1 query problem by loading related models in advance, improving performance. |
| **Service Provider** | The central place for configuring and bootstrapping Laravel application services. |
| **Webhook** | An HTTP callback triggered by an event (e.g., payment gateway sends a webhook to confirm payment status). |

---

## 12. Modules Description

### Module 1: User Authentication & Authorization Module
- User Registration (Name, Email, Password, Phone)
- Email Verification
- Login / Logout
- Password Reset (Forgot Password)
- Role-based access (Admin, Seller, Customer)
- Profile Management (Edit profile, change password, upload avatar)
- **Laravel Tools:** Laravel Breeze/Fortify, Middleware, Gates & Policies

### Module 2: Product Management Module
- Add, Edit, Delete Products (Seller/Admin)
- Multiple Image Upload per Product
- Product attributes: Name, Description, Price, Discount Price, Stock, Fabric, Region, Occasion, Craft Type, Color, Size
- Product Status (Active/Inactive/Out of Stock)
- **Laravel Tools:** Eloquent Models, File Storage, Form Requests for Validation

### Module 3: Category Management Module
- Add, Edit, Delete Categories and Subcategories
- Hierarchical Category Structure (Parent-Child)
- Category-wise Product Listing
- **Laravel Tools:** Self-referencing Eloquent Relationships, Nested Set Model

### Module 4: Search & Filter Module
- Search by Product Name, Description, Keywords
- Filter by: Category, Subcategory, Price Range, Fabric, Region, Occasion, Color, Rating
- Sort by: Price (Low-High, High-Low), Newest, Popularity, Rating
- **Laravel Tools:** Query Scopes, Eloquent Query Builder, AJAX

### Module 5: Shopping Cart Module
- Add to Cart (with quantity selection)
- View Cart
- Update Quantity
- Remove Item from Cart
- Cart Total Calculation
- **Laravel Tools:** Session-based cart (for guests), Database-based cart (for logged-in users)

### Module 6: Wishlist Module
- Add/Remove Products to/from Wishlist
- View Wishlist
- Move from Wishlist to Cart
- **Laravel Tools:** Eloquent Many-to-Many Relationship (users ↔ products)

### Module 7: Order & Checkout Module
- Select/Add Shipping Address
- Order Summary Review
- Apply Coupon Code
- Choose Payment Method (Online Payment / Cash on Delivery)
- Place Order
- Order Confirmation Page & Email Notification
- **Laravel Tools:** Database Transactions, Laravel Mail, Events & Listeners

### Module 8: Payment Gateway Integration Module
- Secure Online Payment via Razorpay / Stripe
- Payment Status Tracking (Pending, Completed, Failed)
- Refund Processing
- Webhook Handling for Payment Confirmation
- **Laravel Tools:** Razorpay/Stripe SDK, API Integration, Webhook Routes

### Module 9: Order Tracking Module
- Order Status Updates (Pending → Processing → Shipped → Delivered)
- Order History for Customers
- Order Details Page
- **Laravel Tools:** Eloquent Status Management, Email Notifications

### Module 10: Review & Rating Module
- Submit Review (Rating 1-5 + Comment) after Purchase
- View Reviews on Product Page
- Average Rating Calculation
- Admin Moderation of Reviews
- **Laravel Tools:** Eloquent Relationships, Aggregate Functions

### Module 11: Admin Dashboard Module
- Dashboard with Key Metrics (Total Sales, Total Orders, Total Users, Revenue)
- Manage Products, Categories, Orders, Users, Coupons
- Sales Reports & Analytics (Charts/Graphs)
- **Laravel Tools:** Admin Middleware, Chart.js / ApexCharts for Analytics

### Module 12: Seller Dashboard Module
- Seller-specific Dashboard (My Products, My Orders, My Earnings)
- Add/Edit/Delete Own Products
- View Orders for Own Products
- Sales Reports
- **Laravel Tools:** Policy-based Authorization, Scoped Queries

### Module 13: Coupon & Discount Module
- Create Coupon Codes (Admin)
- Coupon Types: Percentage Discount, Fixed Amount Discount
- Minimum Order Amount Requirement
- Expiry Date & Usage Limit
- Apply Coupon at Checkout
- **Laravel Tools:** Custom Validation Rules, Eloquent

### Module 14: Notification Module
- Email Notifications: Order Placed, Order Shipped, Order Delivered, Password Reset
- In-App Notifications (Optional)
- **Laravel Tools:** Laravel Notifications, Laravel Mail, Queues

---

## 13. System Requirements

### 13.1 Hardware Requirements

| Component | Minimum Requirement |
|---|---|
| Processor | Intel Core i3 / AMD Ryzen 3 or above |
| RAM | 4 GB (8 GB recommended) |
| Hard Disk | 256 GB SSD / 500 GB HDD |
| Internet | Broadband connection |
| Display | 1366 x 768 resolution or higher |

### 13.2 Software Requirements

| Software | Version |
|---|---|
| Operating System | Windows 10/11, macOS, or Ubuntu Linux |
| Web Server | Apache 2.4+ / Nginx |
| PHP | 8.1 or above |
| MySQL | 8.0 or above |
| Composer | 2.x |
| Node.js & NPM | 18.x+ / 9.x+ |
| Laravel | 10.x / 11.x |
| Code Editor | Visual Studio Code / PhpStorm |
| Browser | Google Chrome, Mozilla Firefox, Microsoft Edge (latest) |
| Version Control | Git 2.x |
| Local Server | XAMPP / Laragon / Laravel Valet |

---

## 14. Timeline / Project Schedule (Gantt Chart Representation)

```
Week:  1  2  3  4  5  6  7  8  9  10 11 12 13 14 15 16
       ─────────────────────────────────────────────────
Phase 1: Requirement Analysis
       ████
Phase 2: System Design
             ████
Phase 3: Environment Setup
                   ██
Phase 4: Authentication Module
                      ██
Phase 5: Product & Category Module
                         ████
Phase 6: Cart & Wishlist Module
                               ██
Phase 7: Checkout & Payment
                                  ████
Phase 8: Admin & Seller Dashboard
                                       ████
Phase 9: Reviews, Search & Filters
                                             ██
Phase 10: Testing
                                                ██
Phase 11: Deployment & Documentation
                                                   ██
       ─────────────────────────────────────────────────
Legend: ██ = Active Development Period
```

---

## 15. Expected Outcomes

Upon successful completion of this project, the following outcomes are expected:

1. **A fully functional e-commerce website** dedicated to traditional dresses, accessible via modern web browsers.
2. **Seamless user experience** for customers to browse, search, filter, and purchase traditional garments.
3. **A robust admin panel** for managing the entire platform including products, orders, users, and analytics.
4. **A seller panel** enabling artisans and sellers to list and manage their traditional dress inventory.
5. **Secure online transactions** through integrated payment gateways.
6. **Scalable architecture** that can accommodate future enhancements like mobile app integration, AI-based recommendations, and multi-language support.
7. **Preservation and promotion** of traditional and ethnic clothing heritage through a digital platform.
8. **Complete project documentation** including source code, database schema, user manual, and technical report.

---

## 16. Conclusion

The **Traditional Dress E-Commerce Website** is a purposeful and technically sound project that addresses a genuine gap in the online fashion marketplace. By leveraging the **Laravel framework's** robust MVC architecture, Eloquent ORM, Blade templating, and extensive ecosystem, the platform will deliver a secure, scalable, and user-friendly experience for customers, sellers, and administrators.

The project not only demonstrates proficiency in full-stack web development using modern PHP practices but also contributes to the **preservation and global accessibility of traditional clothing heritage**. The Agile development methodology ensures iterative progress with continuous refinement, while comprehensive testing guarantees reliability and performance.

This project serves as a strong foundation that can be extended with advanced features such as AI-based product recommendations, AR-based virtual try-on, multi-vendor marketplace enhancements, and native mobile applications in the future.

---

## 17. References

1. Otwell, T. (2024). *Laravel Documentation (v10.x / v11.x)*. [https://laravel.com/docs](https://laravel.com/docs)
2. Stauffer, M. (2023). *Laravel: Up & Running*, 3rd Edition. O'Reilly Media.
3. Razorpay Developer Documentation. [https://razorpay.com/docs/](https://razorpay.com/docs/)
4. Stripe API Documentation. [https://stripe.com/docs](https://stripe.com/docs)
6. MySQL 8.0 Reference Manual. [https://dev.mysql.com/doc/](https://dev.mysql.com/doc/)
7. PHP Official Documentation. [https://www.php.net/docs.php](https://www.php.net/docs.php)
8. Sommerville, I. (2015). *Software Engineering*, 10th Edition. Pearson.
9. Pressman, R. S. (2014). *Software Engineering: A Practitioner's Approach*, 8th Edition. McGraw-Hill.
10. Various IEEE & IJERT research papers on e-commerce development using Laravel framework (2020–2024).

---

> **Prepared By:** [Your Name]
> **Roll Number:** [Your Roll No.]
> **Department:** [Your Department]
> **Guide / Supervisor:** [Faculty Name]
> **Date:** [Submission Date]

---

*This synopsis report serves as the foundational blueprint for the development of the Traditional Dress E-Commerce Website as a final year academic project.*
