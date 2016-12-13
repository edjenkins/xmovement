<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DynamicConfig;
use Log;

class DesignModule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'icon', 'class', 'available'
    ];

    /**
     * Check if the module is available
     *
     * @var array
     */
    public function isAvailable()
    {
		$key = strtoupper($this->name);
		$key = str_replace('.', '_', $key);

		Log::error(DynamicConfig::fetchConfig($key, false));

        return DynamicConfig::fetchConfig($key, false);
    }
}
