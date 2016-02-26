<?php
// Params
$supported = true;
?>

<div class="action-button">
	<div class="btn btn-primary">Help Design</div>
	<div class="btn btn-primary">Support this Idea</div>
	<?php if ($idea->user->id == Auth::id()) { ?>
		<a href="{{ action('IdeaController@edit', $idea) }}" class="btn btn-warning">Edit Idea</a>
	<?php } ?>
</div>