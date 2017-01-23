<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Config;
use DynamicConfig;
use Gate;
use Log;
use Lang;
use MetaTag;
use Response;
use Session;

use App\User;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class AdminController extends Controller
{
    public function emailTest(Request $request)
    {
		$job = (new SendTestEmails())->onQueue('emails');//->delay(30)

		$this->dispatch($job);

		return 'Test emails sent!';
    }

	public function managePlatform()
	{
		# META
		MetaTag::set('title', Lang::get('meta.admin_title'));
		MetaTag::set('description', Lang::get('meta.admin_description'));
		# META

		if (Gate::denies('manage_platform', Auth::user()))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

			return redirect()->action('PageController@home');
		}
		else
		{
			return view('admin.management.index');
		}
    }

	public function updateConfig(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('platform_configuration', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));
		}
		else
		{
			$response->meta['success'] = true;

			$response->data = DynamicConfig::updateConfig($request->key, $request->value, $request->type);
		}

		return Response::json($response);
	}

	public function fetchConfig(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('platform_configuration', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));
		}
		else
		{
			$response->meta['success'] = true;

			$value = DynamicConfig::fetchConfig($request->key);

			$response->data = $value;
		}

		return Response::json($response);
	}

	public function updatePermissions(Request $request)
	{
		$response = new ResponseObject();

		// if (Gate::denies('platform_configuration', Auth::user()))
		// {
        //     array_push($response->errors, trans('flash_message.no_permission'));
		// }
		// else
		// {
			$response->meta['success'] = true;

			$user = User::where(['id' => $request->user_id])->first();

			Log::error($request->key);

			$user[$request->key] = $request->value;

			$user->save();

			$response->data = $user;
		// }

		return Response::json($response);
	}

	public function fetchPermissions(Request $request)
	{
		$response = new ResponseObject();

		// if (Gate::denies('platform_configuration', Auth::user()))
		// {
        //     array_push($response->errors, trans('flash_message.no_permission'));
		// }
		// else
		// {
			$response->meta['success'] = true;

			// $value = DynamicPermissions::fetchPermissions($request->key);

			$response->data = User::where(['id' => $request->user_id])->first();
		// }

		return Response::json($response);
	}

	public function updatePhases(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		if ($request->phases)
		{
			$phases = $request->phases;
		}
		else
		{
			$phases = [
				json_decode(DynamicConfig::fetchConfig('INSPIRATION_PHASE', json_encode([ 'name' => 'Inspiration', 'start' => 0, 'end' => 7, 'duration' => 7, 'enabled' => DynamicConfig::fetchConfig('INSPIRATION_PHASE_ENABLED', false) ]))),
				json_decode(DynamicConfig::fetchConfig('CREATION_PHASE', json_encode([ 'name' => 'Creation', 'start' => 7, 'end' => 10, 'duration' => 3, 'enabled' => DynamicConfig::fetchConfig('CREATION_PHASE_ENABLED', true) ]))),

				json_decode(DynamicConfig::fetchConfig('DESIGN_PHASE', json_encode([ 'name' => 'Design', 'start' => 7, 'end' => 10, 'duration' => 7, 'enabled' => true ]))),
				json_decode(DynamicConfig::fetchConfig('PLAN_PHASE', json_encode([ 'name' => 'Plan', 'start' => 10, 'end' => 14, 'duration' => 4, 'enabled' => true ]))),

				json_decode(DynamicConfig::fetchConfig('SHORTLIST_PHASE', json_encode([ 'name' => 'Shortlist', 'start' => 10, 'end' => 17, 'duration' => 7, 'enabled' => DynamicConfig::fetchConfig('SHORTLIST_ENABLED', false) ]))),
				json_decode(DynamicConfig::fetchConfig('TENDER_PHASE', json_encode([ 'name' => 'Tender', 'start' => 10, 'end' => 17, 'duration' => 7, 'enabled' => DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false) ]))),
			];
		}

		foreach ($phases as $index => $phase)
		{
			$phase = (object)$phase;

			$phase->rules = [
				['type' => 'MIN_DURATION', 'value' => 2],
				['type' => 'MAX_DURATION', 'value' => 60],
			];

			switch ($phase->name) {

				case 'Inspiration':

					$phase->enabled = DynamicConfig::fetchConfig('INSPIRATION_PHASE_ENABLED', false);
					DynamicConfig::updateConfig('INSPIRATION_PHASE', json_encode($phase), 'json');

					break;

				case 'Creation':

					$phase->enabled = DynamicConfig::fetchConfig('CREATION_PHASE_ENABLED', true);
					DynamicConfig::updateConfig('CREATION_PHASE', json_encode($phase), 'json');

					break;

				case 'Design':

					array_push($phase->rules, ['type' => 'NOT_BEFORE_START', 'target_phase' => 'CREATION_PHASE']);

					$phase->enabled = true;
					DynamicConfig::updateConfig('DESIGN_PHASE', json_encode($phase), 'json');

					break;

				case 'Plan':

					array_push($phase->rules, ['type' => 'NOT_BEFORE_END', 'target_phase' => 'DESIGN_PHASE']);

					$phase->enabled = true;
					DynamicConfig::updateConfig('PLAN_PHASE', json_encode($phase), 'json');

					break;

				case 'Shortlist':

					array_push($phase->rules, ['type' => 'NOT_BEFORE_END', 'target_phase' => 'PLAN_PHASE']);
										
					$phase->enabled = DynamicConfig::fetchConfig('SHORTLIST_ENABLED', false);
					DynamicConfig::updateConfig('SHORTLIST_PHASE', json_encode($phase), 'json');

					break;

				case 'Tender':

					array_push($phase->rules, ['type' => 'NOT_BEFORE_END', 'target_phase' => 'PLAN_PHASE']);
					array_push($phase->rules, ['type' => 'NOT_BEFORE_END', 'target_phase' => 'SHORTLIST_PHASE']);

					$phase->enabled = DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false);
					DynamicConfig::updateConfig('TENDER_PHASE', json_encode($phase), 'json');

					break;
			}

			// Loop through rules
			if (property_exists($phase, 'rules'))
			{
				foreach ($phase->rules as $rule)
				{
					$rule = (object)$rule;

					switch ($rule->type)
					{
						case 'MIN_DURATION':

							if ($phase->duration < $rule->value)
							{
								$phase->duration = $rule->value;

								array_push($response->errors, $phase->name . ' must last at least ' . $rule->value . ' days - it has been reset');
							}

							break;

						case 'MAX_DURATION':

							if ($phase->duration > $rule->value)
							{
								$phase->duration = $rule->value;

								array_push($response->errors, $phase->name . ' must last no longer than ' . $rule->value . ' days - it has been reset');
							}

							break;

						case 'NOT_BEFORE_START':

							$target_phase = (object) json_decode(DynamicConfig::fetchConfig($rule->target_phase));

							if ($target_phase->enabled)
							{
								if ($phase->start < $target_phase->start)
								{
									$phase->start = $target_phase->start;

									array_push($response->errors, $phase->name . ' phase cannot start before ' . $target_phase->name . ' phase has started - it has been reset');
								}
							}

							break;

						case 'NOT_BEFORE_END':

							$target_phase = (object) json_decode(DynamicConfig::fetchConfig($rule->target_phase));

							if ($target_phase->enabled)
							{
								if ($phase->start < $target_phase->end)
								{
									$phase->start = $target_phase->end;
									$phase->end = ($phase->start - $phase->duration);

									array_push($response->errors, $phase->name . ' phase cannot start before ' . $target_phase->name . ' phase has completed - it has been reset');
								}
							}

							break;
					}
				}
			}

			$phases[$index] = $phase;

		}

		$response->data = $phases;

		return Response::json($response);
	}

}
