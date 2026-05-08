# Seven Sisters Wear

<p align="center">
  <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=400&q=80" width="400" alt="Seven Sisters Wear Logo">
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-red.svg" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/Vue.js-3.x-green.svg" alt="Vue.js Version"></a>
</p>

## About Seven Sisters Wear

Seven Sisters Wear is a traditional e-commerce platform dedicated to showcasing and selling authentic traditional attire from Northeast India, particularly Assam. Our platform specializes in handwoven Mekhela Chadors, made from the finest Muga, Pat, and Eri silks.

Built with the powerful **Laravel** PHP framework and **Vue.js**, our platform serves as a dedicated marketplace where traditional artisans can showcase their craftsmanship and customers can discover, explore, and purchase authentic ethnic clothing.

### Key Features

- **Authentic Traditional Wear**: Curated collection of Muga, Pat, and Eri silk Mekhela Chadors
- **Artisan Stories**: Learn about the master weavers behind each piece
- **Heritage Preservation**: Supporting traditional Assamese weaving techniques
- **Modern E-Commerce Experience**: Secure checkout, user accounts, and order management
- **Responsive Design**: Beautiful, modern interface that works on all devices

## Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Vue.js 3.x with PrimeVue components
- **Styling**: Tailwind CSS with custom design system
- **Build Tool**: Vite
- **Database**: SQLite (development) / MySQL (production)

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite (for development)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/seven-sisters-wear.git
   cd seven-sisters-wear
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install
   ```

4. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Build assets:
   ```bash
   npm run build
   ```

7. Start the development server:
   ```bash
   php artisan serve
   npm run dev
   ```

## Project Structure

```
Seven Sisters Wear/
├── app/                    # Laravel application core
├── resources/
│   ├── js/              # Vue.js components
│   │   ├── Components/  # Reusable Vue components
│   │   ├── Pages/       # Page components
│   │   └── app.js       # Main JavaScript entry
│   └── views/           # Blade templates
├── routes/                 # Laravel routes
├── public/                 # Public assets
└── database/               # Migrations and seeders
```

## Contributing

Thank you for considering contributing to Seven Sisters Wear! Please review our contribution guidelines before submitting pull requests.

## License

Seven Sisters Wear is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
