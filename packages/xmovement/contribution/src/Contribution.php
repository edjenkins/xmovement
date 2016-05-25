<?php

namespace XMovement\Contribution;

use Illuminate\Database\Eloquent\Model;

use Auth;
use Response;
use View;

class Contribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'contribution_type', 'voting_type'
    ];

    protected $table = 'xmovement_contributions';

    public function renderTile($design_task)
    {
        return view('contribution::tile', ['contribution' => $this, 'design_task' => $design_task]);
    }

    public function renderSubmitForm()
    {
        return view('contribution::forms::add', ['contribution' => $this]);
    }

    public function contributionTypes()
    {
        return $this->hasManyThrough(ContributionAvailableType::class, ContributionType::class, 'xmovement_contribution_id', 'id');
    }

    public function contributionSubmissions()
    {
        return $this->hasMany(ContributionSubmission::class, 'xmovement_contribution_id');
    }

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

    public function addSubmission($submission_type, $value)
    {
        // Check user can vote
        // Not locked

        if (false)
        {
            // Prevent voting twice in one direction
            return false;
        }
        else
        {
            // Image submission

            switch ($submission_type) {
                case '1':
                    $value = json_encode(array('text' => $value["text"]));
                    break;

                case '2':
                    $value = json_encode(array('image' => $value["image"], 'description' => $value["description"]));
                    break;

                case '3':
                    if ($embedLink = $this->getVideoEmbedLink($value["video"])) {
                        $value = json_encode(array('video' => $this->getVideoEmbedLink($value["video"]), 'description' => $value["description"]));
                    } else {
                        // Not a valid video
                        return false;
                    }
                    break;

                case '4':
                    $value = json_encode(array('file' => $value["file"], 'description' => $value["description"]));
                    break;

            }

            $contributionSubmission = ContributionSubmission::create([
                'xmovement_contribution_id' => $this->id,
                'user_id' => Auth::user()->id,
                'xmovement_contribution_available_type_id' => $submission_type,
                'value' => $value
            ]);

            if ($contributionSubmission)
            {
                $response->meta['success'] = true;
                $response->data['element'] = View::make('xmovement.contribution.contribution-submission', ['contributionSubmission' => $contributionSubmission])->render();
            }
            
            return Response::json($response);
        }
    }

    public function getVideoEmbedLink($value)
    {
        // Check if youtube
        if (preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $value, $matches))
        {
            // Valid youtube ID
            return 'http://www.youtube.com/embed/' . $matches[0];
        }
        else
        {
            // Check if vimeo
            if (preg_match("/(?:https?:\/\/)?(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/", $value["video"], $matches)) {
                // Valid vimeo ID
                return 'https://player.vimeo.com/video/' . $matches[3];
            }
            else
            {
                // Not a valid video
                return false;
            }
        }
    }

}