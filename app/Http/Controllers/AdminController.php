<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Artisan;
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

		if (Gate::denies('view_management_tools', Auth::user()))
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

	public function manageAdmins()
	{
		# META
		MetaTag::set('title', Lang::get('meta.admin_title'));
		MetaTag::set('description', Lang::get('meta.admin_description'));
		# META

		if (Gate::denies('manage_admins', Auth::user()))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

			return redirect()->action('PageController@home');
		}
		else
		{
			return view('admin.management.admins');
		}
    }

	public function updateConfig(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('update_config', Auth::user()))
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

		if (Gate::denies('update_config', Auth::user()))
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

		if (Gate::denies('manage_admins', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));
		}
		else
		{
			$response->meta['success'] = true;

			$user = User::where(['id' => $request->user_id])->first();

			Log::error($request->key);

			$user[$request->key] = $request->value;

			$user->save();

			$response->data = $user;
		}

		return Response::json($response);
	}

	public function fetchPermissions(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('manage_admins', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));
		}
		else
		{
			$response->meta['success'] = true;

			$response->data = User::where(['id' => $request->user_id])->first();
		}

		return Response::json($response);
	}

	public function setPlatformState($phases)
	{
		// // Fixed
		$progression_type = DynamicConfig::fetchConfig('PROGRESSION_TYPE', 'fixed');

		switch ($progression_type) {
			case 'fixed':

				// Get current date
				$current_date = strtotime("now");

				// Get process start date
				$process_start_date = strtotime(DynamicConfig::fetchConfig('PROCESS_START_DATE'));

				foreach ($phases as $index => $phase)
				{
					Log::error($phase->name);

					// Calculate start and end dates for inspiration phase
					$phase = json_decode(DynamicConfig::fetchConfig(strtoupper($phase->name) . '_PHASE'));

					$phase_start_date = strtotime("+" . $phase->start . " days", $process_start_date);
					$phase_end_date = strtotime("+" . $phase->end . " days", $process_start_date);

					$mode_enabled = ($current_date > $phase_start_date) && ($current_date < $phase_end_date);

					DynamicConfig::updateConfig(strtoupper($phase->name) . '_MODE_ENABLED', $mode_enabled, 'boolean');
				}

				break;

			default:
				break;
		}

		// Update Idea states
		Artisan::call('update-idea-states');
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
				json_decode(DynamicConfig::fetchConfig('INSPIRATION_PHASE', json_encode([ 'name' => 'Inspiration', 'start' => 0, 'end' => 3, 'duration' => 3, 'enabled' => DynamicConfig::fetchConfig('INSPIRATION_PHASE_ENABLED', false) ]))),

				json_decode(DynamicConfig::fetchConfig('CREATION_PHASE', json_encode([ 'name' => 'Creation', 'start' => 0, 'end' => 3, 'duration' => 3, 'enabled' => DynamicConfig::fetchConfig('CREATION_PHASE_ENABLED', true) ]))),
				json_decode(DynamicConfig::fetchConfig('SUPPORT_PHASE', json_encode([ 'name' => 'Support', 'start' => 0, 'end' => 3, 'duration' => 3, 'enabled' => DynamicConfig::fetchConfig('SUPPORT_PHASE_ENABLED', true) ]))),

				json_decode(DynamicConfig::fetchConfig('DESIGN_PHASE', json_encode([ 'name' => 'Design', 'start' => 3, 'end' => 6, 'duration' => 3, 'enabled' => DynamicConfig::fetchConfig('DESIGN_PHASE_ENABLED', true) ]))),
				json_decode(DynamicConfig::fetchConfig('PLAN_PHASE', json_encode([ 'name' => 'Plan', 'start' => 6, 'end' => 9, 'duration' => 3, 'enabled' => DynamicConfig::fetchConfig('PLAN_PHASE_ENABLED', true) ]))),

				json_decode(DynamicConfig::fetchConfig('TENDER_PHASE', json_encode([ 'name' => 'Tender', 'start' => 9, 'end' => 12, 'duration' => 3, 'enabled' => DynamicConfig::fetchConfig('TENDER_PHASE_ENABLED', false) ]))),
			];
		}

		$end_date_offset = 0;

		foreach ($phases as $index => $phase)
		{
			$phase = (object)$phase;

			// Generic rules for all phases
			$phase->rules = [
				['type' => 'MIN_DURATION', 'value' => 2],
				['type' => 'MAX_DURATION', 'value' => 60],
			];

			switch ($phase->name) {

				case 'Inspiration':

					$phase->enabled = DynamicConfig::fetchConfig('INSPIRATION_PHASE_ENABLED', false);
					DynamicConfig::updateConfig('INSPIRATION_PHASE', json_encode($phase), 'json');

					if (DynamicConfig::fetchConfig('PROGRESSION_TYPE') == 'fluid') { $phase->enabled = false; }

					break;

				case 'Creation':

					array_push($phase->rules, ['type' => 'START_EQUAL', 'target_phase' => 'SUPPORT_PHASE']);
					array_push($phase->rules, ['type' => 'END_NOT_AFTER_END', 'target_phase' => 'SUPPORT_PHASE']);

					$phase->enabled = DynamicConfig::fetchConfig('CREATION_PHASE_ENABLED', true);
					DynamicConfig::updateConfig('CREATION_PHASE', json_encode($phase), 'json');

					if (DynamicConfig::fetchConfig('PROGRESSION_TYPE') == 'fluid') { $phase->enabled = false; }

					break;

				case 'Support':

					$phase->enabled = DynamicConfig::fetchConfig('SUPPORT_PHASE_ENABLED', true);
					DynamicConfig::updateConfig('SUPPORT_PHASE', json_encode($phase), 'json');

					break;

				case 'Design':

					array_push($phase->rules, ['type' => 'NOT_BEFORE_START', 'target_phase' => 'SUPPORT_PHASE']);

					$phase->enabled = true;
					DynamicConfig::updateConfig('DESIGN_PHASE', json_encode($phase), 'json');

					break;

				case 'Plan':

					array_push($phase->rules, ['type' => 'NOT_BEFORE_END', 'target_phase' => 'DESIGN_PHASE']);

					$phase->enabled = true;
					DynamicConfig::updateConfig('PLAN_PHASE', json_encode($phase), 'json');

					break;

				case 'Tender':

					array_push($phase->rules, ['type' => 'NOT_BEFORE_END', 'target_phase' => 'PLAN_PHASE']);
					array_push($phase->rules, ['type' => 'NOT_BEFORE_END', 'target_phase' => 'PLAN_PHASE']);

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

						case 'START_EQUAL':

							$target_phase = (object) json_decode(DynamicConfig::fetchConfig($rule->target_phase));

							if ($phase->start != $target_phase->start)
							{
								$phase->start = $target_phase->start;

								array_push($response->errors, $phase->name . ' phase start must be the same as ' . $target_phase->name . ' phase start - it has been reset');
							}

							break;

						case 'END_NOT_AFTER_END':

							$target_phase = (object) json_decode(DynamicConfig::fetchConfig($rule->target_phase));

							if ($phase->end > $target_phase->end)
							{
								$phase->end = $target_phase->end;
								$phase->duration = ($phase->end - $phase->start);

								array_push($response->errors, $phase->name . ' phase end must be before ' . $target_phase->name . ' phase end - it has been reset');
							}

							break;
					}
				}
			}

			$phases[$index] = $phase;


			if ($phase->enabled)
			{
				$end_date_offset = ($phase->end > $end_date_offset) ? $phase->end : $end_date_offset;
			}

		}

		$response->data['phases'] = $phases;

		// Fetch milestones

		if (DynamicConfig::fetchConfig('PROGRESSION_TYPE') == 'fixed')
		{
			$current_date = strtotime("now");
			$start_date = strtotime(DynamicConfig::fetchConfig('PROCESS_START_DATE'));
			$end_date = strtotime("+" . $end_date_offset . " days", $start_date);

			$current_date_diff = $current_date - $start_date;
			$current_date_offset = floor($current_date_diff / (60 * 60 * 24)) * 60;

			$end_date_diff = $end_date - $start_date;
			$end_date_offset = floor($end_date_diff / (60 * 60 * 24)) * 60;

			DynamicConfig::updateConfig('PROCESS_END_DATE', strtotime($end_date), 'timestamp');

			$response->data['milestones'] = [
				'now' => [
					'date' => $current_date,
					'classes' => 'current-date',
					'placeholder' => 'Now',
					'offset' => $current_date_offset,
				],
				'start' => [
					'date' => $start_date,
					'classes' => 'start-date',
					'placeholder' => 'Start',
					'offset' => 0
				],
				'end' => [
					'date' => $end_date,
					'classes' => 'end-date',
					'placeholder' => 'End',
					'offset' => $end_date_offset
				]
			];
		}
		else
		{
			$response->data['milestones'] = [];
		}

		// Update platform state
		$this->setPlatformState($phases);

		return Response::json($response);
	}

}
