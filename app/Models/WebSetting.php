<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_title',
        'site_description',
        'logo_path',
        'favicon_path',
        'home_hero_title',
        'home_hero_description',
        'home_hero_image_path',
        'home_features',
        'footer_text',
        'social_links',
        'primary_color',
        'secondary_color'
    ];

    protected $casts = [
        'home_features' => 'array',
        'social_links' => 'array'
    ];

    // Accessor to ensure JSON fields are properly decoded
    public function getHomeFeaturesAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true);
        }
        return $value;
    }

    // Mutator to ensure JSON fields are properly encoded
    public function setHomeFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['home_features'] = json_encode($value);
        } else {
            $this->attributes['home_features'] = $value;
        }
    }

    // Accessor to ensure JSON fields are properly decoded
    public function getSocialLinksAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true);
        }
        return $value;
    }

    // Mutator to ensure JSON fields are properly encoded
    public function setSocialLinksAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['social_links'] = json_encode($value);
        } else {
            $this->attributes['social_links'] = $value;
        }
    }

    // Get the first (and only) web setting record
    public static function getSettings()
    {
        return self::first() ?? new self();
    }
}
