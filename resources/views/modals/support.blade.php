<!-- Modal -->
<div class="modal fade" id="support-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="support-modal">Confirm Support</h4>
      </div>
      <div class="modal-body">
        <p class="text-muted">
        	Please confirm your support by completing the CAPTCHA below.
        </p>
        <ul class="error-list" id="support-errors"></ul>
		<hr />
		<div class="g-recaptcha" data-sitekey="{{ getenv('CAPTCHA_SITE_KEY') }}"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirm-support-button" data-action-type="support" data-idea-id="{{ $idea->id }}" data-user-id="{{ Auth::user()->id }}">Confirm Support</button>
      </div>
    </div>
  </div>
</div>

<script src="/js/ideas/support.js"></script>