<?php

namespace App\Models;

/* Extent Eloquent */
use Illuminate\Database\Eloquent\Model;

class Post extends Model{

    /* migrationfilerne bruges her */
    protected $fillable = ['title', 'content'];

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo('App\Models\user');
    }

    public function setTitleAttribute($value) {
        $this->attributes['title'] = strtolower($value);
    }

    public function getTitleAttribute($value) {
        return strtoupper($value);
    }

}