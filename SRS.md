# Software Requirements Specification (SRS)
## North-East Traditional Wear E-Commerce Platform (Seven Sisters Wear)

### 1. Introduction
#### 1.1 Purpose
The purpose of this Software Requirements Specification (SRS) document is to define the functional and non-functional requirements for the Seven Sisters Wear platform, a North-East India traditional clothing and cultural product marketplace.

The platform will:
- Allow administrators to manage products and orders
- Allow customers to browse and purchase authentic traditional wear (Mekhela Chador, Muga/Pat/Eri Silks)
- Support centralized shipping and delivery management
- Promote traditional handloom, tribal crafts, and ethnic wear from North-East India

#### 1.2 Scope
The platform is an e-commerce system focused on:
- Traditional clothing (Mekhela Chador, shawls, jackets)
- Handloom products (Muga, Pat, Eri silk fabrics)
- Tribal crafts
- Jewelry
- Cultural accessories
- Festival wear

Initial operations use centralized inventory and shipping management:
- Business owner collects products from artisans/suppliers
- Products stored in central inventory
- Admin manages all product listings directly
- No seller dashboards or seller management in initial version

Future expansion may include:
- Multi-vendor dashboards
- Regional fulfillment centers
- Mobile applications
- AI recommendations
- Multi-language support

#### 1.3 Definitions
| Term       | Meaning                                  |
|------------|------------------------------------------|
| Admin      | Platform owner/operator                  |
| Customer   | Buyer using the website                  |
| SKU        | Stock Keeping Unit                       |
| COD        | Cash on Delivery                         |
| CMS        | Content Management System                |
| Inventory  | Product stock available                  |
| Fulfillment| Packing and shipping process             |
| Muga Silk  | Golden silk native to Assam               |
| Pat Silk   | White silk native to Assam               |
| Eri Silk   | Peace silk native to North-East India    |

### 2. Overall Description
#### 2.1 Product Perspective
Web-based e-commerce platform with components:
- Customer-facing website (Vue.js 3 + Inertia.js)
- Admin panel (Laravel 12 backend)
- Inventory system
- Order management system
- Razorpay payment gateway integration
- Shiprocket shipping integration

#### 2.2 User Classes
##### 2.2.1 Admin
Responsibilities:
- Manage products (add, edit, archive)
- Manage inventory (stock tracking, low stock alerts)
- Process orders (status updates, packing, shipping)
- Manage payments and refunds
- Handle returns
- Upload product listings
- Generate reports

##### 2.2.2 Customer
Responsibilities:
- Browse products by category/tribe/region
- Place orders
- Make payments (UPI, cards, Net banking, COD)
- Track shipments
- Submit product reviews
- Manage wishlist
- View order history

#### 2.3 Operating Environment
| Component       | Technology                              |
|-----------------|------------------------------------------|
| Frontend        | Vue.js 3.x, Inertia.js, PrimeVue, Tailwind CSS |
| Backend         | Laravel 12.x (PHP 8.2+)                 |
| Database        | MySQL (production), SQLite (development)  |
| Server          | Linux VPS, Nginx/Apache                  |
| Build Tool      | Vite                                     |
| Third-party     | Razorpay, Shiprocket, Cloudflare         |

#### 2.4 Workflow Overview
Referenced in Section 4 (Workflow Overview)

### 3. Functional Requirements
#### 3.1 User Authentication Module
##### Features
- **Customer Registration**: Sign up via email, password creation
- **Customer Login**: Email/password login, forgot password
- **Admin Login**: Secure admin authentication with role-based access

#### 3.2 Product Management Module
##### Admin Features
- **Add Product**: Title, description, image upload, category, pricing, stock quantity, variants
- **Edit Product**: Update stock, images, pricing, archive/unarchive
- **Delete Product**: Remove unavailable products
- **Product Categories**:
  - By Tribe: Assamese, Bodo, Mishing, Khasi, Garo, Karbi, Naga, Mizo, Manipuri
  - By Product Type: Mekhela Chador, Shawls, Jewelry, Jackets, Handloom Fabrics
  - By Silk Type: Muga Silk, Pat Silk, Eri Silk
  - By Gender: Men, Women, Kids, Unisex

#### 3.3 Inventory Management Module
##### Features
- **Stock Tracking**: Real-time stock updates, reduce stock post-order, restore on cancellation
- **Inventory Alerts**: Low stock warnings, out-of-stock notifications
- **SKU Management**: Unique SKU for each product variant

#### 3.4 Shopping Cart Module
##### Features
- **Cart Operations**: Add/remove products, update quantity, save for later
- **Price Calculation**: Subtotal, shipping charges, taxes, discounts, final total

#### 3.5 Checkout Module
##### Features
- **Address Management**: Add/edit/select default address
- **Payment Methods**: UPI, Credit/Debit cards, Net banking, Wallets, Cash on Delivery (COD)
- **Order Confirmation**: Email/SMS confirmation with Order ID

#### 3.6 Payment Gateway Integration (Razorpay)
##### Features
- Payment processing, refund processing, payment verification
- **Payment Status Tracking**: Pending, Success, Failed, Refunded

#### 3.7 Order Management Module
##### Admin Features
- View all orders, filter by status, search orders
- **Order Status Management**: Pending → Confirmed → Packed → Shipped → Delivered → Cancelled → Returned
- **Invoice Generation**: PDF invoice, shipping label

#### 3.8 Shipping Management Module
##### Features
- **Shipping Label Generation**: AWB number, courier label, pickup request
- **Courier Integration**: Shiprocket, Delhivery, Blue Dart, Ecom Express
- **Tracking**: Customer shipment tracking with courier updates

#### 3.9 Return & Refund Module
##### Features
- **Return Request**: Customer return request with reason and images
- **Refund Processing**: Admin approve/reject return, process refund

#### 3.10 Review & Rating Module
##### Features
- **Customer Reviews**: Ratings, written reviews, image uploads
- **Admin Moderation**: Remove spam reviews, approve pending reviews

#### 3.11 Notification Module
##### Features
- **Email Notifications**: Order confirmation, shipping updates, refunds
- **SMS Notifications**: OTP, delivery updates

#### 3.12 Search & Filter Module
##### Features
- **Search**: Product name, tribe, category, fabric
- **Filters**: Price range, color, size, gender, region, silk type

#### 3.13 Wishlist Module
##### Features
- Save products, remove products, move wishlist items to cart

#### 3.14 Analytics Dashboard
##### Admin Analytics
- Sales reports, revenue, top products, order statistics, inventory reports

### 4. Workflow Overview
#### 4.1 Product Workflow
1. Admin collects products from artisans/suppliers
2. Products stored in centralized inventory
3. Admin uploads product listings (details, images, pricing, stock)
4. Products published on customer-facing website

#### 4.2 Order Workflow
1. Customer places order via website
2. Payment processed via Razorpay
3. Admin packs product from inventory
4. Shipping label generated via Shiprocket
5. Courier pickup arranged
6. Product delivered to customer

#### 4.3 Return Workflow
1. Customer requests return via website
2. Admin reviews return request
3. Courier pickup arranged for return item
4. Refund processed after item inspection

### 5. Non-Functional Requirements
- **Performance**: Page load time < 2 seconds, support 1000+ concurrent users
- **Security**: SSL encryption, PCI-DSS compliance for payments, password hashing
- **Responsive Design**: Mobile-first design, compatible with all modern browsers
- **Scalability**: Horizontal scaling for increased traffic
- **Reliability**: 99.9% uptime, automated backups

### 6. Future Scope
- Multi-vendor seller dashboards
- Regional fulfillment centers
- iOS/Android mobile applications
- AI-powered product recommendations
- Multi-language support (Assamese, Hindi, English)
- Festival-specific promotional campaigns
