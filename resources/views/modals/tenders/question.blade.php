<div class="modal modal wide-modal fade" id="tender-question-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title"><% selected_tender_question.question.question %></h4>

			</div>

			<div class="modal-body">

				<p>
					<% selected_tender_question.answer %>
				</p>

			</div>

			<div class="comments-section">

				@include('discussion', ['target_type' => 'TenderQuestionAnswer'])

			</div>

		</div>

	</div>

</div>
