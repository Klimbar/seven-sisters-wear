# Seven Sisters Wear - Traditional North East India E-Commerce

## Project Overview
- **Project Name**: Seven Sisters Wear (Named after the seven sister states of North East India)
- **Type**: E-commerce Platform / Multi-vendor Marketplace
- **Core Functionality**: Showcase and sell traditional clothing from all North East Indian states and tribes
- **Target Users**: 
  - Customers seeking authentic North East traditional wear
  - Tribal artisans and weavers from North East India
  - North East diaspora and cultural enthusiasts
  - Global customers interested in indigenous Indian textiles

## Design Language

### Aesthetic Direction
Rich, vibrant cultural aesthetic inspired by the diverse tribal traditions of North East India. Color palette draws from:
- **Assam**: Muga silk luster, golden hues
- **Nagaland**: Tribal patterns, earthy tones
- **Manipur**: Bright rani pink, elegant weaves
- **Mizoram**: Handwoven patterns, natural dyes
- **Tripura**: Traditional textile motifs
- **Meghalaya**: Jaintia, Khasi, and Garo tribal patterns
- **Arunachal Pradesh**: Monpa, Apatani, and other tribal designs

Modern yet deeply rooted in tradition, celebrating the unity in diversity of the Seven Sisters.

### Color Palette
```
--primary:       #8B2323    /* Deep Muga Gold/Bronze - from Assam's Muga silk */
--primary-dark:  #6B1C1C    /* Darker bronze */
--secondary:     #2D5016    /* Eri Green - natural dye color */
--accent:        #C9A227    /* Bright gold */
--accent-coral:  #E07B53    /* Warm terracotta/rust */
--bg-cream:      #FDF6E3    /* Warm cream like natural silk */
--bg-light:      #F5ECD7    /* Slightly darker cream */
--text-dark:     #2C1810    /* Deep brown-black */
--text-body:     #5C4033    /* Warm brown for body text */
--tribal-orange: #FF6B35    /* Naga tribl colors */
--bamboo-green:  #7BA098    /* Assam bamboo groves */
--mekhela-red:   #DC143C    /* Traditional Assamese red */
```

### Typography
- **Display**: Playfair Display (700) — Headlines with elegance
- **Body**: Cormorant Garamond (400, 500, 600) — Readable, traditional feel
- **Accent**: Itim (400) — For decorative elements, prices

### Spatial System
- Container max-width: 1280px
- Section padding: 80px vertical (desktop), 48px (mobile)
- Card border-radius: 8px
- Button border-radius: 4px (subtle, not too modern)

### Motion Philosophy
- Elegant, unhurried transitions (400-600ms) reflecting grace of traditional movements
- Subtle parallax on hero image showcasing North East landscapes
- Smooth fade-up on scroll for sections
- Hover lifts with soft shadows (like fabric floating)
- No jarring or playful animations

### Visual Assets
- **Icons**: Phosphor Icons (regular weight) for consistency
- **Images**: Unsplash for landscape imagery, cultural photography of all seven states
- **Decorative**: CSS-drawn traditional motifs from various tribes as section dividers
- **Patterns**: Subtle repeating patterns inspired by Naga shawls, Mekhela Chador borders, and other tribal textiles

## Layout & Structure

### Page Flow
1. **Navigation Bar** — Fixed, transparent → solid on scroll, brand mark + menu + cart + seller login
2. **Hero Section** — Full-viewport with layered image of Seven Sisters landscape, tagline, CTA
3. **Cultural Introduction** — Brief story about North East India's textile heritage
4. **Featured Collections** — 7 sections for each state (Assam, Nagaland, Manipur, Mizoram, Tripura, Meghalaya, Arunachal Pradesh)
5. **Tribal Categories** — Filter by tribe (Bodo, Naga, Mizo, Khasi, Garo, Apatani, etc.)
6. **Product Showcase** — Grid of traditional garments (Mekhela Chador, Naga shawls, Manipuri phanek, Mizo puon, etc.)
7. **Seller Dashboard Preview** — For artisans to list and manage their products
8. **Craftsmanship Story** — Behind-the-scenes weaver imagery + stories from different states
9. **Custom Orders CTA** — For bespoke/traditional measurement services
10. **Newsletter Signup** — With traditional pattern border
11. **Footer** — Links, social, trust badges, state-wise navigation

### Responsive Strategy
- Desktop: Multi-column layouts, generous whitespace
- Tablet: 2-column grids, stacked where needed
- Mobile: Single column, hamburger menu, touch-friendly cards

## Features & Interactions

### Navigation
- Transparent on hero, becomes solid cream with shadow on scroll (threshold: 100px)
- Cart icon shows item count badge
- Seller login/signup button
- Mobile: slide-in menu from right with state-wise categories

### Hero Section
- Subtle zoom on background image (Ken Burns effect, 20s duration) featuring Seven Sisters landscapes
- Text overlay with gradient for readability
- CTA buttons for "Shop Collection" and "Become a Seller"
- Animated tribal pattern overlay

### Product Cards
- Image zoom on hover (1.05 scale)
- Quick "Add to Cart" overlay appears on hover
- Wishlist heart icon in corner
- Price and product name visible; hover reveals "View Details"
- State and tribe badges (e.g., "Assam • Bodo Tribe")

### Seller Dashboard (New)
- **Registration**: Sellers can register with verification (ID, craft certificate)
- **Product Listing**: Add products with multiple images, descriptions, state/tribe tags
- **Inventory Management**: Track stock, update prices, manage orders
- **Earnings Dashboard**: View sales analytics, withdrawal requests
- **Profile Management**: Add story, certifications, workshop photos

### Product Quick View Modal
- Larger image gallery (2-3 images per product)
- State and tribe selector display
- Size/variant selector
- Add to cart with quantity
- Close on overlay click or X button

### Advanced Search & Filters (New)
- Filter by **State**: Assam, Nagaland, Manipur, Mizoram, Tripura, Meghalaya, Arunachal Pradesh
- Filter by **Tribe**: Bodo, Naga, Mizo, Khasi, Jaintia, Garo, Apatani, Monpa, etc.
- Filter by **Garment Type**: Mekhela Chador, Naga Shawl, Phanek, Puan, Ryndia, etc.
- Filter by **Fabric**: Muga Silk, Eri Silk, Pat Silk, Cotton, Wool, etc.
- Filter by **Occasion**: Wedding, Festival, Daily Wear, Ceremonial
- Price range slider

### Newsletter Form
- Email validation
- Success state with checkmark animation
- Error state with red border shake

## Component Inventory

### Navigation Bar
- **Default**: Transparent background, white text (on hero)
- **Scrolled**: Cream background, dark text, subtle bottom border
- **Mobile**: Hamburger icon, slide-in drawer with state-wise navigation
- **Seller CTA**: "Become a Seller" button for artisan registration

### Hero
- Full viewport height
- Layered: background image (Seven Sisters landscape) + gradient overlay + centered text
- Tribal pattern decorative elements

### Section Headers
- Playfair Display, centered
- Small decorative line with tribal-motif shape below
- Subtitle in Body font below
- State-wise section identifiers

### Product Card
- Aspect ratio: 3:4 (portrait, like clothing display)
- Image container with overflow hidden
- Overlay on hover with "Quick Add" button
- Product name, short description, price below
- State and tribe badges
- Wishlist heart (top-right corner)

### Button Primary
- Background: var(--primary)
- Text: white, Cormorant Garamond 600
- Padding: 14px 32px
- Hover: lighter shade, subtle glow shadow

### Button Secondary
- Border: 2px solid var(--primary)
- Background: transparent
- Text: var(--primary)
- Hover: filled with primary, text white

### State Badge
- Small colored badge indicating state of origin
- Assamese: Golden, Naga: Red, Manipuri: Pink, etc.

### Tribal Tag
- Display tribe name (e.g., "Bodo", "Naga", "Mizo")
- Small, subtle design with tribal pattern accent

### Footer
- Dark background (var(--text-dark))
- Cream text
- Pattern overlay (subtle tribal patterns)
- State-wise quick links
- Seller resources section

## Technical Approach
- **Framework**: Laravel 12.x (PHP 8.2+) with Vue.js 3.x frontend
- **CSS**: Tailwind CSS with custom design system
- **Build Tool**: Vite
- **Database**: MySQL (production) / SQLite (development)
- **Authentication**: Laravel Breeze with role-based access (Customer, Seller, Admin)
- **Multi-vendor Support**: Dedicated seller panel with product management
- **Image Storage**: Laravel Filesystem (Local / AWS S3 for production)
- **Payment Integration**: Razorpay / Stripe for secure transactions
- **Maps Integration**: For showcasing artisan locations (optional)

## Key Features (Detailed)

### For Customers:
1. Browse traditional clothing by state, tribe, garment type
2. View detailed product pages with cultural context
3. Add to cart and wishlist
4. Secure checkout with multiple payment options
5. Order tracking and history
6. Product reviews and ratings
7. Cultural stories behind each garment

### For Sellers/Artisans:
1. **Registration & Verification**: Submit documents for authenticity verification
2. **Product Listing**: 
   - Add multiple product images
   - Select state and tribe
   - Specify garment type, fabric, occasion
   - Set price and stock quantity
   - Add cultural description and story
3. **Order Management**: View and process incoming orders
4. **Earnings Dashboard**: Track sales, request withdrawals
5. **Profile Showcase**: Tell their story, display certifications
6. **Analytics**: View product performance, popular items

### For Admin:
1. User and seller management
2. Product moderation and approval
3. Order oversight
4. Category and tribe management
5. Coupon and discount management
6. Analytics and reporting
7. Content management (cultural stories, blog)

## Supported States & Tribes:

| State | Major Tribes/Garments |
|---|---|
| **Assam** | Bodo, Mishing, Karbi / Mekhela Chador, Muga Silk, Eri Silk, Pat Silk |
| **Nagaland** | Naga tribes (16+ tribes) / Naga Shawls, Tsungkotepsu, Rongsu |
| **Manipur** | Meitei, Naga / Phanek, Innaphi, Mayek Naiba |
| **Mizoram** | Mizo, Hmar, Lai / Puan, Puanchei, Kawrchei |
| **Tripura** | Tripuri, Reang, Jamatia / Risa, Rikutu, Rignai |
| **Meghalaya** | Khasi, Jaintia, Garo / Jainsem, Dakmanda, Daksari |
| **Arunachal Pradesh** | Apatani, Monpa, Nyishi, Adi / Gale, Wrap-around skirts, Jackets |

## North East India Traditional Garments:

| Garment | State | Description |
|---|---|---|
| Mekhela Chador | Assam | Two-piece silk attire, draped around body |
| Naga Shawl | Nagaland | Colorful woolen shawl with tribal patterns |
| Phanek | Manipur | Handwoven wrap-around skirt |
| Puan | Mizoram | Traditional Mizo textile with distinctive patterns |
| Rignai | Tripura | Tripuri traditional wear |
| Jainsem | Meghalaya | Khasi traditional dress |
| Gale | Arunachal Pradesh | Apatani traditional attire |
| Eri Silk Products | Assam/Meghalaya | Peace silk products, soft and warm |

## Database Schema (Key Tables):

| Table | Description | Key Fields |
|---|---|---|
| **users** | All users | id, name, email, password, role (customer/seller/admin), phone, address, email_verified_at |
| **seller_profiles** | Extended seller info | id, user_id, state, tribe, bio, certifications, approved_at |
| **categories** | Product categories | id, name, slug, state, description, parent_id |
| **tribes** | Tribal groups | id, name, state_id, description, image |
| **products** | Product listings | id, seller_id, category_id, tribe_id, name, slug, description, price, discount_price, stock, fabric, occasion, status |
| **product_images** | Multiple images | id, product_id, image_path, is_primary |
| **carts** | Shopping cart | id, user_id, product_id, quantity |
| **wishlists** | Wishlist items | id, user_id, product_id |
| **orders** | Order records | id, user_id, order_number, total_amount, status, payment_method, payment_status |
| **order_items** | Order details | id, order_id, product_id, quantity, price |
| **addresses** | Shipping addresses | id, user_id, full_name, phone, address, city, state, pincode |
| **reviews** | Product reviews | id, user_id, product_id, rating, comment |
| **coupons** | Discount codes | id, code, type, value, min_order_amount, expiry_date |

## Technology Stack:

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 12.x (PHP 8.2+) |
| **Frontend Framework** | Vue.js 3.x with PrimeVue components |
| **CSS Framework** | Tailwind CSS with custom design system |
| **Build Tool** | Vite |
| **Database** | MySQL 8.0 (SQLite for development) |
| **ORM** | Eloquent ORM (Laravel) |
| **Authentication** | Laravel Breeze + Role-based Access Control |
| **Payment Gateway** | Razorpay / Stripe API |
| **File Storage** | Laravel Filesystem (Local / AWS S3) |
| **Maps (Optional)** | Google Maps API for artisan locations |
| **Version Control** | Git & GitHub |
| **Testing** | PHPUnit (Laravel built-in) |
| **Deployment** | VPS / Laravel Forge / Heroku |

## Expected Outcomes:

1. **A fully functional multi-vendor e-commerce platform** dedicated to North East Indian traditional clothing
2. **Empowered tribal artisans** with tools to showcase and sell their creations globally
3. **Seamless user experience** for customers to discover, search, filter, and purchase authentic tribal garments
4. **A robust admin panel** for managing the entire platform
5. **Seller dashboards** enabling artisans to list and manage their traditional clothing inventory
6. **Secure online transactions** through integrated payment gateways
7. **Scalable architecture** for future enhancements
8. **Preservation and promotion** of North East India's rich textile heritage
9. **Complete project documentation** including source code, database schema, user manual
