<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header subscription-modal-header p-3">
        <h5 class="modal-title mb-0" id="subscriptionModalLabel">{{ __('Contact Us') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('front.subscription.request') }}" id="subscriptionModalForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="package_id" id="subscriptionModalPackageId" value="">
        
        <!-- Debug info -->
        @if($errors->any() && session('package_id'))
          <div class="alert alert-danger p-3">
            <strong>{{ __('Validation errors') }}</strong>
            <ul  class="p-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="modal-body">
          <div class="contact-grid">
            <div class="mb-2 contact-grid-span-2" id="subscriptionDynamicInputs"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary subscription-btn-cancel" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
          <button type="submit" class="btn btn-primary subscription-btn-submit">{{ __('Submit') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  /* Brand + UI palette (light) */
  :root { --brand-green: #00a651; --brand-green-dark: #008c46; --mint: #9ED8CC; --line: rgba(0,0,0,0.08); --text: #111013; --muted: #6b7280; --bg: #ffffff; }

  #subscriptionModal .modal-dialog { max-width: 720px; }
  #subscriptionModal .modal-content { border: 1px solid var(--line); background: var(--bg); border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.08); overflow: hidden; }
  #subscriptionModal .subscription-modal-header { background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-green-dark) 100%); border-bottom: 1px solid var(--line); }
  #subscriptionModal .subscription-modal-header .modal-title { letter-spacing: .2px; color: var(--text); }
  #subscriptionModal .modal-body { padding: 24px; }
  #subscriptionModal .modal-footer { border-top: 1px solid var(--line); background: var(--bg); padding: 14px 24px; }

  /* Grid like the image */
  #subscriptionModal .contact-grid { display: grid; grid-template-columns: 1fr 1fr; column-gap: 24px; row-gap: 6px; }
  #subscriptionModal .contact-grid-span-2 { grid-column: span 2; }

  /* Underline inputs */
  #subscriptionModal .contact-label { display: block; font-size: 13px; color: var(--text); margin-bottom: 8px; opacity: .9; }
  #subscriptionModal .contact-input { width: 100%; background: transparent; border: none; border-bottom: 1px solid var(--line); color: var(--text); padding: 10px 0 12px; outline: none; }
  #subscriptionModal .contact-input::placeholder { color: var(--muted); opacity: .95; }
  #subscriptionModal .contact-input:focus { border-bottom-color: var(--brand-green); box-shadow: none; }
  #subscriptionModal textarea.contact-input { resize: vertical; min-height: 84px; }

  /* Buttons */
  #subscriptionModal .btn-primary.subscription-btn-submit { background: var(--mint); border-color: var(--mint); color: #0b0c0d; border-radius: 10px; padding: 10px 18px; font-weight: 700; }
  #subscriptionModal .btn-primary.subscription-btn-submit:hover { filter: brightness(0.95); }
  #subscriptionModal .btn-outline-primary.subscription-btn-cancel { color: var(--brand-green); border-color: var(--brand-green); border-radius: 10px; }
  #subscriptionModal .btn-outline-primary.subscription-btn-cancel:hover { color: #fff; background: var(--brand-green); border-color: var(--brand-green); }

  /* Error states */
  #subscriptionModal .contact-input.is-invalid { border-bottom-color: #dc3545; }
  #subscriptionModal .form-control.is-invalid { border-color: #dc3545; }
  #subscriptionModal .form-check-input.is-invalid { border-color: #dc3545; }
  #subscriptionModal .invalid-feedback { color: #dc3545; font-size: 12px; margin-top: 4px; }
  #subscriptionModal .invalid-feedback.d-block { display: block !important; }
</style>

@push('event-js')
<script>
  (function() {
    // Show modal with errors if there are validation errors
    @if($errors->any() && session('package_id'))
      console.log('Validation errors detected, showing modal...');
      document.addEventListener('DOMContentLoaded', function() {
        var packageId = '{{ session('package_id') }}';
        console.log('Package ID:', packageId);
        var input = document.getElementById('subscriptionModalPackageId');
        if (input) input.value = packageId;
        
        // Load dynamic inputs into the modal
        var dyn = document.getElementById('subscriptionDynamicInputs');
        if (dyn) {
          dyn.innerHTML = '<div class="text-muted">Loading...</div>';
          fetch("{{ route('front.package.inputs') }}?package_id=" + encodeURIComponent(packageId), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(res){ return res.text(); })
            .then(function(html){ 
              dyn.innerHTML = html;
              // Show the modal after loading inputs
              var modalEl = document.getElementById('subscriptionModal');
              if (modalEl) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
                console.log('Modal shown with errors');
              }
            })
            .catch(function(err){ 
              console.error('Error loading form:', err);
              dyn.innerHTML = '<div class="text-danger">Failed to load form.</div>'; 
            });
        }
      });
    @endif

    // Handle click events for package purchase buttons
    document.addEventListener('click', function(e) {
      var trigger = e.target.closest('.js-purchase-package');
      if (!trigger) return;
      e.preventDefault();
      console.log('Package purchase button clicked');
      var packageId = trigger.getAttribute('data-package-id');
      if (!packageId) return;
      console.log('Package ID:', packageId);
      var input = document.getElementById('subscriptionModalPackageId');
      if (input) input.value = packageId;
      // Load dynamic inputs into the modal
      var dyn = document.getElementById('subscriptionDynamicInputs');
      if (dyn) {
        dyn.innerHTML = '<div class="text-muted">Loading...</div>';
        fetch("{{ route('front.package.inputs') }}?package_id=" + encodeURIComponent(packageId), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
          .then(function(res){ return res.text(); })
          .then(function(html){ 
            console.log('Form inputs loaded successfully');
            dyn.innerHTML = html; 
          })
          .catch(function(err){ 
            console.error('Error loading form inputs:', err);
            dyn.innerHTML = '<div class="text-danger">Failed to load form.</div>'; 
          });
      }
      var modalEl = document.getElementById('subscriptionModal');
      if (modalEl) {
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
        console.log('Modal shown');
      }
    });

    // Add form submission debugging
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('subscriptionModalForm');
      if (form) {
        form.addEventListener('submit', function(e) {
          console.log('Form submitted');
          console.log('Form data:', new FormData(form));
        });
      }
    });
  })();
</script>
@endpush



