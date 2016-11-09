@extends('layouts.app', ['bodyclasses' => 'transparent grey'])

@section('content')
    <div class="container-fluid hero-container" id="about-hero-container" style="background-image:url('{{ getenv('APP_ABOUT_HEADER_IMG') }}')">
        <div class="black-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-container">
                        <h1>Competition</h1>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<div class="container">

		<div class="row floating-page-row">

			<div class="col-md-12">
				<div class="floating-page-tile">
					<h3>
						Competition Details
					</h3>

					<p>
						Newcastle University Library, in conjunction with Open Lab, are looking for the best workshops and educational events proposed and designed by students.
					</p>
					<p>
						<strong>What is the prize?</strong>
					</p>
					<p>
						A panel of three judges will award prizes of £250, £150 and £100 to the students who proposed, promoted and participated in best three events.
					</p>
					<p>
						<strong>What are the judges looking for?</strong>
					</p>
					<p>
						The judges will be looking for the most interesting, well-attended and well-promoted events. They will be looking for interesting uses of library resources and rooms, creative educational ideas and good use of the EventMovement website. In making their decision, the judges will also be looking at any documentation of the event, which includes photographs and a short description of the event.
					</p>
					<p>
						<strong>What is an education event?</strong>
					</p>
					<p>
						An educational event can be anything from a small workshop or study group, up to larger scale lectures and courses. Take a look at some of the event ideas already on EventMovement to get some inspiration
					</p>
					<p>
						<strong>How do I enter?</strong>
					</p>
					<p>
						To be in with a chance of winning, you must be a student registered at Newcastle University and use EventMovement to propose, promote and design an educational event at Newcastle University Library before December 18th 2016.
					</p>
					<p>
						If your event idea is well supported, the Library will help make it a reality. Then you need to attend the event, take some photos and send these to competition@eventmovement.co.uk along with your name, student number and a with a short description (250 words max) of how you felt the event went, and how you used EventMovement to make it happen.
					</p>
					<p>
						<strong>When will I know if I’ve won?</strong>
					</p>
					<p>
						The judges will contact all entrants in January 2017 informing them of the decision.
					</p>
					<p>
						<strong>What if I have questions?</strong>
					</p>
					<p>
						Send any questions you have to competition@eventmovement.co.uk or see below for full Terms and Conditions
					</p>

					<hr />

					<h3>
						Terms & Conditions
					</h3>

					<ol>
						<li>Competition details form part of these terms and conditions</li>
						<li>Entry is open to students registered at Newcastle University only.</li>
						<li>The entrant(s) must be aged 18 or over.</li>
						<li>Proof of identity and student registration may be required.</li>
						<li>All entries must be made directly by the person entering the competition.</li>
						<li>Only one entry per event will be allowed.</li>
						<li>No responsibility can be accepted for entries lost, delayed or corrupted, or due to computer error in transit.</li>
						<li>An entry consists of an email to competition@eventmovement.co.uk including your name, student number and a short description (250 words max) of how you felt the event went, and how you used EventMovement to make it happen. The entry should also include 1-3 photographs of the event, either attached to the email or linked to in the body of the email.</li>
						<li>Prizes are as follows: 1st place £250, 2nd place £150, 3rd place £100.</li>
						<li>The prizes are as stated, are not transferable to another individual and no other alternatives will be offered.</li>
						<li>The promoters reserve the right to amend or alter the terms of competitions and reject entries from entrants not entering into the spirit of the competition.</li>
						<li>The winner(s) agree(s) to the use of their name, photograph and competition entry documentation by Open Lab and Newcastle University Library, and will co-operate with any other reasonable requests by Open Lab or Newcastle University Library relating to any post-winning publicity.</li>
						<li>Reasonable efforts will be made to contact the winner(s). If the winner(s) cannot be contacted, or are unable to comply with these terms and conditions, the Promoter reserves the right to offer the prize to the runner(s)-up selected by the judges.</li>
						<li>Confirmation of the prize will also be made to the winner(s).</li>
						<li>Failure to respond, or failure to meet the eligibility requirements may result in forfeiture of the prize.</li>
						<li>The decision of the judges is final based on the criteria set out in the promotion and no correspondence will be entered into over this decision. Competitions may be modified or withdrawn at any time.</li>
						<li>The prize is provided by Open Lab</li>
						<li>The Promoter is Open Lab (Newcastle University), 89 Sandyford Rd, Newcastle-upon-Tyne, NE1 8HW.</li>
					</ol>

				</div>
			</div>

		</div>

	</div>
@endsection
