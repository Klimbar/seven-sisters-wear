# Project Thesis

## Seven Sisters Wear: Traditional North-East India E-Commerce Platform

### Traditional Dress E-Commerce Website

**Authors:** Klimbar Timung, Iswar Chetri  
**Department:** Department of Computer Science & Applications, Pandu College

---

## Abstract

Seven Sisters Wear is a web-based e-commerce platform designed to promote, showcase, and sell authentic traditional clothing and cultural products from North-East India. The region has a strong handloom tradition, and research notes that North-East India accounts for a major share of India's handloom weaving households, with women forming a large part of the weaving workforce. Despite this cultural and economic importance, many artisans face limited market access, middlemen dependency, weak digital presence, logistics barriers, and competition from powerloom imitations.

The platform focuses on garments and handloom products such as Mekhela Chador, Muga silk, Pat silk, Eri silk, shawls, ethnic accessories, and tribe-specific cultural wear. Unlike generic e-commerce platforms where traditional clothing is treated as a small category, this system provides a dedicated digital marketplace with cultural context, product discovery, cart management, secure checkout, order tracking, reviews, returns, coupons, and an administrative dashboard.

The project is developed using Laravel, Vue.js, Inertia.js, Tailwind CSS, and a relational database, with MySQL as the primary deployment database and SQLite usable for compatible local testing. Laravel provides the backend MVC structure, authentication, routing, database models, middleware, and business logic. Vue.js and Inertia.js provide a modern single-page application experience while still using Laravel as the main server-side framework. The system includes customer-facing modules and admin modules for product management, inventory, orders, returns, reviews, coupons, tribes, users, and reports.

The thesis documents the need for a specialized traditional dress e-commerce platform, the system objectives, design methodology, architecture, database structure, implemented modules, testing approach, limitations, and future enhancement possibilities.

---

## Acknowledgement

We would like to express our sincere gratitude to our project guide, faculty members, and the Department of Computer Science & Applications, Pandu College, for their guidance, encouragement, and support throughout the development of this project.

We are also thankful to our classmates, friends, and family members for their valuable suggestions, motivation, and continuous support during the preparation and implementation of this project.

This project, titled **"Seven Sisters Wear: Traditional North-East India E-Commerce Platform"**, helped us understand the practical application of web development, database design, software engineering principles, and e-commerce system implementation. We are grateful for the opportunity to work on a project that combines technology with the promotion and preservation of North-East Indian traditional attire and cultural heritage.

---

## Certificate

This is to certify that the project thesis titled **"Seven Sisters Wear: Traditional North-East India E-Commerce Platform"** has been submitted by **Klimbar Timung** and **Iswar Chetri**, students of the **Department of Computer Science & Applications, Pandu College**, in partial fulfillment of the requirements for the final year project.

The work presented in this thesis has been carried out under proper guidance and supervision. To the best of our knowledge, the project is original and has not been submitted elsewhere for the award of any degree, diploma, or certificate.

**Project Guide:** ___________________________

**Head of Department:** ______________________

**External Examiner:** _______________________

**Date:** ___________________

**Place:** __________________

---

## Declaration

We hereby declare that the project thesis titled **"Seven Sisters Wear: Traditional North-East India E-Commerce Platform"** is an original work carried out by us under the guidance and supervision of our project guide.

We further declare that this project has not been submitted, either in full or in part, to any other institution or university for the award of any degree, diploma, or certificate. All sources of information, literature, tools, frameworks, and references used in the project have been properly acknowledged in the reference section.

**Student 1:** Klimbar Timung

**Signature:** ___________________

**Student 2:** Iswar Chetri

**Signature:** ___________________

**Date:** ___________________

**Place:** __________________

---

## Table of Contents

Acknowledgement

Certificate

Declaration

1. Introduction
2. Problem Statement
3. Aim and Objectives
   3.1 Aim
   3.2 Objectives
4. Scope of the Project
   4.1 Included Features
   4.2 Out of Scope for Current Version
5. Literature Review
6. Proposed System
   6.1 User Roles
   6.2 Advantages
7. Feasibility Study
   7.1 Technical Feasibility
   7.2 Operational Feasibility
   7.3 Economic Feasibility
   7.4 Schedule Feasibility
   7.5 Social and Cultural Feasibility
8. Requirement Analysis
   8.1 User Requirements
   8.2 Functional Requirements
   8.3 Non-Functional Requirements
   8.4 Data Requirements
   8.5 Use Case Summary
9. System Architecture
   9.1 Architectural Layers
10. System Design
    10.1 Customer Workflow
    10.2 Admin Workflow
    10.3 Level 0 DFD Description
    10.4 Level 1 DFD Description
    10.5 ER Diagram Description
    10.6 Interface Design Principles
    10.7 Input and Output Design
    10.8 Diagram Placeholders
11. Technology Stack
12. System Requirements
    12.1 Hardware Requirements
    12.2 Software Requirements
13. Database Design
    13.1 Key Relationships
    13.2 Important Table Descriptions
    13.3 Data Integrity Rules
    13.4 Database Design Advantages
14. Module Description
    14.1 Authentication Module
    14.2 Product Catalog Module
    14.3 Cart Module
    14.4 Wishlist Module
    14.5 Checkout and Coupon Module
    14.6 Payment Module
    14.7 Order Management Module
    14.8 Review and Rating Module
    14.9 Return Management Module
    14.10 Admin Dashboard Module
    14.11 Email Notification Module
    14.12 Contact Module
15. Implementation Methodology
    15.1 Development Phases
    15.2 Research Inputs
    15.3 Development Pattern
16. Testing and Validation
    16.1 Test Areas
    16.2 Existing Test Structure
    16.3 Sample Test Cases
    16.4 Validation Testing
    16.5 Usability Testing
    16.6 Admin Workflow Testing
    16.7 Result Summary
17. Screenshots and Output
    17.1 Home Page
    17.2 Shop Page
    17.3 Product Details Page
    17.4 Cart Page
    17.5 Checkout Page
    17.6 Order History Page
    17.7 Order Details and Invoice Page
    17.8 Wishlist Page
    17.9 Review and Rating Section
    17.10 Return Request Page
    17.11 Admin Dashboard
    17.12 Admin Product Management
    17.13 Admin Order Management
    17.14 Admin Coupon Management
    17.15 Admin Return Management
18. Deployment and Maintenance
    18.1 Deployment Environment
    18.2 Deployment Steps
    18.3 Environment Configuration
    18.4 Maintenance Activities
    18.5 Backup and Recovery
    18.6 Maintenance Benefits
19. Security Considerations
    19.1 Implemented and Recommended Security Measures
20. Limitations
21. Future Scope
22. Conclusion
23. References

---

## 1. Introduction

Traditional clothing represents the cultural identity, craftsmanship, and heritage of a region. North-East India is known for its rich textile traditions, handloom practices, indigenous designs, and community-specific attire. Products such as Assamese Mekhela Chador, Muga silk, Pat silk, Eri silk, Naga shawls, Mizo puan, Manipuri phanek, Khasi and Garo textiles, and other handwoven garments hold both cultural and economic value.

The weaving culture of the region is closely connected to rural households, women's work, local identity, ritual use, and inherited craft knowledge. Many motifs and textile patterns communicate community history, clan identity, social status, marital status, and spiritual beliefs. This makes traditional attire more than a commercial product; it is also a record of cultural memory.

However, many artisans, weavers, and small suppliers face difficulty reaching wider markets. Mainstream online marketplaces often list traditional clothing alongside thousands of unrelated products, making discovery difficult. They also lack meaningful cultural categorization, storytelling, region-based filtering, and heritage-focused presentation.

Seven Sisters Wear addresses this gap by creating a dedicated e-commerce platform for traditional North-East Indian wear. The system combines a culturally focused catalog with modern online shopping features such as authentication, product browsing, cart, wishlist, checkout, payment handling, order history, reviews, returns, invoice generation, and admin management.

---

## 2. Problem Statement

Traditional North-East Indian garments and handloom products are underrepresented in mainstream e-commerce platforms. Existing platforms usually lack:

- Dedicated product discovery for region, tribe, fabric, and cultural category.
- Cultural storytelling for traditional garments and artisan-made products.
- Trust-building product details for authenticity, material, and craftsmanship.
- A centralized administrative system for managing products, inventory, orders, returns, and reviews.
- A focused user experience for customers specifically interested in North-East Indian traditional wear.
- Direct market linkage that can reduce dependency on middlemen.
- Practical support for remote customers who cannot access local haats, melas, and regional craft markets.

This creates a digital visibility gap for traditional products and makes it harder for customers to find authentic cultural clothing. The proposed system solves this by building a dedicated e-commerce platform centered on traditional attire and regional heritage.

---

## 3. Aim and Objectives

### 3.1 Aim

To design and develop a responsive, secure, and user-friendly e-commerce web application for traditional North-East Indian clothing and cultural products.

### 3.2 Objectives

- To provide a dedicated online platform for traditional garments and handloom products.
- To allow customers to browse products by category, state, tribe, fabric, and product type.
- To improve digital visibility for North-East Indian textile traditions.
- To support cultural preservation through product storytelling and region-specific categorization.
- To implement customer authentication, profile management, wishlist, cart, checkout, and order history.
- To support product reviews and rating features.
- To provide an admin dashboard for managing products, categories, users, orders, returns, reviews, coupons, and reports.
- To implement product variants, stock tracking, coupons, invoice generation, and return requests.
- To support payment workflow integration through a payment controller and gateway callback/webhook handling.
- To create a responsive frontend using Vue.js, Inertia.js, and Tailwind CSS.
- To ensure maintainability through Laravel MVC architecture, Eloquent models, migrations, and organized routes.

---

## 4. Scope of the Project

The project scope includes both customer-side and admin-side functionality.

### 4.1 Included Features

| Area | Features |
| --- | --- |
| Authentication | Registration, login, logout, password reset, email/OTP verification, Google login support |
| Product Catalog | Product listing, product details, images, categories, variants, stock, status |
| Discovery | Shop page, state and tribe discovery pages, search, category, tribe, fabric, and price filters |
| Customer Actions | Cart, wishlist, checkout, coupon application, order placement |
| Orders | Order history, order details, invoice generation, status display |
| Payments | Payment initiation, callback handling, webhook endpoint, payment status updates |
| Reviews | Product reviews, ratings, review images |
| Returns | Customer return requests, return details, admin return approval/rejection workflow |
| Admin Panel | Dashboard, product management, category management, tribe management, user roles, order management, returns, reviews, coupons, and reports |
| Notifications | Email templates for OTP verification, order confirmation, order status, return status, and contact messages |
| UI | Responsive Vue.js interface with Tailwind CSS and PrimeVue support |

### 4.2 Out of Scope for Current Version

- Native Android and iOS mobile applications.
- Full multi-vendor seller dashboard.
- AI-based personalized recommendations.
- Multi-language interface.
- Multi-currency support.
- Fully automated logistics provider integration.

---

## 5. Literature Review

E-commerce has transformed retail by enabling customers to purchase products through digital platforms. Frameworks such as Laravel have made it easier to build secure and scalable web applications using MVC architecture, routing, middleware, ORM, authentication, and modular controllers.

Research on e-commerce in India shows rapid growth in digital shopping, especially as internet and smartphone adoption expands beyond metro cities. However, heritage products and artisan-made textiles still face difficulty in reaching customers through mainstream channels. Traditional producers often depend on offline markets, craft fairs, local haats, and intermediaries, which limits income and market reach.

Generic platforms such as Amazon, Flipkart, and AJIO provide large-scale product access, but traditional clothing is usually placed within broad categories. Customers searching for specific cultural wear often face poor discoverability, limited filters, and insufficient cultural detail. Curated platforms show that heritage-focused commerce has demand, but there remains a need for dedicated platforms focused specifically on North-East Indian textile traditions.

The reviewed research paper for this project identifies major ecosystem challenges: low digital adoption, market access limitations, logistics barriers, authenticity concerns, middlemen exploitation, and competition from imitation products. It also highlights the potential of e-commerce to support cultural preservation, women-led income generation, rural development, and digital inclusion.

The literature and market review show that an effective traditional dress e-commerce platform should combine:

- Product authenticity and cultural context.
- Region, tribe, fabric, and garment-specific categorization.
- Simple customer purchase workflow.
- Strong administrative control.
- Secure payments and order tracking.
- Responsive user experience.
- Long-term support for artisan profiles, authenticity certificates, and cultural metadata.

Seven Sisters Wear is designed around these requirements.

---

## 6. Proposed System

The proposed system is a centralized e-commerce platform where administrators manage product listings, inventory, orders, returns, reviews, coupons, and reports. Customers browse products, add items to cart or wishlist, apply coupons, place orders, make payments, view invoices, submit reviews, and request returns.

### 6.1 User Roles

| Role | Description |
| --- | --- |
| Customer | Browses products, manages cart/wishlist, places orders, reviews products, requests returns |
| Admin | Manages products, categories, users, orders, returns, reviews, coupons, reports, and payment statuses |

### 6.2 Advantages

- Dedicated focus on traditional North-East Indian wear.
- Better product discovery through cultural and regional categorization.
- Centralized administrative control for reliable inventory and order processing.
- Modern frontend experience using Vue.js and Inertia.js.
- Secure backend structure using Laravel authentication, middleware, and Eloquent ORM.

---

## 7. Feasibility Study

A feasibility study evaluates whether the proposed system is practical, useful, and achievable within the available time, technology, and resources. Seven Sisters Wear is feasible because it uses widely adopted open-source technologies, follows a modular architecture, and solves a clearly identified market and cultural problem.

### 7.1 Technical Feasibility

The project is technically feasible because the selected technologies are stable, well documented, and suitable for an e-commerce platform.

| Technology | Feasibility Reason |
| --- | --- |
| Laravel | Provides routing, MVC structure, authentication, validation, ORM, middleware, and mail support |
| Vue.js | Supports reusable frontend components and responsive user interfaces |
| Inertia.js | Connects Laravel and Vue without requiring a separate API-only backend |
| Tailwind CSS | Enables fast responsive UI development |
| MySQL/SQLite | Provides reliable relational data storage, with MySQL used as the primary deployment database |
| Vite | Provides fast frontend asset compilation |

The application can be developed and tested locally and later deployed to a production server using Apache or Nginx. Laravel's ecosystem also supports future scaling through queues, caching, storage drivers, and service integrations.

### 7.2 Operational Feasibility

The system is operationally feasible because the workflows are familiar to both customers and administrators. Customers can browse products, add items to cart, place orders, and view order history. Administrators can manage products, categories, users, orders, returns, reviews, coupons, and reports through a centralized dashboard.

The admin-managed inventory model is practical for the current version because it reduces complexity compared to a full multi-vendor marketplace. The business owner can collect products from artisans or suppliers, upload them to the platform, manage stock, and process customer orders centrally.

### 7.3 Economic Feasibility

The system is economically feasible because it uses open-source frameworks and does not require expensive proprietary software. Development costs mainly involve hosting, domain registration, payment gateway charges, email service configuration, and maintenance.

The platform may create economic value by improving product visibility, reducing dependency on middlemen, increasing customer reach, and enabling direct or semi-direct market linkage for traditional products.

### 7.4 Schedule Feasibility

The project can be completed in phases. Core features such as authentication, product listing, cart, checkout, orders, and admin product management can be built first. Additional features such as reviews, returns, coupons, reports, and payment handling can be added in later iterations.

### 7.5 Social and Cultural Feasibility

The project is socially feasible because it supports the promotion of traditional clothing, local craft identity, women-led weaving practices, and cultural awareness. It also helps customers understand the cultural meaning of garments rather than treating them only as fashion products.

---

## 8. Requirement Analysis

Requirement analysis defines what the system should do and how users will interact with it. The requirements of Seven Sisters Wear are divided into user requirements, functional requirements, non-functional requirements, and data requirements.

### 8.1 User Requirements

| User | Requirement |
| --- | --- |
| Visitor | View home page, shop page, product details, state and tribe discovery pages, story page, and contact page |
| Customer | Register, log in, verify account, manage profile, use wishlist/cart, place orders, submit reviews, request returns |
| Admin | Manage products, categories, tribes, users, orders, payments, returns, reviews, coupons, and reports |

### 8.2 Functional Requirements

| ID | Requirement | Description |
| --- | --- | --- |
| FR-01 | User Registration | New customers should be able to create an account |
| FR-02 | User Login | Registered users should be able to log in securely |
| FR-03 | Product Listing | Customers should be able to view available products |
| FR-04 | Product Details | Customers should be able to view product images, price, description, reviews, and variants |
| FR-05 | Search and Filter | Customers should be able to discover products by relevant criteria |
| FR-06 | Cart Management | Customers should be able to add, update, and remove cart items |
| FR-07 | Wishlist | Customers should be able to save products for later |
| FR-08 | Checkout | Customers should be able to provide order details and place orders |
| FR-09 | Coupon | Customers should be able to apply valid coupon codes |
| FR-10 | Payment | The system should initiate and track payment status |
| FR-11 | Order History | Customers should be able to view past and current orders |
| FR-12 | Invoice | Customers and admins should be able to view order invoices |
| FR-13 | Review | Customers should be able to submit product reviews and ratings |
| FR-14 | Return Request | Customers should be able to request returns for orders |
| FR-15 | Admin Product Management | Admins should be able to create, edit, delete, and manage products |
| FR-16 | Admin Order Management | Admins should be able to view and update order/payment status |
| FR-17 | Admin Reports | Admins should be able to view business reports |

### 8.3 Non-Functional Requirements

| Requirement | Description |
| --- | --- |
| Performance | Pages should load quickly and database queries should be optimized where possible |
| Security | User accounts, payments, sessions, and admin routes should be protected |
| Usability | The interface should be simple for non-technical customers |
| Maintainability | Code should follow Laravel and Vue.js conventions |
| Scalability | The system should support future expansion such as seller dashboards and logistics integration |
| Reliability | Order, payment, and inventory workflows should maintain data consistency |
| Responsiveness | The website should work on desktop, tablet, and mobile screens |

### 8.4 Data Requirements

The system stores structured data for users, products, categories, states, tribes, carts, wishlists, orders, order items, addresses, coupons, reviews, review images, product images, product variants, return requests, and email verification OTPs.

### 8.5 Use Case Summary

| Use Case | Actor | Description |
| --- | --- | --- |
| Browse Products | Visitor/Customer | View product catalog and details |
| Register Account | Visitor | Create a new customer account |
| Add to Cart | Customer | Add selected product or variant to cart |
| Place Order | Customer | Confirm cart items and create an order |
| Submit Review | Customer | Add rating and feedback for a product |
| Request Return | Customer | Submit return request for an eligible order |
| Manage Product | Admin | Add, edit, delete, and update product stock and status |
| Manage Order | Admin | View order details and update order/payment status |
| Manage Coupon | Admin | Create and maintain discount coupons |

---

## 9. System Architecture

The system follows Laravel's MVC architecture combined with an Inertia-powered Vue.js frontend.

```text
Customer/Admin Browser
        |
        | HTTP Request
        v
Laravel Routes
        |
        v
Middleware
(auth, verified, admin, CSRF)
        |
        v
Controllers
(Product, Admin, Payment, Return, Review, Coupon, Invoice)
        |
        v
Models and Services
(Product, Order, Cart, Review, ReturnRequest, Coupon, Pay0ShopService)
        |
        v
Database
(MySQL primary, SQLite for compatible local testing)
        |
        v
Inertia Response / Blade Email / Web Invoice
        |
        v
Vue.js Pages and Components
```

**Figure 10.1:** System Architecture Diagram *(insert diagram here)*

### 9.1 Architectural Layers

| Layer | Responsibility |
| --- | --- |
| Presentation Layer | Vue.js pages, reusable components, Tailwind CSS styling |
| Routing Layer | Laravel web routes and authentication routes |
| Controller Layer | Request handling and business workflow coordination |
| Model Layer | Eloquent models and relationships |
| Database Layer | Tables for users, products, orders, carts, reviews, returns, coupons, states, tribes, categories |
| Service Layer | Payment-related service handling |
| Notification Layer | Mail classes and Blade email templates |

---

## 10. System Design

System design explains how the requirements are converted into a working technical structure. It includes workflow design, data flow, entity relationships, and interface planning.

### 10.1 Customer Workflow

```text
Visit Website
     |
Browse Home/Shop/Product Pages
     |
Register/Login
     |
Add Product to Wishlist or Cart
     |
Review Cart
     |
Apply Coupon
     |
Proceed to Checkout
     |
Place Order / Initiate Payment
     |
View Order History and Invoice
     |
Submit Review or Return Request
```

**Figure 10.5:** Customer Order Workflow *(insert diagram here)*

### 10.2 Admin Workflow

```text
Admin Login
     |
Open Admin Dashboard
     |
Manage Products/Categories/Users
     |
Monitor Orders and Payments
     |
Update Order Status
     |
Handle Return Requests
     |
View Reports
```

**Figure 10.6:** Admin Management Workflow *(insert diagram here)*

### 10.3 Level 0 DFD Description

At Level 0, the system is represented as a single process called **Seven Sisters Wear E-Commerce System**. External entities include Customer, Admin, and Payment Gateway. The customer sends registration, login, cart, order, review, and return data to the system. The admin sends product, category, order status, coupon, and return status data to the system. The payment gateway sends payment callback and webhook data. The system returns product information, order confirmation, payment status, invoices, and notifications.

**Figure 10.2:** Level 0 Data Flow Diagram *(insert diagram here)*

### 10.4 Level 1 DFD Description

At Level 1, the main process is divided into:

| Process | Description |
| --- | --- |
| Authentication Process | Handles registration, login, password reset, OTP verification, and sessions |
| Product Process | Handles catalog, product details, categories, states, tribes, images, and variants |
| Cart and Wishlist Process | Handles saved products, cart items, quantity updates, and removals |
| Checkout Process | Handles address, coupon, order creation, and payment initiation |
| Order Process | Handles order history, order details, invoices, and admin status updates |
| Review Process | Handles customer reviews and review images |
| Return Process | Handles customer return requests and admin return decisions |
| Admin Process | Handles dashboard, product, user, category, coupon, order, return, review, and report management |

**Figure 10.3:** Level 1 Data Flow Diagram *(insert diagram here)*

### 10.5 ER Diagram Description

The ER diagram of the system contains entities such as User, Product, ProductImage, ProductVariant, Category, State, Tribe, Cart, Wishlist, Order, OrderItem, Address, Coupon, Review, ReviewImage, ReturnRequest, and EmailVerificationOtp. Relationships are formed through primary keys and foreign keys.

Key ER relationships include:

- User to Order: one-to-many
- User to Cart: one-to-many
- User to Wishlist: one-to-many
- Product to ProductImage: one-to-many
- Product to ProductVariant: one-to-many
- Product to Review: one-to-many
- Order to OrderItem: one-to-many
- Review to ReviewImage: one-to-many
- Category to Product: one-to-many

**Figure 10.4:** Entity Relationship Diagram *(insert diagram here)*

### 10.6 Interface Design Principles

The interface is designed to be responsive, readable, and culturally appropriate. Product cards use image-focused layouts because traditional clothing is visually driven. Admin pages are designed to be functional and information-dense so administrators can quickly manage products, orders, and returns.

### 10.7 Input and Output Design

| Input | Output |
| --- | --- |
| Registration form | New user account |
| Login form | Authenticated user session |
| Product form | Product record and public product listing |
| Cart action | Updated cart summary |
| Coupon code | Updated order total |
| Checkout form | New order record |
| Payment callback | Updated payment status |
| Review form | Product review saved |
| Return form | Return request record |
| Admin status update | Updated order or return status |

### 10.8 Diagram Placeholders

The following diagrams can be inserted in the final formatted thesis:

- **Figure 10.1:** System Architecture Diagram
- **Figure 10.2:** Level 0 Data Flow Diagram
- **Figure 10.3:** Level 1 Data Flow Diagram
- **Figure 10.4:** Entity Relationship Diagram
- **Figure 10.5:** Customer Order Workflow
- **Figure 10.6:** Admin Management Workflow

---

## 11. Technology Stack

| Component | Technology |
| --- | --- |
| Backend | PHP, Laravel |
| Frontend | Vue.js 3, Inertia.js |
| Styling | Tailwind CSS, PrimeVue |
| Build Tool | Vite |
| Database | MySQL for production, SQLite for compatible local testing |
| Authentication | Laravel Breeze, Laravel authentication, Socialite |
| Authorization | Admin middleware, Spatie Permission package |
| Payments | Payment controller and gateway service integration |
| Email | Laravel Mail, Mailtrap package support |
| Testing | PHPUnit, Laravel feature and unit tests |
| Package Management | Composer, npm |

---

## 12. System Requirements

### 12.1 Hardware Requirements

| Component | Minimum Requirement |
| --- | --- |
| Processor | Dual-core processor |
| RAM | 4 GB minimum, 8 GB recommended |
| Storage | 2 GB free space for application and dependencies |
| Network | Internet connection for payment, email, and package services |

### 12.2 Software Requirements

| Component | Requirement |
| --- | --- |
| Operating System | Windows, Linux, or macOS |
| PHP | PHP 8.3 or compatible version based on project dependencies |
| Composer | Required for Laravel dependencies |
| Node.js and npm | Required for frontend dependencies and Vite |
| Database | MySQL, with SQLite usable for compatible local testing |
| Web Server | Laravel development server, Apache, or Nginx |
| Browser | Chrome, Firefox, Edge, or Safari |

---

## 13. Database Design

The application uses relational database tables managed through Laravel migrations. Major entities include:

| Entity | Purpose |
| --- | --- |
| Users | Stores customer and admin accounts |
| Products | Stores product details, price, description, stock, approval, and status |
| Product Images | Stores multiple product image records |
| Product Variants | Stores variant-level details such as size, stock, and pricing |
| Categories | Stores product category information |
| States | Stores North-East Indian state records |
| Tribes | Stores tribe/community records |
| Carts | Stores user cart items |
| Wishlists | Stores saved user products |
| Orders | Stores order summary, payment, coupon, shipping, and status details |
| Order Items | Stores products and variants included in each order |
| Addresses | Stores customer shipping and billing addresses |
| Coupons | Stores discount code data |
| Reviews | Stores product ratings and review text |
| Review Images | Stores image attachments for reviews |
| Return Requests | Stores customer return requests and admin decisions |
| Email Verification OTPs | Stores OTP records for email verification |

### 13.1 Key Relationships

- A user can have many cart items, wishlist items, orders, reviews, addresses, and return requests.
- A product belongs to a category and can have many images, variants, reviews, cart records, wishlist records, and order items.
- An order belongs to a user and has many order items.
- A return request belongs to a user and is related to an order.
- A review belongs to a product and a user, and can have multiple review images.

### 13.2 Important Table Descriptions

| Table | Important Fields | Description |
| --- | --- | --- |
| users | id, name, email, password, google_id, timestamps | Stores customer and admin account data |
| products | id, category_id, name, description, price, stock, status, is_approved | Stores product catalog data |
| product_images | id, product_id, image path, timestamps | Stores multiple product images |
| product_variants | id, product_id, variant fields, stock, price | Stores size, color, stock, and variant-specific details |
| carts | id, user_id, product_id, variant_id, quantity | Stores active cart items for authenticated users |
| wishlists | id, user_id, product_id | Stores products saved by customers |
| orders | id, user_id, total fields, status, payment_status, coupon fields | Stores order summary and payment information |
| order_items | id, order_id, product_id, variant_id, quantity, price | Stores the individual items inside an order |
| addresses | id, user_id, address fields | Stores customer delivery details |
| coupons | id, code, discount type, discount value, validity fields | Stores discount coupons |
| reviews | id, user_id, product_id, rating, comment, is_approved | Stores customer feedback |
| review_images | id, review_id, image path | Stores images uploaded with reviews |
| return_requests | id, user_id, order_id, reason, status, tracking fields | Stores return request details |
| states | id, name, description | Stores state-level cultural/product discovery data |
| tribes | id, name, description | Stores tribe/community-level discovery data |

### 13.3 Data Integrity Rules

- A cart item must belong to an authenticated user.
- An order must contain at least one order item.
- A review must belong to a valid user and product.
- A product variant must belong to an existing product.
- An admin-only action must be protected through middleware.
- Coupon discounts should be applied only when coupon conditions are valid.
- Payment status should be updated only through controlled payment or admin workflows.
- Product stock should be reduced after successful order placement and restored when required by cancellation or return logic.

### 13.4 Database Design Advantages

The database design separates products, variants, images, orders, reviews, and returns into different tables. This avoids unnecessary duplication and makes the system easier to maintain. For example, product images are stored separately from products so that a product can have multiple images. Similarly, order items are stored separately from orders so that a single order can contain multiple products.

---

## 14. Module Description

### 14.1 Authentication Module

The authentication module allows users to register, log in, verify email/OTP, reset passwords, and manage their profile. Admin access is protected using authentication and admin middleware.

### 14.2 Product Catalog Module

The product catalog module displays products to customers through the home page, shop page, product details page, and tribe-based discovery pages. State pages organize regional discovery by showing state information and related tribes, while products are associated with tribes for cultural categorization. Product records include images, category, pricing, approval status, variants, fabric, occasion, and inventory details.

### 14.3 Cart Module

The cart module allows authenticated customers to add products, update quantities, remove products, and proceed to checkout. It supports product variants and calculates the order amount before placement.

### 14.4 Wishlist Module

The wishlist module allows customers to save products for later. Wishlist status is shown in product listings so users can quickly identify saved products.

### 14.5 Checkout and Coupon Module

The checkout module collects order details and supports coupon application and removal. The coupon module validates discounts and applies eligible coupon benefits to the order.

### 14.6 Payment Module

The payment module initiates payment requests, handles payment callbacks, and receives webhook notifications from the payment gateway. Admins can also update payment status for orders.

### 14.7 Order Management Module

Customers can view their order history, order details, and web invoices. Admins can view all orders, inspect order details, update order status, update payment status, and view invoices.

### 14.8 Review and Rating Module

Customers can submit reviews and ratings for products. Reviews can include images.

### 14.9 Return Management Module

Customers can submit return requests with reasons and supporting details. Admins can review return requests and update the return status. Email notifications can be used to inform customers about return decisions.

### 14.10 Admin Dashboard Module

The admin dashboard provides centralized control over products, categories, tribes, users, orders, returns, reviews, coupons, and reports. It helps administrators monitor sales activity, stock, order flow, and customer interaction.

### 14.11 Email Notification Module

The system includes email templates for OTP verification, order confirmation, order status updates, return status updates, and contact form messages. These notifications improve communication and trust during the shopping process.

### 14.12 Contact Module

The contact module allows visitors and customers to send enquiries through the contact page. Submitted messages are validated and sent to the configured support email address using Laravel Mail.

---

## 15. Implementation Methodology

The project follows an iterative development approach informed by mixed-method research. The research phase includes literature review, market analysis of existing e-commerce platforms, requirements analysis, and technical development. Each major feature is developed, tested, and refined as a separate module.

### 15.1 Development Phases

| Phase | Description |
| --- | --- |
| Requirement Analysis | Identify customer, admin, product, order, and payment requirements |
| System Design | Define architecture, routes, database schema, UI pages, and module boundaries |
| Backend Development | Implement models, migrations, controllers, middleware, mail classes, and services |
| Frontend Development | Build Vue.js pages, layouts, components, forms, and responsive UI |
| Integration | Connect frontend actions to backend routes through Inertia |
| Testing | Run unit and feature tests, validate workflows manually |
| Deployment Preparation | Configure environment, database, storage, queue, email, and payment credentials |

### 15.2 Research Inputs

| Input | Use in Project |
| --- | --- |
| Literature review | Identify market gaps, handloom sector challenges, and cultural context |
| Market analysis | Compare generic e-commerce platforms and heritage product platforms |
| Requirements analysis | Define customer, admin, product, order, payment, review, and return workflows |
| Technical feasibility | Select Laravel, Vue.js, Inertia.js, Tailwind CSS, and relational database design |
| Impact analysis | Evaluate cultural preservation, digital inclusion, and income improvement potential |

### 15.3 Development Pattern

The system uses:

- MVC architecture for clean separation of concerns.
- Eloquent ORM for database relationships and queries.
- Inertia.js for server-driven single-page application behavior.
- Tailwind CSS for responsive and maintainable styling.
- Middleware for route protection and admin authorization.

---

## 16. Testing and Validation

Testing is performed through Laravel's testing tools and manual validation of key user workflows.

### 16.1 Test Areas

| Area | Validation |
| --- | --- |
| Authentication | Login, registration, password reset, email verification |
| Product Management | Product creation, update, deletion, image handling, variant handling |
| Product Variants | Variant display, variant cart selection, variant ownership validation, variant pricing in checkout |
| Cart | Add, update, remove, quantity validation |
| Checkout | Address handling, coupon application, order creation |
| Orders | Customer order history, admin order management, invoice generation |
| Payments | Payment initiation, callback, webhook, payment status update |
| Reviews | Review creation, update, deletion |
| Returns | Return request creation, admin status update |
| Contact | Contact message validation and email sending |
| Admin | Role-protected dashboard and management pages |

### 16.2 Existing Test Structure

The project contains Laravel feature tests for authentication, registration, email verification, password reset, password confirmation, password update, profile update, admin product behavior, product variant selection, and contact form behavior. Unit tests are also available as part of the test suite structure.

### 16.3 Sample Test Cases

| Test Case ID | Test Scenario | Expected Result |
| --- | --- | --- |
| TC-01 | Register with valid user details | User account is created successfully |
| TC-02 | Log in with correct email and password | User is authenticated and redirected |
| TC-03 | Log in with incorrect password | Login fails and validation error is shown |
| TC-04 | View shop page | Active and approved products are displayed |
| TC-05 | Add product to cart | Product is added to authenticated user's cart |
| TC-06 | Update cart quantity | Cart quantity and subtotal are updated |
| TC-07 | Remove cart item | Product is removed from cart |
| TC-08 | Apply valid coupon | Discount is applied to order total |
| TC-09 | Apply invalid coupon | Error message is displayed |
| TC-10 | Place order with valid checkout data | Order and order items are created |
| TC-11 | View order history | Customer can view their own orders |
| TC-12 | Submit product review | Review is saved for the selected product |
| TC-13 | Submit return request | Return request is created successfully |
| TC-14 | Admin creates product | Product is stored and visible in admin list |
| TC-15 | Admin updates order status | Order status changes successfully |
| TC-16 | Non-admin accesses admin route | Access is denied or redirected |
| TC-17 | Select product variant before checkout | Variant is saved to cart and variant price is used |
| TC-18 | Submit contact form | Contact email is sent to the configured support address |

### 16.4 Validation Testing

Validation testing ensures that incorrect or incomplete user inputs are handled properly. Examples include invalid email format during registration, empty product fields during admin product creation, invalid coupon codes during checkout, and invalid quantities in cart updates.

### 16.5 Usability Testing

Usability testing focuses on whether users can complete common tasks without confusion. Important tasks include finding products, viewing product details, adding products to cart, placing an order, checking order history, and submitting reviews. The interface is designed to remain readable and usable on mobile, tablet, and desktop screens.

### 16.6 Admin Workflow Testing

Admin workflow testing verifies that administrative functions are protected and operational. This includes product creation, image management, order status update, payment status update, return request handling, coupon management, and report viewing.

### 16.7 Result Summary

The expected result of testing is that all major customer and admin workflows operate correctly and securely. Any failed test case should be corrected before final deployment. The testing process improves reliability and helps ensure that the platform performs as expected during real use.

---

## 17. Screenshots and Output

This section is reserved for screenshots of the developed Seven Sisters Wear website. The screenshots should demonstrate the user interface, customer workflow, admin workflow, and important system features. The placeholders below should be replaced with actual screenshots before final thesis submission.

### 17.1 Home Page

**Screenshot Placeholder:** Insert screenshot of the home page showing the main banner, featured products, collections, navigation bar, and cultural design elements.

**Description:** The home page introduces the Seven Sisters Wear platform and provides quick access to featured products, collections, shop page, cart, wishlist, and user account options.

### 17.2 Shop Page

**Screenshot Placeholder:** Insert screenshot of the shop page showing product listings, filters, search options, product cards, price, and wishlist/cart actions.

**Description:** The shop page allows customers to browse traditional products and discover items based on category, state, tribe, price, and product type.

### 17.3 Product Details Page

**Screenshot Placeholder:** Insert screenshot of a product details page showing product images, description, price, variants, stock information, add-to-cart button, wishlist button, and reviews.

**Description:** The product details page provides complete information about a selected traditional garment, including cultural context, images, available variants, customer reviews, and purchase options.

### 17.4 Cart Page

**Screenshot Placeholder:** Insert screenshot of the cart page showing selected products, quantity update option, remove option, subtotal, and checkout button.

**Description:** The cart page allows authenticated customers to review selected products, update quantities, remove items, and proceed to checkout.

### 17.5 Checkout Page

**Screenshot Placeholder:** Insert screenshot of the checkout page showing address details, order summary, coupon application, payment option, and place order button.

**Description:** The checkout page completes the purchase process by collecting shipping details, applying coupons, calculating totals, and initiating order placement/payment.

### 17.6 Order History Page

**Screenshot Placeholder:** Insert screenshot of the customer order history page showing previous orders, order status, payment status, and view details option.

**Description:** The order history page helps customers track their purchases and view details of previous and current orders.

### 17.7 Order Details and Invoice Page

**Screenshot Placeholder:** Insert screenshot of an order details page or generated invoice showing order items, billing/shipping details, status, and total amount.

**Description:** This page provides a complete summary of a customer order and supports invoice viewing for record keeping.

### 17.8 Wishlist Page

**Screenshot Placeholder:** Insert screenshot of the wishlist page showing saved products and options to remove items or move products to the cart.

**Description:** The wishlist page allows customers to save products for future purchase.

### 17.9 Review and Rating Section

**Screenshot Placeholder:** Insert screenshot of the product review section showing customer ratings, written reviews, review images, and review submission form.

**Description:** The review section allows customers to share feedback about products and helps future buyers make informed decisions.

### 17.10 Return Request Page

**Screenshot Placeholder:** Insert screenshot of the return request page showing return form, order selection, reason field, and submit button.

**Description:** The return request page allows customers to request returns for eligible orders and provide reasons for the return.

### 17.11 Admin Dashboard

**Screenshot Placeholder:** Insert screenshot of the admin dashboard showing sales summary, product statistics, order statistics, and quick management links.

**Description:** The admin dashboard provides an overview of platform activity and helps administrators manage the e-commerce system efficiently.

### 17.12 Admin Product Management

**Screenshot Placeholder:** Insert screenshot of the admin product management page showing product list, add product button, edit option, delete option, stock, and status details.

**Description:** The product management page allows administrators to add, edit, delete, and manage product inventory and product status.

### 17.13 Admin Order Management

**Screenshot Placeholder:** Insert screenshot of the admin order management page showing order list, customer details, order status, payment status, and update controls.

**Description:** The order management page allows administrators to monitor orders, update order status, and manage payment status.

### 17.14 Admin Coupon Management

**Screenshot Placeholder:** Insert screenshot of the admin coupon management page showing coupon list, discount type, validity, and create/edit options.

**Description:** The coupon management page allows administrators to create, update, and delete discount coupons used during checkout.

### 17.15 Admin Return Management

**Screenshot Placeholder:** Insert screenshot of the admin return management page showing return requests, reasons, customer details, and status update options.

**Description:** The return management page helps administrators review customer return requests and update their status.

---

## 18. Deployment and Maintenance

Deployment and maintenance describe how the project can be moved from the development environment to a live server and how it can be managed after release.

### 18.1 Deployment Environment

The project can be deployed on a Linux-based server using Apache or Nginx. The server should support PHP, Composer, Node.js, npm, and a relational database such as MySQL. The application should be configured through the Laravel `.env` file with correct database, mail, storage, and payment settings.

### 18.2 Deployment Steps

| Step | Description |
| --- | --- |
| Upload source code | Move the Laravel project files to the server |
| Install backend dependencies | Run Composer install for PHP packages |
| Install frontend dependencies | Run npm install for frontend packages |
| Configure environment | Set application key, database, mail, payment, and storage details |
| Run migrations | Create database tables using Laravel migrations |
| Link storage | Create public storage link for uploaded files |
| Build assets | Compile Vue.js and Tailwind CSS assets through Vite |
| Configure web server | Point the domain to the Laravel `public` directory |
| Test workflows | Verify login, product browsing, cart, checkout, admin, and email flows |

### 18.3 Environment Configuration

Important environment values include application URL, database connection, mail credentials, payment gateway credentials, file storage configuration, session driver, cache driver, and queue settings. Sensitive keys should not be committed to version control and should be stored only in the server environment file.

### 18.4 Maintenance Activities

After deployment, the system requires regular maintenance to remain secure and reliable.

- Update Laravel, PHP packages, and npm packages when required.
- Monitor application logs for errors.
- Back up the database regularly.
- Review failed payment or webhook logs.
- Check uploaded files and storage usage.
- Monitor product stock and inactive products.
- Remove spam reviews and invalid user data.
- Improve performance through caching and query optimization.

### 18.5 Backup and Recovery

Database backup is important because the system stores orders, customers, payments, reviews, and product data. A backup plan should include regular database exports, secure storage of backup files, and a recovery process that can restore the system after data loss or server failure.

### 18.6 Maintenance Benefits

Proper maintenance improves system stability, protects customer data, reduces downtime, and ensures that the website remains usable for customers and administrators. It also allows future features such as seller dashboards, logistics integration, and mobile applications to be added more safely.

---

## 19. Security Considerations

Security is important because the system handles user accounts, orders, payments, and customer data.

### 19.1 Implemented and Recommended Security Measures

- Password hashing through Laravel authentication.
- CSRF protection for web forms.
- Auth middleware for customer-only routes.
- Admin middleware for protected administrative routes.
- Role and permission support through Spatie Permission.
- Input validation in controllers and request classes.
- Payment callback and webhook handling through dedicated routes.
- Environment-based configuration for sensitive credentials.
- Email verification/OTP workflow for account validation.
- Secure file upload handling for product and review images.

---

## 20. Limitations

The current system provides a strong foundation, but some limitations remain:

- The platform currently follows a centralized admin-managed inventory model rather than a complete multi-vendor marketplace.
- Advanced logistics automation is not fully implemented.
- AI-based recommendation and personalization are not included.
- Multi-language support is not available in the current version.
- Native mobile apps are outside the current scope.
- Artisan profile verification and authenticity certificates are not fully implemented in the current version.
- Infrastructure issues in remote regions may still affect sourcing, delivery, and artisan onboarding.
- Large-scale production hardening, load testing, CDN configuration, and monitoring would be required before high-traffic deployment.

---

## 21. Future Scope

Future enhancements can extend the system into a broader marketplace and cultural commerce platform.

- Multi-vendor seller dashboard for artisans and suppliers.
- Seller verification workflow with documents and craft certificates.
- Automated shipping provider integration.
- AI-based product recommendations.
- Multi-language support for English, Hindi, Assamese, and other regional languages.
- Mobile applications for Android and iOS.
- Advanced analytics for sales, inventory, customer retention, and product trends.
- Live order tracking with courier status updates.
- Festival-specific campaigns and curated collections.
- Artisan profile pages with workshop photos, stories, and certifications.
- Authenticity certificates and quality verification for handloom products.
- Cultural education pages, styling guides, and "how to wear" content.
- Impact dashboard showing artisan earnings, community contribution, and product origin.
- Digital literacy and onboarding material for artisans.

---

## 22. Conclusion

Seven Sisters Wear demonstrates how modern web technologies can be used to support cultural commerce and heritage preservation. By combining Laravel, Vue.js, Inertia.js, Tailwind CSS, and relational database design, the project delivers a practical e-commerce platform for traditional North-East Indian wear.

The system addresses the lack of dedicated digital representation for traditional garments by offering focused product discovery, cultural categorization, customer shopping workflows, payment handling, order management, reviews, returns, coupons, and an admin dashboard. It provides both a functional shopping experience for customers and a manageable operational system for administrators.

The project can be further expanded into a complete artisan marketplace with multi-vendor support, logistics automation, mobile applications, and multilingual access. Overall, the platform contributes to the digital promotion of North-East Indian textile heritage while meeting the functional needs of a modern e-commerce system.

---

## 23. References

Agrawal, M. A. (2024). Study on e-commerce site for handlooms and handicrafts. *Brazilian Journal of Development*. https://ojs.brazilianjournals.com.br/ojs/index.php/BRJD/article/view/68002

Composer. (n.d.). *Composer documentation*. Retrieved June 10, 2026, from https://getcomposer.org/doc

Dam, S., et al. (2025). Sustainability of the handloom industry for North-East India: A perspective from Tripura. *International Journal of Science and Research*. https://www.ijsr.net/archive/v14i6/SR25621110342.pdf

Devi, A. (2026). Weaving resilience: Sustainability of handloom industry in North-East India. *Atlantis Press*. https://www.atlantis-press.com/article/126023179.pdf

FICCI FLO. (2025). *Indian handloom industry*. https://ficciflo.com/wp-content/uploads/2025/03/Indian-Handloom-Industry-Final.pdf

Gurusamy, K. (2026). Perceived authenticity of Assam handloom products. *Atlantis Press*. https://www.atlantis-press.com/article/126022046.pdf

Inertia.js. (n.d.). *Inertia.js documentation*. Retrieved June 10, 2026, from https://inertiajs.com

Internet and Mobile Association of India, & Kantar. (2026). *Internet in India report 2025*. https://www.indiadigitalsummit.in/wp-content/uploads/2026/01/Internet-in-India-2025-Press-Release-Final.pdf

Kripashree, B. (2025). The artisanal handloom weaving traditions in India's Northeast region. *RRJ IKS*. https://rrjiks.co.in/index.php/RRJIKS/article/view/156

Laravel. (n.d.). *Laravel documentation*. Retrieved June 10, 2026, from https://laravel.com/docs

Ministry of Textiles, Government of India. (2025). *Annual report 2024-25*. https://www.texmin.gov.in/static/uploads/2025/12/c865d599cae0c357c02d247a8a82d24e.pdf

Mukherjee, S. (2025). Consumption expenditure inequality and handloom sector in Northeast India. https://www.ijstjournal.com/wp-content/uploads/journal/published_paper/volume-2/issue-2/IJST241037.pdf

NEDFI. (2021). *Techno-commercial feasibility study on e-commerce platform for marketing of handloom and handicraft products of NER*. https://www.nedfi.com/wp-content/uploads/2021/11/ES-74_merged.pdf

North East Council. (n.d.). *Action plan for development of handloom & handicraft in NER*. https://necouncil.gov.in/sites/default/files/Final%20report%20-%20Action%20Plan%20for%20the%20Development%20of%20Handloom%20%26%20Handicraft%20in%20NER.pdf

North Eastern Handicrafts and Handlooms Development Corporation. (2024). *Annual report 2023-24*. https://nehhdc.com/files/annual-report-2024-25.pdf

npm. (n.d.). *npm documentation*. Retrieved June 10, 2026, from https://docs.npmjs.com

Office of the Development Commissioner (Handlooms). (2019). *Fourth All India Handloom Census 2019-20*. Ministry of Textiles, Government of India. https://handlooms.nic.in/assets/img/Statistics/3736.pdf

Pahuja, B., & Brar, P. (2024). Navigating e-commerce platforms for handicraft product listing. *International Journal of Applied Home Science*. https://scientificresearchjournal.com/wp-content/uploads/2024/09/home-science-11-401-409.pdf

PrimeVue. (n.d.). *PrimeVue documentation*. Retrieved June 10, 2026, from https://primevue.org

Saikia, D., & Baruah, H. (n.d.). Traditional handloom and its impact on weavers: A study in Assam. https://tojqi.net/index.php/journal/article/download/2262/1371/2461

Shah, A., & Patel, R. (2016). E-commerce and rural handicraft artisans. *Voice of Research*. https://ideas.repec.org/p/vor/issues/2016-12-07.html

Tailwind Labs. (n.d.). *Tailwind CSS documentation*. Retrieved June 10, 2026, from https://tailwindcss.com

Vue.js. (n.d.). *Vue.js documentation*. Retrieved June 10, 2026, from https://vuejs.org

Seven Sisters Wear project documentation. (2026). *README, software requirements specification, technical specification, research paper, source code, migrations, controllers, models, routes, and Vue.js pages* [Unpublished project files].
