<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    // @link https://github.com/cviebrock/eloquent-sluggable
    use Sluggable;
    //disable default timestamps on the model
    public $timestamps = false;

    protected $dates = ['created_at'];

    protected $fillable = ['title','text','photo','reporter_email'];

    public static function boot()
    {
        parent::boot();
        // Set the created at date
        static::creating( function ($model) {
            $model->setCreatedAt($model->freshTimestamp());
        });
    }

    public function reporter(){
        return $this->belongsTo('App\User','reporter_email','email');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
