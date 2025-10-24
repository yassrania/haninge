<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    protected $table = 'membership_applications';

    protected $fillable = [
        'full_name','personal_number','email','phone','address','apply_date',
        'signature_type','signature_image_path','signature_text','pdf_path',
        'ip','user_agent',
    ];

    protected $casts = [
        'apply_date' => 'date',
    ];
}
