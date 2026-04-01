<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class About extends Model {
    protected $fillable = [
        'section_label','heading_main','heading_em',
        'body_para1','body_para2','quote_text','quote_cite',
        'badge_number','badge_text',
    ];
}
