<?php

namespace Church;

use Church\Church;
use Illuminate\Database\Eloquent\Model;
use Library\GMaps;

class Address extends Model
{
    public $primaryKey = 'id';
    public $fillable = ['title', 'zipcode', 'street', 'number', 'district', 'city', 'state', 'country', 'phone1', 'phone2', 'phone3', 'email', 'website', 'latitude', 'longitude', 'comments', 'status'];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function getLatitudeAttribute($value)
    {
        if (!is_null($value)) {
            return $value;
        }
        $add = $this->street.', '.$this->number.' - '.$this->district.', '.$this->city.' - '.$this->state;
        if (isset($this->zipcode)) {
            $zipcode = $this->zipcode;
            $zipcode = preg_replace('/\D/', '', $zipcode);
            $add .= ', '.substr($zipcode, 0, 5).'-'.substr($zipcode, 5, 3);
        }
        $add .= ', '.$this->country;
        $maps = new GMaps();
        $location = $maps->location($add);

        if (isset($location->lat) && isset($location->lng)) {
            $this->latitude = $location->lat;
            $this->longitude = $location->lng;
            $this->save();
        }
    }

    public function getTitleAttribute($value)
    {
        if (!isset($this->attributes['title']) || empty($this->attributes['title'])) {
            return ucfirst(strtolower($this->church->name));
        }

        return ucfirst(strtolower($this->title ?? $value));
    }
}
