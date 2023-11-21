<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_code',
        'tka_id',
        'name',
        'currency',
        'currency_currency_title',
        'currency_symbol',
        'currency_symbol_html',
        'iso3',
        'sales_tax_label',
        'charge_vat',
        'vat_percentage',
        'vat_amount_elearning',
        'conversion_required',
        'exchange_rate',
        'opening_hours',
        'opening_days',
        'date_format',
        'isAdvert',
        'map_id',
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_country');
    }
    public function Blog()
    {
        return $this->belongsToMany(Category::class, 'blog_country');
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'country_courses')->withTimestamps()->withPivot(['is_popular', 'deleted_at']);;
    }
}
