<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedium extends Model
{
    use HasFactory;

    public $table = 'social_media';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_id',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'linkedin_link',
        'youtube_link',
        'google_link',
        'snapchat_link',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
