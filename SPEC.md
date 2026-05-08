# Rong Bah - Traditional Assamese Attire E-Commerce

## Project Overview
- **Project Name**: Rong Bah (Colorful Woven)
- **Type**: E-commerce UI / Landing Page
- **Core Functionality**: Showcase and sell traditional Assamese attire (Mekhela Chador, Eri Silk, Pat Silk)
- **Target Users**: Women seeking authentic Assamese traditional wear, both Assamese diaspora and cultural enthusiasts

## Design Language

### Aesthetic Direction
Rich, warm cultural aesthetic inspired by Assamese Japi (traditional hat) patterns, Muga silk luster, and traditional motifs (locally called "Jonbiri" and "Bihu dancers"). Earthy, organic feel with touches of gold reminiscent of golden Muga silk. Modern yet rooted in tradition.

### Color Palette
```
--primary:       #8B2323    /* Deep Muga Gold/Bronze - from Muga silk */
--primary-dark:  #6B1C1C    /* Darker bronze */
--secondary:     #2D5016    /* Eri Green - natural dye color */
--accent:        #C9A227    /* Bright gold */
--accent-coral:  #E07B53    /* Warm terracotta/rust */
--bg-cream:      #FDF6E3    /* Warm cream like natural silk */
--bg-light:      #F5ECD7    /* Slightly darker cream */
--text-dark:     #2C1810    /* Deep brown-black */
--text-body:     #5C4033    /* Warm brown for body text */
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
- Subtle parallax on hero image
- Smooth fade-up on scroll for sections
- Hover lifts with soft shadows (like fabric floating)
- No jarring or playful animations

### Visual Assets
- **Icons**: Phosphor Icons (regular weight) for consistency
- **Images**: Unsplash for fabric/textile imagery, cultural imagery
- **Decorative**: CSS-drawn traditional motifs as section dividers
- **Patterns**: Subtle repeating pattern backgrounds inspired by Mekhela Chador borders

## Layout & Structure

### Page Flow
1. **Navigation Bar** — Fixed, transparent → solid on scroll, brand mark + menu + cart
2. **Hero Section** — Full-viewport with layered image, tagline, CTA
3. **Cultural Introduction** — Brief story about Assamese weaving heritage
4. **Featured Collections** — 3 main categories with hover reveals
5. **Product Showcase** — Grid of featured Mekhela Chadors with prices
6. **Craftsmanship Story** — Behind-the-scenes weaver imagery + story
7. **Custom Orders CTA** — For bespoke/jewelry measurement services
8. **Newsletter Signup** — With traditional pattern border
9. **Footer** — Links, social, trust badges

### Responsive Strategy
- Desktop: Multi-column layouts, generous whitespace
- Tablet: 2-column grids, stacked where needed
- Mobile: Single column, hamburger menu, touch-friendly cards

## Features & Interactions

### Navigation
- Transparent on hero, becomes solid cream with shadow on scroll (threshold: 100px)
- Cart icon shows item count badge
- Mobile: slide-in menu from right

### Hero Section
- Subtle zoom on background image (Ken Burns effect, 20s duration)
- Text overlay with gradient for readability
- CTA button with hover glow effect

### Product Cards
- Image zoom on hover (1.05 scale)
- Quick "Add to Cart" overlay appears on hover
- Wishlist heart icon in corner
- Price and product name visible; hover reveals "View Details"

### Product Quick View Modal
- Larger image gallery (2-3 images per product)
- Size/variant selector
- Add to cart with quantity
- Close on overlay click or X button

### Newsletter Form
- Email validation
- Success state with checkmark animation
- Error state with red border shake

## Component Inventory

### Navigation Bar
- **Default**: Transparent background, white text (on hero)
- **Scrolled**: Cream background, dark text, subtle bottom border
- **Mobile**: Hamburger icon, slide-in drawer

### Hero
- Full viewport height
- Layered: background image + gradient overlay + centered text

### Section Headers
- Playfair Display, centered
- Small decorative line with Japi-motif shape below
- Subtitle in Body font below

### Product Card
- Aspect ratio: 3:4 (portrait, like clothing display)
- Image container with overflow hidden
- Overlay on hover with "Quick Add" button
- Product name, short description, price below
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

### Footer
- Dark background (var(--text-dark))
- Cream text
- Pattern overlay (subtle)

## Technical Approach
- **Framework**: Vanilla HTML/CSS/JavaScript (single-page)
- **CSS**: Custom properties, Flexbox/Grid, no framework
- **Animations**: CSS transitions + Intersection Observer for scroll reveals
- **External**: Google Fonts, Phosphor Icons CDN, Unsplash images
- **No build step**: Pure static files