<?php

namespace JorarMarfin\LaravelDspace\Models;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $table = 'resources';
    protected $guarded = [];
    public $timestamps = false;

    public function setHeaderAttribute($value)
    {
        $this->attributes['header'] = json_encode($value);
    }
    public function setMetadataAttribute($value)
    {
        $this->attributes['metadata'] = json_encode($value);
    }


}
