<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin & Customer Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@hh-abaya.com'],
            [
                'name' => 'H&H Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+92 300 1234567',
                'address' => 'H&H Flagship Studio, DHA Phase 5',
                'city' => 'Karachi',
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@hh-abaya.com'],
            [
                'name' => 'Ayesha Khan',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+92 321 9876543',
                'address' => 'House 42-B, Block 6, Gulshan-e-Iqbal',
                'city' => 'Karachi',
            ]
        );

        // 2. Default Store Settings
        $settings = [
            'store_name' => 'H&H Abaya Collection',
            'store_tagline' => 'Modern Modesty, Timeless Grace',
            'store_email' => 'info@hhabaya.com',
            'store_phone' => '+92 300 1234567',
            'store_whatsapp' => '923001234567',
            'store_address' => 'DHA Phase 5, Karachi, Pakistan',
            'currency_symbol' => 'PKR',
            'free_shipping_min' => '5000',
            'standard_shipping_fee' => '250',
            'announcement_text' => '✨ FREE Nationwide Delivery on orders above PKR 5,000 | Worldwide Shipping Available | COD Available ✨',
            'bank_name' => 'Meezan Bank Ltd',
            'bank_account_title' => 'H&H Abaya Collection',
            'bank_account_number' => '0101-0103456789',
            'bank_iban' => 'PK64MEZN0001010103456789',
            'instagram_url' => 'https://instagram.com',
            'facebook_url' => 'https://facebook.com',
            'about_story' => 'H&H Abaya Collection was founded with a profound commitment to redefine contemporary modest fashion. Rooted in dignity, craftsmanship, and timeless refinement, each garment is tailored from the finest imported Saudi Nidha and Korean Georgette fabrics to inspire confidence and reverence in every woman.',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Promotional Banners (Hero Slider)
        Banner::truncate();
        Banner::create([
            'title' => 'The Autumn-Winter Luxury Edit',
            'subtitle' => 'Handcrafted silhouettes in premium Dubai Nidha & rich earth tones.',
            'badge' => 'New Season 2026',
            'button_text' => 'Explore Luxury Edit',
            'button_link' => '/shop?category=luxury-front-open',
            'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=1600&q=80',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'The Sacred Journey: Umrah Edit',
            'subtitle' => 'Featherlight, breathable, non-transparent abayas designed for worship and ease.',
            'badge' => 'Pilgrimage Essentials',
            'button_text' => 'Shop Umrah Edit',
            'button_link' => '/shop?category=the-umrah-edit',
            'image' => 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=1600&q=80',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Matching Khimar Sets',
            'subtitle' => 'Seamless modesty with our bestselling 2-piece French Khimar and slip abaya combos.',
            'badge' => 'Bestseller Combos',
            'button_text' => 'Discover Khimars',
            'button_link' => '/shop?category=khimar-sets',
            'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1600&q=80',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 4. Categories
        Category::truncate();
        $catEveryday = Category::create([
            'name' => 'Everyday Abayas',
            'slug' => 'everyday-abayas',
            'description' => 'Breathable, lightweight silhouettes crafted from pure Dubai Nidha for daily comfort & durability.',
            'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $catLuxury = Category::create([
            'name' => 'Luxury Front Open',
            'slug' => 'luxury-front-open',
            'description' => 'Statement evening abayas featuring subtle hand embellishments, satin piping, and flowy bell sleeves.',
            'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $catKhimar = Category::create([
            'name' => 'Khimar Sets & Combos',
            'slug' => 'khimar-sets',
            'description' => 'Coordinated French khimar and slip abaya pairings designed for effortless full coverage.',
            'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $catJilbab = Category::create([
            'name' => '3-Piece Jilbabs',
            'slug' => '3-piece-jilbabs',
            'description' => 'Graceful full-length jilbab ensembles with matching flared skirts and breathable tie-back niqabs.',
            'image' => 'https://images.unsplash.com/photo-1550614000-4895a10e1bfd?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $catUmrah = Category::create([
            'name' => 'The Umrah Edit',
            'slug' => 'the-umrah-edit',
            'description' => 'Featherlight, non-transparent, crease-resistant travel abayas tailored for sacred pilgrimage journeys.',
            'image' => 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 5,
        ]);

        $catNamaz = Category::create([
            'name' => 'Namaz Chadars & Hijabs',
            'slug' => 'namaz-chadars-hijabs',
            'description' => 'Soft Turkish cotton prayer chadars with elasticated sleeves and luxury crinkle chiffon hijabs.',
            'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // Standard Variants
        $standardSizes = ['XS', 'S', 'M', 'L', 'XL'];
        $standardLengths = ['50"', '52"', '54"', '56"', '58"', '60"'];

        // 5. Products
        Product::truncate();
        $productsData = [
            [
                'category_id' => $catLuxury->id,
                'name' => 'Aura Hand-Embroidered Front-Open Abaya',
                'sku' => 'HH-LXR-001',
                'short_description' => 'Exquisite rose gold threadwork embroidery on cuffs and lapel, cut from ultra-soft Dubai Nidha with matching chiffon shayla.',
                'description' => "Indulge in unmatched opulence with the Aura Embroidered Front-Open Abaya. Meticulously handcrafted by master artisans, this silhouette features delicate rose gold and copper floral embroidery along the bell sleeves and front neckline.\n\nCrafted from our signature mid-weight Dubai Nidha fabric, it drapes with fluid grace and offers complete opacity. Pair it open with an inner slip dress or secure it with discreet inner snap buttons for modest coverage.",
                'fabric' => 'Premium Dubai Nidha & Pure Chiffon Trim',
                'regular_price' => 9800.00,
                'sale_price' => 8450.00,
                'stock' => 24,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Dusty Rose Mocha', 'code' => '#8C6D68'],
                    ['name' => 'Midnight Black', 'code' => '#111111'],
                    ['name' => 'Warm Champagne', 'code' => '#D4AF37'],
                ],
                'rating' => 4.95,
                'reviews_count' => 38,
            ],
            [
                'category_id' => $catEveryday->id,
                'name' => 'Rawdah Everyday Minimalist Silhouette',
                'sku' => 'HH-EVD-002',
                'short_description' => 'The ultimate daily essential. Breathable, crease-resistant, with discreet side pockets and elasticated wudhu-friendly cuffs.',
                'description' => "Engineered specifically for everyday convenience, university, and professional wear, the Rawdah Everyday Abaya delivers effortless sophistication. Made with breathable Korean Aero Crepe that requires minimal ironing and retains its rich shade wash after wash.",
                'fabric' => 'Breathable Korean Aero Crepe',
                'regular_price' => 5800.00,
                'sale_price' => 4990.00,
                'stock' => 50,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Jet Black', 'code' => '#1A1A1A'],
                    ['name' => 'Muted Sage', 'code' => '#7B8D7C'],
                    ['name' => 'Desert Sand', 'code' => '#C4B19C'],
                ],
                'rating' => 4.90,
                'reviews_count' => 52,
            ],
            [
                'category_id' => $catUmrah->id,
                'name' => 'Madinah Umrah 2-Piece Travel Abaya',
                'sku' => 'HH-UMR-003',
                'short_description' => 'Featherweight, fully opaque white & earthy linen abaya with zipper pockets to keep passport, dua books, and valuables secure.',
                'description' => "Designed after extensive feedback from pilgrims performing Tawaf and Sa'ee. The Madinah Umrah 2-Piece Travel Abaya combines maximum breathability with deep hidden zip pockets to secure your valuables in crowded holy sites. Non-see-through fabric that drapes effortlessly in hot weather.",
                'fabric' => 'Cool-Touch Saudi Nidha',
                'regular_price' => 7500.00,
                'sale_price' => 6499.00,
                'stock' => 35,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Oasis White', 'code' => '#F8F9FA'],
                    ['name' => 'Mecca Black', 'code' => '#111111'],
                    ['name' => 'Warm Stone', 'code' => '#B8A698'],
                ],
                'rating' => 4.98,
                'reviews_count' => 64,
            ],
            [
                'category_id' => $catKhimar->id,
                'name' => 'Layla 2-Piece French Khimar & Slip Set',
                'sku' => 'HH-KHM-004',
                'short_description' => 'A floor-skimming French Khimar paired with a straight cut sleeveless slip abaya. Tie-back ribbons allow flexible styling as a niqab.',
                'description' => "Experience the epitome of serene modesty. The Layla French Khimar Set is designed with adjustable integrated head ties that can be tied under the hair or worn as a face veil / niqab. Made from flowy pebble georgette with an inner cooling cotton lining.",
                'fabric' => 'Korean Pebble Georgette & Breathable Slip',
                'regular_price' => 8200.00,
                'sale_price' => 6999.00,
                'stock' => 28,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Mauve Rose', 'code' => '#8C6D68'],
                    ['name' => 'Deep Navy', 'code' => '#1A2A3A'],
                    ['name' => 'Forest Green', 'code' => '#2D4436'],
                    ['name' => 'Jet Black', 'code' => '#111111'],
                ],
                'rating' => 4.88,
                'reviews_count' => 29,
            ],
            [
                'category_id' => $catLuxury->id,
                'name' => 'Zehra Velvet Trim Double-Tone Abaya',
                'sku' => 'HH-LXR-005',
                'short_description' => 'Dual-layered contrast sleeves finished with plush micro-velvet trimming and gold piped details for formal soirees.',
                'description' => "Make an unforgettable statement with the Zehra Double-Tone Abaya. Drawing inspiration from royal Andalusian aesthetics, the bell sleeves feature rich micro-velvet accents framed with delicate metallic gold piping.",
                'fabric' => 'Heavy Dubai Nidha & Micro-Velvet Accents',
                'regular_price' => 11500.00,
                'sale_price' => 9800.00,
                'stock' => 18,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Midnight & Gold', 'code' => '#1A1A1A'],
                    ['name' => 'Mocha & Champagne', 'code' => '#7A5C58'],
                ],
                'rating' => 4.96,
                'reviews_count' => 41,
            ],
            [
                'category_id' => $catJilbab->id,
                'name' => 'Sakinah 3-Piece Overhead Jilbab Ensemble',
                'sku' => 'HH-JLB-006',
                'short_description' => 'Complete modest coverage comprising an extra-wide overhead cape, flared high-waist maxi skirt, and breathable soft niqab.',
                'description' => "The Sakinah 3-Piece Jilbab offers majestic coverage and supreme comfort. Features elasticated smocked cuffs that stay in place during prayer and movements, and an elasticated waistband skirt with side pocket.",
                'fabric' => 'Silky Cey Crepe',
                'regular_price' => 8900.00,
                'sale_price' => 7450.00,
                'stock' => 22,
                'is_featured' => false,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1550614000-4895a10e1bfd?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1550614000-4895a10e1bfd?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Charcoal Smoke', 'code' => '#333333'],
                    ['name' => 'Rose Taupe', 'code' => '#8C6D68'],
                    ['name' => 'Olive Moss', 'code' => '#4A5B48'],
                ],
                'rating' => 4.92,
                'reviews_count' => 23,
            ],
            [
                'category_id' => $catEveryday->id,
                'name' => 'Noor Dubai Zoom Flared Kimono',
                'sku' => 'HH-EVD-007',
                'short_description' => 'Textured Zoom fabric with a contemporary kimono silhouette. Features a detachable matching belt and tonal piping.',
                'description' => "Modern modest tailoring meets everyday luxury. The Noor Kimono is fashioned from textured Dubai Zoom fabric which boasts a subtle ridged texture that catches light beautifully without wrinkling.",
                'fabric' => 'Textured Dubai Zoom',
                'regular_price' => 6900.00,
                'sale_price' => 5950.00,
                'stock' => 30,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => false,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Blush Mocha', 'code' => '#8C6D68'],
                    ['name' => 'Slate Grey', 'code' => '#6C757D'],
                    ['name' => 'Classic Onyx', 'code' => '#0F0F0F'],
                ],
                'rating' => 4.85,
                'reviews_count' => 17,
            ],
            [
                'category_id' => $catNamaz->id,
                'name' => 'Safiyyah Floral Turkish Cotton Namaz Chadar',
                'sku' => 'HH-NMZ-008',
                'short_description' => 'Lightweight 100% Turkish cotton prayer chadar with attached hijab and soft elasticated cuffs to keep your hands free for prayer.',
                'description' => "Immerse in tranquility during prayer. Made from 100% pure Turkish organic cotton, the Safiyyah Namaz Chadar stays cool against the skin and provides complete opacity with generous 65-inch length.",
                'fabric' => '100% Pure Turkish Cotton',
                'regular_price' => 4200.00,
                'sale_price' => 3450.00,
                'stock' => 40,
                'is_featured' => false,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => ['Free Size'],
                'lengths' => ['62" Full Flared'],
                'colors' => [
                    ['name' => 'Dusty Rose Blossom', 'code' => '#C49A94'],
                    ['name' => 'Sage Leaf', 'code' => '#8E9E8D'],
                    ['name' => 'Pearl Ivory', 'code' => '#F4EBE1'],
                ],
                'rating' => 4.97,
                'reviews_count' => 45,
            ],
            [
                'category_id' => $catEveryday->id,
                'name' => 'Rabab Scallop Cuff Black Nidha Abaya',
                'sku' => 'HH-EVD-009',
                'short_description' => 'A timeless classic black abaya featuring laser-cut scalloped cuffs with subtle matte pearl embellishments.',
                'description' => "The quintessential black abaya elevated with subtle feminine charm. Designed with laser-cut scalloped cuffs that frame the wrists with elegance, crafted from pitch-black imported Saudi Nidha.",
                'fabric' => 'Original Black Saudi Nidha',
                'regular_price' => 7800.00,
                'sale_price' => 6650.00,
                'stock' => 25,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Intense Black', 'code' => '#0A0A0A'],
                ],
                'rating' => 4.91,
                'reviews_count' => 31,
            ],
            [
                'category_id' => $catLuxury->id,
                'name' => 'Hoor Pleated Georgette Evening Cape Abaya',
                'sku' => 'HH-LXR-010',
                'short_description' => 'Accordion micro-pleating on back cape with belted front and crystal-accented cuffs for weddings and Eid occasions.',
                'description' => "Command presence at weddings and festive events. The Hoor Evening Abaya showcases micro-pleated flutter cape detailing along the back and shoulders, catching the breeze as you walk.",
                'fabric' => 'Pleated Korean Georgette & Silk Slip',
                'regular_price' => 12900.00,
                'sale_price' => 10990.00,
                'stock' => 15,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'status' => 'active',
                'primary_image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=800&q=80',
                'gallery_images' => [
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=800&q=80',
                ],
                'sizes' => $standardSizes,
                'lengths' => $standardLengths,
                'colors' => [
                    ['name' => 'Champagne Metallic', 'code' => '#C5A059'],
                    ['name' => 'Dusty Plum', 'code' => '#5C384B'],
                    ['name' => 'Pitch Black', 'code' => '#0F0F0F'],
                ],
                'rating' => 4.99,
                'reviews_count' => 19,
            ],
        ];

        foreach ($productsData as $pData) {
            $product = Product::create($pData);

            // 6. Reviews for products
            Review::create([
                'product_id' => $product->id,
                'user_id' => $customer->id,
                'customer_name' => 'Ayesha Khan',
                'customer_email' => 'ayesha.k@example.com',
                'rating' => 5,
                'review_title' => 'Exceptional fabric & flawless stitching!',
                'review_text' => 'MashaAllah the quality is even more stunning than in the photos! The length 54" fits my height 5\'4" perfectly. Will definitely order again from H&H Abaya Collection.',
                'is_approved' => true,
            ]);

            Review::create([
                'product_id' => $product->id,
                'user_id' => null,
                'customer_name' => 'Fatima Zehra',
                'customer_email' => 'fatima.z@example.com',
                'rating' => 5,
                'review_title' => 'Very modest and elegant drape',
                'review_text' => 'The fabric feels so luxurious and light. Delivery to Lahore was quick within 3 days. Loved the packaging and free matching hijab pin gift!',
                'is_approved' => true,
            ]);
        }

        // 7. Coupons
        Coupon::truncate();
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 3000,
            'usage_limit' => 500,
            'used_count' => 42,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'EID15',
            'type' => 'percentage',
            'value' => 15,
            'min_order_amount' => 6000,
            'usage_limit' => 200,
            'used_count' => 18,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'type' => 'fixed',
            'value' => 250,
            'min_order_amount' => 4000,
            'usage_limit' => 1000,
            'used_count' => 97,
            'is_active' => true,
        ]);

        // 8. Sample Initial Orders for Admin analytics & tracking demonstration
        Order::truncate();
        OrderItem::truncate();

        $sampleProduct1 = Product::first();
        $sampleProduct2 = Product::skip(1)->first();

        // Completed Order
        $order1 = Order::create([
            'order_number' => 'HH-2026-8941',
            'user_id' => $customer->id,
            'customer_name' => 'Ayesha Khan',
            'customer_email' => 'customer@hh-abaya.com',
            'customer_phone' => '03219876543',
            'shipping_address' => 'House 42-B, Block 6, Gulshan-e-Iqbal',
            'city' => 'Karachi',
            'province' => 'Sindh',
            'postal_code' => '75300',
            'payment_method' => 'cod',
            'payment_status' => 'paid',
            'order_status' => 'delivered',
            'subtotal' => 8450.00,
            'shipping_fee' => 0.00,
            'discount' => 0.00,
            'total' => 8450.00,
            'courier_name' => 'TCS Express',
            'tracking_number' => 'TCS789456123PK',
            'order_notes' => 'Please deliver in afternoon.',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $sampleProduct1->id,
            'product_name' => $sampleProduct1->name,
            'product_image' => $sampleProduct1->primary_image,
            'price' => 8450.00,
            'quantity' => 1,
            'size' => 'M',
            'length' => '54"',
            'color' => 'Dusty Rose Mocha',
            'total' => 8450.00,
        ]);

        // Processing Order
        $order2 = Order::create([
            'order_number' => 'HH-2026-9210',
            'user_id' => null,
            'customer_name' => 'Maryam Tariq',
            'customer_email' => 'maryam.tariq@gmail.com',
            'customer_phone' => '03021122334',
            'shipping_address' => 'Apartment 404, Al-Hafeez Heights, Gulberg III',
            'city' => 'Lahore',
            'province' => 'Punjab',
            'postal_code' => '54000',
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending',
            'order_status' => 'processing',
            'subtotal' => 9980.00,
            'shipping_fee' => 0.00,
            'discount' => 998.00,
            'coupon_code' => 'WELCOME10',
            'total' => 8982.00,
            'courier_name' => 'Call Courier',
            'tracking_number' => 'CC-55443322',
            'order_notes' => 'Transferred via Meezan App. Reference #7819.',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $sampleProduct2->id,
            'product_name' => $sampleProduct2->name,
            'product_image' => $sampleProduct2->primary_image,
            'price' => 4990.00,
            'quantity' => 2,
            'size' => 'S',
            'length' => '52"',
            'color' => 'Jet Black',
            'total' => 9980.00,
        ]);

        // Pending New Order
        $order3 = Order::create([
            'order_number' => 'HH-2026-9533',
            'user_id' => null,
            'customer_name' => 'Zainab Bilal',
            'customer_email' => 'zainab.b@hotmail.com',
            'customer_phone' => '03335566778',
            'shipping_address' => 'Street 14, Sector F-7/2',
            'city' => 'Islamabad',
            'province' => 'Federal',
            'postal_code' => '44000',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'subtotal' => 4990.00,
            'shipping_fee' => 250.00,
            'discount' => 0.00,
            'total' => 5240.00,
            'order_notes' => 'Call before arrival please.',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $sampleProduct2->id,
            'product_name' => $sampleProduct2->name,
            'product_image' => $sampleProduct2->primary_image,
            'price' => 4990.00,
            'quantity' => 1,
            'size' => 'L',
            'length' => '56"',
            'color' => 'Muted Sage',
            'total' => 4990.00,
        ]);
    }
}
