<?php

namespace Church;

use Church\Address;
use Church\Event;
use Church\Worship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Church extends Model
{
    use SoftDeletes;

    public $fillable = ['name', 'ministry', 'phone1', 'phone2', 'phone3', 'cnpj', 'email', 'website', 'comments', 'online'];

    public $hidden = ['status'];

    /**
     * Addresses of churches.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Events of churches.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Days of worship.
     */
    public function worship()
    {
        return $this->hasMany(Worship::class);
    }
}
