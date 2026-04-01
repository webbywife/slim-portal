<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OnlineSection extends Model {
    protected $fillable = [
        'section_label','heading_line1','heading_line2','body_text',
        'cta_primary_text','cta_primary_url','cta_secondary_text','cta_secondary_url',
        'platform_name','platform_tagline','platform_url',
    ];
}
