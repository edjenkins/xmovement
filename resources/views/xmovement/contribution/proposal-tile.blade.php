<div class="contribution-submission-value">

	<?php $value = json_decode($contributionSubmission['value']); ?>

	<?php if ($contributionSubmission->contributionAvailableType->id == '1') { ?>

		{{ $value->text }}

	<?php } ?>

	<?php if ($contributionSubmission->contributionAvailableType->id == '2') { ?>

		<div class="item-description">
			{{ $value->description }}
		</div>

		<img src="{{ ResourceImage::getImage($value->image, 'medium') }}" height="100" style="margin: 15px 0" />

	<?php } ?>

	<?php if ($contributionSubmission->contributionAvailableType->id == '3') { ?>

		<div class="item-description">
			{{ $value->description }}
		</div>

		<div class="video-wrapper">
			<div class="video-container">
				<iframe src="{{ $value->video }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen width="560" height="315"></iframe>
			</div>
		</div>

	<?php } ?>

	<?php if ($contributionSubmission->contributionAvailableType->id == '4') { ?>

		<div class="item-description">
			{{ $value->description }}
		</div>

		<div class="file-container">
			<div class="file-icon">
				<?php
				$extension = pathinfo($value->file, PATHINFO_EXTENSION);
				switch ($extension) {
					case 'pdf':
						$class = 'fa-file-pdf-o';
						break;
					case 'doc':
						$class = 'fa-file-word-o';
						break;
					case 'docx':
						$class = 'fa-file-word-o';
						break;
					case 'txt':
						$class = 'fa-file-text-o';
						break;
					case 'rtf':
						$class = 'fa-file-text-o';
						break;
					case 'zip':
						$class = 'fa-file-archive-o';
						break;

					default:
						$class = 'fa-file-o';
						break;
				}
				?>
				<i class="fa {{ $class }}" aria-hidden="true"></i>
			</div>
			<div class="file-name">
				<a target="_blank" href="{{ ResourceImage::getFile($value->file) }}">{{ $value->file }}</a>
			</div>
		</div>

	<?php } ?>

</div>
