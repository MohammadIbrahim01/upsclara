<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSeriesCategory extends Model
{
    use HasFactory;

    public $table = 'test_series_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'slug',
        'test_series_category_id',
        'sequence',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function testSeriesCategoryTestSeriess()
    {
        return $this->belongsToMany(TestSeries::class);
    }

    public function test_series_category()
    {
        return $this->belongsTo(self::class, 'test_series_category_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'test_series_category_id');
    }

    public function test_series()
    {
        return $this->belongsToMany(TestSeries::class);
    }

    public static function datatableQuery()
{
    return DB::table('test_series_categories as tsc1')
        ->leftJoin('test_series_categories as tsc2', 'tsc1.test_series_category_id', '=', 'tsc2.id')
        ->select([
            'tsc1.id',
            'tsc1.name',
            'tsc1.slug',
            'tsc1.sequence',
            'tsc1.active',
            'tsc2.name as test_series_category_name'
        ]);
}

}
