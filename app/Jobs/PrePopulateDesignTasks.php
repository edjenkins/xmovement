<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use Config;
use DynamicConfig;
use Log;

use App\Idea;
use App\DesignTask;

class PrePopulateDesignTasks extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $idea;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      Log::info('Populating design tasks for - ' . $this->idea->name);

      // Populate polls
      if (Config::get('design-tasks.polls'))
      {
        foreach (Config::get('design-tasks.polls') as $index => $poll)
        {
          $design_task = $this->idea->addDesignTask($poll['name'], $poll['description'], 'Poll');

          if (array_key_exists('options', $poll)) {

            // Populate options
            foreach ($poll['options'] as $option_index => $poll_option)
            {
              \XMovement\Poll\PollOption::create([
                'xmovement_poll_id' => $design_task->xmovement_task_id,
                'user_id' => 1,
                'value' => $poll_option
              ]);
            }
          }
        }
      }

      // Populate discussions
      if (Config::get('design-tasks.discussions'))
      {
        foreach (Config::get('design-tasks.discussions') as $index => $discussion)
        {
          $this->idea->addDesignTask($discussion['name'], $discussion['description'], 'Discussion');
        }
      }

      Log::info('Design tasks populated');
    }
}
