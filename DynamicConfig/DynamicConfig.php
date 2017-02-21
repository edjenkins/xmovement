<?php

namespace DynamicConfig;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;
use DynamicConfig\Config;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Finder\Finder;

use Log;

class DynamicConfig {

	public function updateConfig($key, $value, $type)
	{
		$config = Config::firstOrCreate(['key' => $key]);

		Log::error($value);
		Log::error($type);

		$config->value = $value;
		$config->type = $type;

		$config->save();

		return $this->fetchConfig($key);
	}

	public function fetchConfig($key, $default = null)
	{
		$config = Config::where(['key' => $key])->remember(60)->first();

		if (!$config)
		{
			return $default;
		}

		switch ($config->type) {
			case 'boolean':
				$config->value = (boolean)$config->value;
				break;

			case 'integer':
				$config->value = (int)$config->value;
				break;
		}

		return $config->value;
	}

}
