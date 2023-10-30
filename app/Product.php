<?php

namespace App;

use App\Utils\CanBeRated;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CanBeRated;

    // protected $guarded = [];
    protected $fillable = ['name'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Call built in Eloquent events
    protected static function booted()
    {
        static::creating(function (Product $product) {
            $faker = \Faker\Factory::create();
            $product->image_url = $faker->imageUrl();
            if (auth()->user()) {
                $product->createdBy()->associate(auth()->user());
            }
        });
    }
}
