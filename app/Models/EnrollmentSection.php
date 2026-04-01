<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EnrollmentSection extends Model {
    protected $fillable = [
        'section_label','heading','body_text',
        'req_card_title','req_note','cta_text','cta_url',
    ];
}
