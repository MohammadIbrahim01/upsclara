<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    public $table = 'course_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'sequence',
        'course_category_id',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function course_category()
    {
        return $this->belongsTo(self::class, 'course_category_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'course_category_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    // App\Models\CourseCategory.php

public static function datatableQuery()
{
    return \DB::table('course_categories as cc1')
        ->leftJoin('course_categories as cc2', 'cc1.course_category_id', '=', 'cc2.id')
        ->select([
            'cc1.id',
            'cc1.name',
            'cc1.slug',
            'cc1.sequence',
            'cc1.active',
            'cc2.name as course_category_name'
        ]);
}

}
