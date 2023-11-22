<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Country extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
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
        return $this->belongsToMany(Category::class, 'country_category');
    }
    public function Blog()
    {
        return $this->belongsToMany(Blog::class, 'country_blog')->withTimestamps();
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'country_courses')->withTimestamps()->withPivot(['is_popular', 'deleted_at']);
    }
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'country_topics')->withTimestamps();
    }
}
