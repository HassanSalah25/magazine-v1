<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header quote-modal-header p-3">
        <h5 class="modal-title mb-0" id="quoteModalLabel">{{ __('Request A Quote') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('front.sendquote') }}" id="quoteForm" enctype="multipart/form-data">
        @csrf
        
        <!-- Debug info -->
        @if($errors->any() && session('quoteKey'))
          <div class="alert alert-danger p-3">
            <strong>{{ __('Validation errors') }}</strong>
            <ul class="p-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        
        <div class="modal-body">
          <div class="contact-grid">
            <!-- Dynamic Quote Inputs -->
            <div class="mb-2 contact-grid-span-2" id="quoteDynamicInputs"></div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary quote-btn-cancel" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
          <button type="submit" class="btn btn-primary quote-btn-submit" id="submitQuoteBtn">
            <i class="fas fa-paper-plane me-2"></i>{{ __('Send Quote Request') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  /* Brand + UI palette (light) */
  :root { 
    --brand-green: #00a651; 
    --brand-green-dark: #008c46; 
    --mint: #9ED8CC; 
    --line: rgba(0,0,0,0.08); 
    --text: #111013; 
    --muted: #6b7280; 
    --bg: #ffffff; 
  }

  #quoteModal .modal-dialog { max-width: 800px; }
  #quoteModal .modal-content { 
    border: 1px solid var(--line); 
    background: var(--bg); 
    border-radius: 16px; 
    box-shadow: 0 20px 40px rgba(0,0,0,0.08); 
    overflow: hidden; 
  }
  #quoteModal .quote-modal-header { 
    background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-green-dark) 100%);
    border-bottom: none;
  }
  #quoteModal .quote-modal-header .modal-title { 
    letter-spacing: .2px; 
    color: #ffffff; 
    font-weight: 600;
  }
  #quoteModal .quote-modal-header .btn-close {
    filter: invert(1);
  }
  #quoteModal .modal-body { padding: 24px; }
  #quoteModal .modal-footer { 
    border-top: 1px solid var(--line); 
    background: var(--bg); 
    padding: 14px 24px; 
  }

  /* Grid layout */
  #quoteModal .contact-grid { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    column-gap: 24px; 
    row-gap: 6px; 
  }
  #quoteModal .contact-grid-span-2 { grid-column: span 2; }

  /* Form inputs */
  #quoteModal .contact-label { 
    display: block; 
    font-size: 13px; 
    color: var(--text); 
    margin-bottom: 8px; 
    opacity: .9; 
    font-weight: 500;
  }
  #quoteModal .contact-input { 
    width: 100%; 
    background: transparent; 
    border: none; 
    border-bottom: 1px solid var(--line); 
    color: var(--text); 
    padding: 10px 0 12px; 
    outline: none; 
    font-size: 14px;
  }
  #quoteModal .contact-input::placeholder { 
    color: var(--muted); 
    opacity: .95; 
  }
  #quoteModal .contact-input:focus { 
    border-bottom-color: var(--brand-green); 
    box-shadow: none; 
  }
  #quoteModal textarea.contact-input { 
    resize: vertical; 
    min-height: 84px; 
  }
  #quoteModal select.contact-input {
    background: transparent;
    border: none;
    border-bottom: 1px solid var(--line);
    padding: 10px 0 12px;
    color: var(--text);
    outline: none;
  }
  #quoteModal select.contact-input:focus {
    border-bottom-color: var(--brand-green);
    box-shadow: none;
  }

  /* Buttons */
  #quoteModal .btn-primary.quote-btn-submit { 
    background: var(--brand-green); 
    border-color: var(--brand-green); 
    color: #ffffff; 
    border-radius: 10px; 
    padding: 10px 18px; 
    font-weight: 700; 
    transition: all 0.3s ease;
  }
  #quoteModal .btn-primary.quote-btn-submit:hover { 
    background: var(--brand-green-dark);
    border-color: var(--brand-green-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 166, 81, 0.3);
  }
  #quoteModal .btn-outline-primary.quote-btn-cancel { 
    color: var(--brand-green); 
    border-color: var(--brand-green); 
    border-radius: 10px; 
    transition: all 0.3s ease;
  }
  #quoteModal .btn-outline-primary.quote-btn-cancel:hover { 
    color: #fff; 
    background: var(--brand-green); 
    border-color: var(--brand-green); 
  }

  /* Error states */
  #quoteModal .contact-input.is-invalid { 
    border-bottom-color: #dc3545; 
  }
  #quoteModal .form-control.is-invalid { 
    border-color: #dc3545; 
  }
  #quoteModal .form-check-input.is-invalid { 
    border-color: #dc3545; 
  }
  #quoteModal .invalid-feedback { 
    color: #dc3545; 
    font-size: 12px; 
    margin-top: 4px; 
  }
  #quoteModal .invalid-feedback.d-block { 
    display: block !important; 
  }

  /* File upload styling */
  #quoteModal #quoteFiles {
    border: 2px dashed var(--line);
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
    background: transparent;
  }
  #quoteModal #quoteFiles:hover {
    border-color: var(--brand-green);
    background-color: rgba(0, 166, 81, 0.05);
  }

  /* Responsive design */
  @media (max-width: 768px) {
    #quoteModal .contact-grid {
      grid-template-columns: 1fr;
    }
    #quoteModal .contact-grid-span-2 {
      grid-column: span 1;
    }
    #quoteModal .modal-dialog {
      margin: 10px;
    }
  }
</style>

@push('event-js')
<script>
  (function() {
    let quoteModal = null;
    
    // Initialize modal cleanup handlers
    document.addEventListener('DOMContentLoaded', function() {
      var modalEl = document.getElementById('quoteModal');
      if (modalEl) {
        quoteModal = new bootstrap.Modal(modalEl, {
          backdrop: true,
          keyboard: true,
          focus: true
        });
        
        // Add event listeners for proper cleanup
        modalEl.addEventListener('hidden.bs.modal', function() {
          console.log('Quote modal hidden - cleaning up');
          cleanupModal();
        });
        
        modalEl.addEventListener('hide.bs.modal', function() {
          console.log('Quote modal hiding');
          // Reset form state
          var form = document.getElementById('quoteForm');
          if (form) {
            form.reset();
            // Remove validation classes
            var inputs = form.querySelectorAll('.is-invalid');
            inputs.forEach(function(input) {
              input.classList.remove('is-invalid');
            });
          }
          
          // Reset submit button
          var submitBtn = document.getElementById('submitQuoteBtn');
          if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>{{ __("Send Quote Request") }}';
            submitBtn.disabled = false;
          }
        });
      }
    });
    
    // Function to clean up modal backdrop and body classes
    function cleanupModal() {
      // Remove any lingering backdrop
     
      
      // Remove modal-open class from body
      document.body.classList.remove('modal-open');
      
      // Reset body padding if it was modified
      document.body.style.paddingRight = '';
      
      // Remove any overflow hidden
      document.body.style.overflow = '';
    }
    
    // Show modal with errors if there are validation errors
    @if($errors->any() && session('quoteKey'))
      console.log('Validation errors detected, showing quote modal...');
      document.addEventListener('DOMContentLoaded', function() {
        // Load dynamic inputs into the modal
        var dyn = document.getElementById('quoteDynamicInputs');
        if (dyn) {
          dyn.innerHTML = '<div class="text-muted">Loading...</div>';
          fetch("{{ route('front.quote.inputs') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(res){ return res.text(); })
            .then(function(html){ 
              dyn.innerHTML = html;
              // Show the modal after loading inputs
              if (quoteModal) {
                quoteModal.show();
                console.log('Quote modal shown with errors');
              }
            })
            .catch(function(err){ 
              console.error('Error loading quote form:', err);
              dyn.innerHTML = '<div class="text-danger">Failed to load form.</div>'; 
            });
        }
      });
    @endif

    // Handle quote button click to load dynamic inputs
    document.addEventListener('click', function(e) {
      var trigger = e.target.closest('[data-bs-target="#quoteModal"]');
      if (!trigger) return;
      e.preventDefault();
      console.log('Quote button clicked');
      
      // Clean up any existing modal state first
      cleanupModal();
      
      // Load dynamic inputs into the modal
      var dyn = document.getElementById('quoteDynamicInputs');
      if (dyn) {
        dyn.innerHTML = '<div class="text-muted">Loading...</div>';
        fetch("{{ route('front.quote.inputs') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
          .then(function(res){ return res.text(); })
          .then(function(html){ 
            console.log('Quote form inputs loaded successfully');
            dyn.innerHTML = html; 
          })
          .catch(function(err){ 
            console.error('Error loading quote form inputs:', err);
            dyn.innerHTML = '<div class="text-danger">Failed to load form.</div>'; 
          });
      }
      
      // Show modal using the initialized instance
      if (quoteModal) {
        quoteModal.show();
        console.log('Quote modal shown');
      }
    });

    // Handle quote form submission
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('quoteForm');
      if (form) {
        form.addEventListener('submit', function(e) {
          console.log('Quote form submitted');
          
          // Show loading state
          var submitBtn = document.getElementById('submitQuoteBtn');
          if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Sending...") }}';
            submitBtn.disabled = true;
          }
        });
      }
    });

    // Enhanced form validation
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('quoteForm');
      if (form) {
        // Use event delegation for dynamically loaded inputs
        form.addEventListener('blur', function(e) {
          if (e.target.matches('input[required], textarea[required], select[required]')) {
            validateField(e.target);
          }
        }, true);
        
        form.addEventListener('input', function(e) {
          if (e.target.matches('input[required], textarea[required], select[required]') && e.target.classList.contains('is-invalid')) {
            validateField(e.target);
          }
        }, true);
        
        function validateField(field) {
          if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('is-invalid');
          } else if (field.type === 'email' && field.value) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
              field.classList.add('is-invalid');
            } else {
              field.classList.remove('is-invalid');
            }
          } else {
            field.classList.remove('is-invalid');
          }
        }
      }
    });
    
    // Global cleanup function for any modal issues
    window.cleanupAllModals = function() {
      cleanupModal();
      // Also clean up any other potential modal artifacts
      var modals = document.querySelectorAll('.modal');
      modals.forEach(function(modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
      });
    };
  })();
</script>
@endpush
