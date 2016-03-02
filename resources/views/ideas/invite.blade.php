@extends('layouts.app')

@section('content')
	
	<div class="page-header">
	    
        <h2 class="main-title">Invite some Friends</h2>

	</div>

	<div class="container">
	    
	    <div class="dialog">

			<h3>Congratulations</h3>
			<p>Get your idea rolling by inviting some friends! Enter their names and emails below and we will them send a message.</p>

			<div id="panel-container">

				<div class="col-sm-4">
					<div class="user-panel" data-index="1">
						<input type="text" class="name-field" placeholder="Name">
						<input type="text" class="email-field" placeholder="Email">
					</div>
				</div>

				<div class="col-sm-4">
					<div class="user-panel" data-index="2">
						<input type="text" class="name-field" placeholder="Name">
						<input type="text" class="email-field" placeholder="Email">
					</div>
				</div>

				<div class="col-sm-4">
					<div class="user-panel" data-index="3">
						<input type="text" class="name-field" placeholder="Name">
						<input type="text" class="email-field" placeholder="Email">
					</div>
				</div>
			
			</div>

		</div>
        
        <div class="button-container">
	        
	        <form action="{{ action('IdeaController@sendInvites', $idea) }}" method="POST">
	            {!! csrf_field() !!}

		    	<input name="id" type="hidden" value="{{ $idea->id }}">

		    	<input name="data" type="hidden" id="form-data">
	        	
	        	<button type="submit" class="btn btn-primary action-button" id="continue-button">Invite Friends</button>

	        </form>
            
            <a class="muted-link" href="{{ action('IdeaController@view', $idea) }}">Skip this step</a>
		
		</div>

	</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="{!! asset('js/ideas/invite.js') !!}"></script