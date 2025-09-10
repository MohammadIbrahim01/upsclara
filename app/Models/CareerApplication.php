<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CareerApplication extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $appends = [
        'resume',
    ];

    public $table = 'career_applications';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'location',
        'experience',
        'qualifications',
        'message',
        'job_opening_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getResumeAttribute()
    {
        return $this->getMedia('resume')->last();
    }

    public function job_opening()
    {
        return $this->belongsTo(JobOpening::class, 'job_opening_id');
    }
}
