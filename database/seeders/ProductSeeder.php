<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tribe;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Mekhela Chador' => Category::where('slug', 'mekhela-chador')->first(),
            'Shawls' => Category::where('slug', 'shawls')->first(),
            'Handloom Fabrics' => Category::where('slug', 'handloom-fabrics')->first(),
            'Jewelry' => Category::where('slug', 'jewelry')->first(),
            'Jackets' => Category::where('slug', 'jackets')->first(),
        ];

        $tribes = [
            'Assamese' => Tribe::where('slug', 'assamese')->first(),
            'Bodo' => Tribe::where('slug', 'bodo')->first(),
            'Mishing' => Tribe::where('slug', 'mishing')->first(),
            'Naga' => Tribe::where('slug', 'naga')->first(),
            'Mizo' => Tribe::where('slug', 'mizo')->first(),
            'Manipuri' => Tribe::where('slug', 'manipuri')->first(),
            'Khasi' => Tribe::where('slug', 'khasi')->first(),
        ];

        $products = [
            [
                'name' => 'Golden Muga Silk Mekhela Chador',
                'slug' => 'golden-muga-silk-mekhela-chador',
                'description' => 'Authentic handwoven Muga silk Mekhela Chador from Assam. This traditional two-piece attire features intricate designs inspired by Assamese heritage. Perfect for weddings and special occasions.',
                'price' => 12500,
                'discount_price' => 9999,
                'stock' => 15,
                'fabric' => 'Muga Silk',
                'occasion' => 'Wedding',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Mekhela Chador']->id,
                'tribe_id' => $tribes['Assamese']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=600&q=80',
                    'https://images.unsplash.com/photo-1595039838779-f3780873afdd?w=600&q=80',
                    'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=600&q=80',
                ],
            ],
            [
                'name' => 'Traditional Eri Silk Shawl',
                'slug' => 'traditional-eri-silk-shawl',
                'description' => 'Handwoven Eri silk shawl with traditional motifs. Eri silk, also known as peace silk, is soft, warm, and eco-friendly. Perfect for winter layering.',
                'price' => 4500,
                'discount_price' => null,
                'stock' => 25,
                'fabric' => 'Eri Silk',
                'occasion' => 'Daily Wear',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Shawls']->id,
                'tribe_id' => $tribes['Mishing']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=600&q=80',
                    'https://images.unsplash.com/photo-1584671953163-9444d9c1832f?w=600&q=80',
                ],
            ],
            [
                'name' => 'Naga Shawl with Tribal Patterns',
                'slug' => 'naga-shawl-tribal-patterns',
                'description' => 'Authentic Naga shawl featuring vibrant tribal patterns. Handwoven by skilled artisans from Nagaland, each piece tells a unique story of Naga heritage.',
                'price' => 6800,
                'discount_price' => 5500,
                'stock' => 12,
                'fabric' => 'Wool',
                'occasion' => 'Festival',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Shawls']->id,
                'tribe_id' => $tribes['Naga']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1578601986830-1c1855b68054?w=600&q=80',
                    'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=600&q=80',
                ],
            ],
            [
                'name' => 'Pat Silk Mekhela Chador',
                'slug' => 'pat-silk-mekhela-chador',
                'description' => 'Elegant Pat silk Mekhela Chador in traditional white with golden motifs. Pat silk is known for its lustrous finish and lightweight feel.',
                'price' => 9800,
                'discount_price' => null,
                'stock' => 8,
                'fabric' => 'Pat Silk',
                'occasion' => 'Wedding',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Mekhela Chador']->id,
                'tribe_id' => $tribes['Assamese']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1569388330292-7a6a84165c6c?w=600&q=80',
                    'https://images.unsplash.com/photo-1562572159-4efc207f5aff?w=600&q=80',
                ],
            ],
            [
                'name' => 'Mizo Puan with Traditional Weave',
                'slug' => 'mizo-puan-traditional-weave',
                'description' => 'Authentic Mizo Puan handwoven with traditional patterns. Each piece showcases the rich textile heritage of Mizoram.',
                'price' => 5200,
                'discount_price' => 4200,
                'stock' => 18,
                'fabric' => 'Cotton',
                'occasion' => 'Festival',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Handloom Fabrics']->id,
                'tribe_id' => $tribes['Mizo']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=600&q=80',
                    'https://images.unsplash.com/photo-1593032465175-481ac7f401a0?w=600&q=80',
                ],
            ],
            [
                'name' => 'Khasi Jainsem Traditional Dress',
                'slug' => 'khasi-jainsem-traditional-dress',
                'description' => 'Traditional Khasi Jainsem from Meghalaya. Handwoven with intricate patterns that reflect the rich cultural heritage of the Khasi tribe.',
                'price' => 7500,
                'discount_price' => null,
                'stock' => 10,
                'fabric' => 'Cotton',
                'occasion' => 'Ceremonial',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Handloom Fabrics']->id,
                'tribe_id' => $tribes['Khasi']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=600&q=80',
                    'https://images.unsplash.com/photo-1584671953163-9444d9c1832f?w=600&q=80',
                ],
            ],
            [
                'name' => 'Bodo Wool Shawl',
                'slug' => 'bodo-wool-shawl',
                'description' => 'Traditional Bodo wool shawl from Assam. Features distinctive geometric patterns typical of Bodo tribal weaving.',
                'price' => 3800,
                'discount_price' => 2999,
                'stock' => 20,
                'fabric' => 'Wool',
                'occasion' => 'Daily Wear',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Shawls']->id,
                'tribe_id' => $tribes['Bodo']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=600&q=80',
                    'https://images.unsplash.com/photo-1578601986830-1c1855b68054?w=600&q=80',
                ],
            ],
            [
                'name' => 'Manipuri Phanek Wrap Skirt',
                'slug' => 'manipuri-phanek-wrap-skirt',
                'description' => 'Traditional Manipuri Phanek handwoven with intricate designs. A essential part of Manipuri traditional attire.',
                'price' => 4200,
                'discount_price' => null,
                'stock' => 14,
                'fabric' => 'Cotton',
                'occasion' => 'Festival',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Handloom Fabrics']->id,
                'tribe_id' => $tribes['Manipuri']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=600&q=80',
                    'https://images.unsplash.com/photo-1562572159-4efc207f5aff?w=600&q=80',
                ],
            ],
            [
                'name' => 'Assamese Gold Jewelry Set',
                'slug' => 'assamese-gold-jewelry-set',
                'description' => 'Traditional Assamese gold-plated jewelry set including necklace, earrings, and bangles. Perfect complement to Mekhela Chador.',
                'price' => 8500,
                'discount_price' => 6999,
                'stock' => 6,
                'fabric' => 'Gold Plated',
                'occasion' => 'Wedding',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Jewelry']->id,
                'tribe_id' => $tribes['Assamese']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=600&q=80',
                    'https://images.unsplash.com/photo-1602751584552-8ba73aad10e1?w=600&q=80',
                ],
            ],
            [
                'name' => 'Naga Traditional Jacket',
                'slug' => 'naga-traditional-jacket',
                'description' => 'Handwoven Naga traditional jacket with tribal embroidery. A unique piece showcasing the rich textile heritage of Nagaland.',
                'price' => 5600,
                'discount_price' => null,
                'stock' => 9,
                'fabric' => 'Wool',
                'occasion' => 'Festival',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Jackets']->id,
                'tribe_id' => $tribes['Naga']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1593032465175-481ac7f401a0?w=600&q=80',
                    'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=600&q=80',
                ],
            ],
            [
                'name' => 'Pure Eri Silk Fabric by Yard',
                'slug' => 'pure-eri-silk-fabric-yard',
                'description' => 'Pure handwoven Eri silk fabric sold by yard. Ideal for custom stitching, scarves, or home decor. Natural off-white color.',
                'price' => 2200,
                'discount_price' => 1800,
                'stock' => 30,
                'fabric' => 'Eri Silk',
                'occasion' => 'Daily Wear',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Handloom Fabrics']->id,
                'tribe_id' => $tribes['Mishing']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1584671953163-9444d9c1832f?w=600&q=80',
                    'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=600&q=80',
                ],
            ],
            [
                'name' => 'Assam Silk Mekhela Chador Set',
                'slug' => 'assam-silk-mekhela-chador-set',
                'description' => 'Complete Mekhela Chador set in premium Assam silk. Includes inner and outer drapes with matching blouse piece.',
                'price' => 15000,
                'discount_price' => 12999,
                'stock' => 5,
                'fabric' => 'Muga Silk',
                'occasion' => 'Wedding',
                'status' => 'active',
                'is_approved' => true,
                'category_id' => $categories['Mekhela Chador']->id,
                'tribe_id' => $tribes['Assamese']->id,
                'images' => [
                    'https://images.unsplash.com/photo-1569388330292-7a6a84165c6c?w=600&q=80',
                    'https://images.unsplash.com/photo-1562572159-4efc207f5aff?w=600&q=80',
                ],
            ],
        ];

        foreach ($products as $productData) {
            $images = $productData['images'];
            unset($productData['images']);

            $product = Product::create($productData);

            foreach ($images as $index => $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageUrl,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        $this->command->info('Products seeded successfully!');
    }
}
