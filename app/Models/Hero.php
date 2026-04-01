<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model {
    protected $fillable = [
        'eyebrow','headline_main','headline_em','subheadline',
        'cta_primary_text','cta_primary_url','cta_secondary_text','cta_secondary_url',
        'seal_year','seal_name','seal_tagline',
    ];
}
