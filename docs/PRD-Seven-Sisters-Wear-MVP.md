# Seven Sisters Wear - MVP Product Requirements Document

## 1. Product Overview

**Product Name:** Seven Sisters Wear

**Tagline:** Authentic North East India Traditional Wear — Direct from Tribal Artisans

**Goal:** Build a fully functional e-commerce website for buying and selling traditional dress from North East India tribes. The app should look and feel like a modern e-commerce platform.

**Target Launch:** Learning project — focus on a working, complete application.

---

## 2. Target Users

### Primary Persona
- **Who:** Customers seeking authentic traditional North East Indian dresses
- **Demographics:** Adults interested in cultural/ethnic wear, NRIs, cultural enthusiasts
- **Pain Points:** Can't find traditional tribal dresses on mainstream platforms (Amazon, Flipkart)
- **Tech-Savvy:** Comfortable with standard e-commerce flows

### User Needs
- Browse products by state, tribe, and garment type
- View detailed product information and reviews
- Add items to cart and wishlist
- Complete checkout and track orders
- Mobile-responsive experience

---

## 3. Problem Statement

Traditional dresses from North East India tribes (Mekhela Chador, Naga Shawls, Phanek, etc.) are not available on major e-commerce platforms. These garments are primarily sold locally, making it difficult for people outside the region to access authentic traditional wear. The goal is to bridge this gap by creating an online marketplace that connects tribal artisans with customers worldwide.

---

## 4. User Journey

1. **Discovery:** User lands on homepage, sees hero with traditional wear imagery
2. **Browsing:** User browses products, can filter by state/tribe/category
3. **Product View:** User clicks product, views details, images, and reviews
4. **Selection:** User adds to cart or wishlist
5. **Checkout:** User enters shipping details, selects payment, places order
6. **Post-Purchase:** User can view order history and tracking status

---

## 5. MVP Features

### Must-Have Features

#### 1. Product Browsing & Search
- Display products in responsive grid
- Filter by: State (7 NE states), Tribe, Category (garment type), Price range
- Search by product name
- Product pagination or infinite scroll

#### 2. Product Detail Page
- Multiple product images (gallery)
- Product name, description, price
- Size/variant selection
- Add to cart with quantity selector
- Add to wishlist button
- Customer reviews and ratings display
- State and tribe badges

#### 3. Shopping Cart
- Add/remove products
- Update quantities
- View subtotal
- Proceed to checkout

#### 4. Wishlist
- Save products for later
- Move to cart from wishlist
- Remove items

#### 5. User Authentication
- Register (name, email, password)
- Login
- Logout
- Password reset

#### 6. Checkout & Orders
- Guest checkout option
- Shipping address form
- Order summary
- Order confirmation
- Order history list
- Order detail view with status

#### 7. User Dashboard
- Profile management (name, email, phone, address)
- View past orders
- Manage addresses
- Wishlist access

#### 8. Mobile Responsive Design
- Works on desktop, tablet, and mobile
- Touch-friendly interactions
- Hamburger menu on mobile

---

## 6. Success Metrics

### Definition of Success
- All core e-commerce flows work end-to-end
- Users can browse, add to cart, checkout, and view orders
- Mobile responsive on all screen sizes
- Clean, modern UI matching SPEC.md design direction

### Technical Quality
- No breaking errors
- Forms validate properly
- Images load correctly
- Navigation works on all devices

---

## 7. Design Direction

### Visual Style (from SPEC.md)
- **Primary Color:** Deep Muga Gold/Bronze (#8B2323)
- **Secondary:** Eri Green (#2D5016)
- **Background:** Warm cream (#FDF6E3)
- **Typography:** Playfair Display (headlines), Cormorant Garamond (body)
- **Vibe:** Rich, vibrant, cultural yet modern

### Key Screens
1. Homepage with hero and featured products
2. Product listing page with filters
3. Product detail page
4. Cart page
5. Checkout page
6. User login/register
7. User dashboard (orders, profile, addresses)
8. Mobile menu

### Responsive Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

---

## 8. Technical Considerations

### Platform
- Laravel 12.x (PHP 8.2+) backend
- Vue.js 3.x frontend (Inertia.js)
- Tailwind CSS
- MySQL/SQLite database

### Authentication
- Laravel Breeze for auth
- Role-based: Customer (default), Admin

### Key Components
- Product image gallery
- Filter sidebar
- Cart sidebar/modal
- Order status tracking
- Form validation

### Security
- Password hashing
- CSRF protection
- Input validation
- SQL injection prevention (Eloquent ORM)

---

## 9. Constraints

- **Budget:** None specified (learning project)
- **Timeline:** Not urgent — focus on completion
- **Scope:** Core e-commerce features only; no seller/vendor module in MVP
- **Non-Functional:**
  - Mobile responsive
  - Clean UI/UX
  - Working checkout flow

---

## 10. Definition of Done (Launch Checklist)

### Core Functionality
- [ ] Homepage loads with products displayed
- [ ] Product filtering works (state, tribe, category)
- [ ] Product detail page shows all information
- [ ] Add to cart works
- [ ] Wishlist add/remove works
- [ ] User can register and login
- [ ] Checkout flow completes successfully
- [ ] Order appears in user dashboard
- [ ] User can view order details and status

### UI/UX
- [ ] Design matches SPEC.md color palette
- [ ] Typography matches spec
- [ ] Mobile responsive on all pages
- [ ] Navigation works correctly
- [ ] Forms validate input properly

### Technical
- [ ] No PHP errors
- [ ] No JavaScript console errors
- [ ] Database schema correct
- [ ] Routes work correctly
- [ ] Images display properly

---

## What's NOT in MVP (v2)

The following features are intentionally deferred:

1. **Seller/Vendor Module** — Artisan registration and product management
2. **Advanced Search** — Full-text search with more filters
3. **Payment Gateway Integration** — Razorpay/Stripe (use mock for MVP)
4. **Order Tracking** — Real shipment tracking
5. **Coupons/Discounts** — Promo codes
6. **Admin Panel** — Full admin dashboard
7. **Product Ratings Breakdown** — Star distribution charts
8. **Newsletter** — Email signup

These can be added in future versions after core shopping experience is complete.

---

*Generated: 2026-05-11*