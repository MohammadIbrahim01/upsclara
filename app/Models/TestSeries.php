<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TestSeries extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    public $table = 'test_seriess';

    protected $appends = [
        'featured_image',
        'study_material',
        'timetable',
    ];

    public const LANGUAGE_SELECT = [
        'Hindi'   => 'Hindi',
        'English' => 'English',
    ];

    protected $dates = [
        'enrolment_deadline_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'heading',
        'slug',
        'sub_heading',
        'language',
        'duration',
        'video_lectures',
        'questions_count',
        'enrolment_deadline_date',
        'price',
        'short_description',
        'long_description',
        'content',
        'extra_content',
        'featured_image_caption',
        'featured',
        'active',
        'sequence',
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

    public function getEnrolmentDeadlineDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEnrolmentDeadlineDateAttribute($value)
    {
        $this->attributes['enrolment_deadline_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getFeaturedImageAttribute()
    {
        $file = $this->getMedia('featured_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getStudyMaterialAttribute()
    {
        return $this->getMedia('study_material')->last();
    }

    public function getTimetableAttribute()
    {
        $file = $this->getMedia('timetable')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function test_series_categories()
    {
        return $this->belongsToMany(TestSeriesCategory::class);
    }
}
