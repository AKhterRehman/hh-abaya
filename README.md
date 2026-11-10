# ✨ H&H Abaya Collection — Luxury Modest Fashion E-Commerce Platform

<p align="center">
  <img src="public/images/logo.jpg" width="160" height="160" alt="H&H Abaya Collection Logo" style="border-radius: 50%; box-shadow: 0 4px 20px rgba(197, 160, 89, 0.4);" />
</p>

<p align="center">
  <strong>Modern Modesty, Timeless Grace</strong><br>
  A complete end-to-end luxury e-commerce platform and administrative portal for handcrafted abayas, French khimars, 3-piece jilbabs, and modest coords inspired by high-end brands like <em>Sitr Official</em>.
</p>

---

## 🌟 Key Features

### 🛍️ Client / Customer Storefront
- **Luxury Brand Aesthetics:** Warm Champagne Gold (`#C5A059`), Dusty Rose (`#8C6D68`), Ivory Cream (`#FAF7F2`), and Deep Espresso (`#231F20`) palette with elegant typography.
- **Top Announcement Bar:** Dynamic ticker with Free Nationwide Shipping threshold (PKR 5,000+), currency indicator, order tracking shortcut, and WhatsApp support.
- **Slide-Over Cart Drawer:** Free shipping progress bar, instant quantity stepper, remove item, subtotal, and direct checkout shortcut without full-page reloads.
- **Dual-Image Hover Swap:** Hovering on any product card smoothly fades into the secondary lookbook angle.
- **Quick View Modal:** Inspect abaya specifications, size chart, color swatches, and add to bag in 1-click.
- **Abaya Length & Sizing System:** Standard UK/PK sizes (`XS` to `XXL`) plus dedicated **Abaya Length options (`50"`, `52"`, `54"`, `56"`, `58"`, `60"`)**.
- **Interactive Height-to-Length Calculator:** Customers select their height (e.g. 5'3" - 5'4") to immediately receive the recommended floor-length size.
- **"Build Your Look" Bundle Builder:** Curated combinations (Abaya + Matching Khimar + Magnetic Hijab Pins) with bundle discounts.
- **1-Page Express Checkout:**
  - Complete Pakistani cities dropdown
  - **Cash on Delivery (COD)**
  - **Direct Bank Wire Transfer** (Meezan Bank account details & IBAN)
  - **Credit/Debit Card** simulation
  - Real-time coupon redemption (`WELCOME10`, `EID15`, `FREESHIP`)
- **1-Click WhatsApp Order Confirmation:** Pre-fills customer name, order number, and total payable directly into WhatsApp.
- **Live Order Tracking (`/track-order`):** 4-step progress stepper (*Order Placed ➔ Tailoring & Packing ➔ Shipped with Courier & Airway Bill # ➔ Delivered*).
- **Customer Self-Service Dashboard:** Profile management, saved default delivery address, and full order history.
- **Wishlist System:** Interactive heart toggle saving favorite pieces across sessions.
- **Informational Pages:** Comprehensive Size Guide, Brand Story & Heritage, Contact Concierge with inquiry form, Shipping & Exchange Policy (7-day exchange), and FAQs.

---

### 🛡️ Administrative Portal (`/admin`)
- **Secure Authentication:** Protected with dedicated `admin` role middleware.
- **Executive Dashboard:**
  - KPI Metrics (Total Sales Revenue, Total Orders, Active Catalog, Registered Clients)
  - Low Stock Alerts widget
  - Recent Orders table with real-time status badges
  - Popular / Top Selling Abayas ranking
- **Product Management:** Full CRUD, image uploads (`public/uploads/products`), gallery images, fabric composition, SKU, stock quantity, size/length/color arrays, featured & bestseller toggles, and status control.
- **Category Management:** Create and edit collections with circular avatar cover uploads and sort orders.
- **Order Fulfillment & Logistics:**
  - Filter orders by status (*Pending, Processing, Shipped, Delivered, Cancelled*)
  - Update payment status (*Pending, Paid, Failed*)
  - Assign Courier partner (*TCS Express, Call Courier, Leopards, Trax*) and Tracking Number
  - **Printable Packing Slip & Official Invoice** (`/admin/orders/{id}/invoice`)
- **Coupons & Promotions:** Create fixed or percentage discount codes with minimum spend thresholds and usage counters.
- **Reviews Moderation:** Approve, hide, or delete verified customer feedback.
- **Hero Slider Banners:** Manage homepage carousel slides, badges, titles, and CTA links.
- **Client Directory:** Inspect registered clients, order counts, and lifetime delivered spend.
- **Store Settings & Message Inbox:** Configure store contact details, WhatsApp concierge, Meezan Bank details, announcement marquee, and reply to client inquiries.

---

## 🗄️ Database Architecture
All database migrations have been structured with `nullable()` on every column to allow effortless customizations and optional field adjustments:
- `users` (Role, Phone, Address, City)
- `categories` (Name, Slug, Description, Image, Is Featured, Is Active, Sort Order)
- `products` (Category ID, Name, Slug, SKU, Descriptions, Fabric, Prices, Stock, Images, Sizes, Lengths, Colors, Ratings)
- `orders` & `order_items` (Order Reference, Customer Details, Payment, Courier & Tracking, Order Notes)
- `coupons` (Code, Type, Value, Min Amount, Usage Limits, Expiry)
- `reviews` (Product ID, Customer, Rating 1-5, Title, Text, Approval Status)
- `banners` (Title, Subtitle, Badge, Buttons, Image, Sort Order, Active Status)
- `settings`, `wishlists`, and `contact_messages`

---

## 🚀 Getting Started

### 1. Requirements
- PHP >= 8.2 with `pdo_sqlite` or `pdo_mysql` enabled
- Composer
- Node.js & npm (Optional — frontend utilizes standalone Tailwind & Alpine.js CDN)

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/AKhterRehman/hh-abaya.git
cd hh-abaya

# Install PHP dependencies
composer install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database migrations & demo seeders
php artisan migrate --seed

# Optimize cache
php artisan optimize:clear
```

### 3. Default Credentials
| Portal | URL | Email | Password |
| :--- | :--- | :--- | :--- |
| **Admin Portal** | `/admin/login` | `admin@hh-abaya.com` | `password123` |
| **Customer Account** | `/login` | `customer@hh-abaya.com` | `password123` |

### 4. Sample Promo Codes
- `WELCOME10` — 10% OFF
- `EID15` — 15% OFF (Orders above PKR 6,000)
- `FREESHIP` — Complimentary Shipping (PKR 250 discount)

---

## 📜 License
Crafted with elegance and reverence for **H&H Abaya Collection**.
All rights reserved © 2026.
