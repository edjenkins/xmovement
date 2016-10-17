<div class="modal fade" id="tender-question-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title"><% selected_answer.question.question %></h4>

			</div>

			<div class="modal-body">

				<p>
					<% selected_answer.answer %>
				</p>

			</div>

			<div class="comments-section">

				@include('discussion')

			</div>

		</div>

	</div>

</div>
