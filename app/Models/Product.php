<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'fabric',
        'regular_price',
        'sale_price',
        'stock',
        'is_featured',
        'is_new',
        'is_bestseller',
        'status',
        'primary_image',
        'gallery_images',
        'sizes',
        'lengths',
        'colors',
        'rating',
        'reviews_count',
    ];

    protected function casts(): array
    {
        return [
            'regular_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'stock' => 'integer',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_bestseller' => 'boolean',
            'gallery_images' => 'array',
            'sizes' => 'array',
            'lengths' => 'array',
            'colors' => 'array',
            'rating' => 'decimal:2',
            'reviews_count' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(4);
            }
            if (empty($product->sku) && !empty($product->name)) {
                $product->sku = 'HH-' . strtoupper(Str::random(6));
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function allReviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->regular_price 
            ? $this->sale_price 
            : $this->regular_price);
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->regular_price;
    }

    public function getDiscountPercentAttribute(): int
    {
        if ($this->has_discount && $this->regular_price > 0) {
            return (int) round((($this->regular_price - $this->sale_price) / $this->regular_price) * 100);
        }
        return 0;
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        if ($this->primary_image) {
            if (str_starts_with($this->primary_image, 'http')) {
                return $this->primary_image;
            }
            return asset($this->primary_image);
        }
        return asset('images/logo.jpg');
    }

    public function getGalleryImageUrlsAttribute(): array
    {
        $urls = [];
        if (!empty($this->gallery_images) && is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $img) {
                if ($img) {
                    $urls[] = str_starts_with($img, 'http') ? $img : asset($img);
                }
            }
        }
        return $urls;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->active()->where('is_featured', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->active()->where('is_new', true)->latest();
    }

    public function scopeBestsellers($query)
    {
        return $query->active()->where('is_bestseller', true);
    }
}
