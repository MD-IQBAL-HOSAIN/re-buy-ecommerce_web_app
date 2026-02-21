<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'language_id',
        'code',
        'name',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the buy categories for the language.
     */
    public function buyCategories()
    {
        return $this->hasMany(BuyCategory::class);
    }

    /**
     * Get the CMS entries for the language.
     */
    public function cmsEntries()
    {
        return $this->hasMany(CMS::class);
    }

    /**
     * Get the accessories for the language.
     */
    public function accessories()
    {
        return $this->hasMany(Accessory::class);
    }

    /**
     * Get the colors for the language.
     */
    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    /**
     * Get the conditions for the language.
     */
    public function conditions()
    {
        return $this->hasMany(Condition::class);
    }

    /**
     * Get the protection services for the language.
     */
    public function protectionServices()
    {
        return $this->hasMany(ProtectionService::class);
    }

    /**
     * Get the storages for the language.
     */
    public function storages()
    {
        return $this->hasMany(Storage::class);
    }

    /**
     * Get the pages for the language.
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the FAQs for the language.
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    /**
     * Get the reviews for the language.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the sell electronics for the language.
     */
    public function sellElectronics()
    {
        return $this->hasMany(SellElectronics::class);
    }

    /**
     * Get the how it works for the language.
     */
    public function howItWorks()
    {
        return $this->hasMany(HowItWork::class);
    }

    /**
     * Get the trust features for the language.
     */
    public function trustFeatures()
    {
        return $this->hasMany(TrustFeature::class);
    }

    /**
     * Get the sell products     for the language.
     */
    public function sellProducts()
    {
        return $this->hasMany(SellProduct::class);
    }
}
