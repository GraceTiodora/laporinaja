import './bootstrap';

// ============================================
// SMOOTH SCROLL BEHAVIOR
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✨ Laporin Aja - Interactivity Loaded');
    
    // Initialize all interactive features
    initializeFormValidation();
    initializeButtonEffects();
    initializeCardAnimations();
    initializeVoteSystem();
    initializeNotifications();
    initializeLoadingStates();
});

// ============================================
// FORM VALIDATION WITH VISUAL FEEDBACK
// ============================================
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Add focus effects
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('input-focused');
                this.style.borderColor = '#3b82f6';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('input-focused');
                this.style.borderColor = 'transparent';
                
                // Validate on blur
                validateInput(this);
            });
            
            // Real-time validation
            input.addEventListener('input', function() {
                validateInput(this);
            });
        });
        
        // Form submission
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span style="display: inline-block; animation: spin 0.6s linear infinite;">⏳</span> Memproses...';
                
                // Re-enable after 3 seconds (adjust as needed)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitBtn.dataset.originalText || 'Submit';
                }, 3000);
            }
        });
    });
}

function validateInput(input) {
    const value = input.value.trim();
    const type = input.type;
    let isValid = true;
    
    if (type === 'email') {
        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    } else if (type === 'text' || input.tagName === 'TEXTAREA') {
        isValid = value.length >= 3;
    } else if (type === 'password') {
        isValid = value.length >= 6;
    }
    
    if (isValid && value.length > 0) {
        input.style.borderColor = '#10b981';
        input.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
    } else if (!isValid && value.length > 0) {
        input.style.borderColor = '#ef4444';
        input.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
    }
}

// ============================================
// BUTTON RIPPLE EFFECT
// ============================================
function initializeButtonEffects() {
    const buttons = document.querySelectorAll('button, .btn, a[role="button"]');
    
    buttons.forEach(button => {
        button.addEventListener('mousedown', function(e) {
            if (this.disabled) return;
            
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.style.position = 'absolute';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.width = '0';
            ripple.style.height = '0';
            ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.pointerEvents = 'none';
            ripple.style.animation = 'ripple 0.6s ease-out';
            
            if (!this.style.position || this.style.position === 'static') {
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
            }
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
        
        // Add hover scale effect
        button.addEventListener('mouseenter', function() {
            if (!this.disabled) {
                this.style.transform = 'scale(1.02)';
            }
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

// ============================================
// CARD ANIMATIONS ON SCROLL
// ============================================
function initializeCardAnimations() {
    const cards = document.querySelectorAll('.card, article, [class*="post"]');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideInUp 0.4s ease-out forwards';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    cards.forEach(card => observer.observe(card));
}

// ============================================
// VOTE/LIKE SYSTEM EFFECTS
// ============================================
function initializeVoteSystem() {
    const voteButtons = document.querySelectorAll('[class*="vote"], [class*="like"], [class*="upvote"], [class*="downvote"]');
    
    voteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.classList.contains('voted') || this.classList.contains('liked')) {
                this.classList.remove('voted', 'liked');
                this.style.color = '#6b7280';
            } else {
                // Remove from other buttons in same group
                this.parentElement?.querySelectorAll('[class*="vote"], [class*="like"]').forEach(btn => {
                    if (btn !== this) {
                        btn.classList.remove('voted', 'liked');
                        btn.style.color = '#6b7280';
                    }
                });
                
                this.classList.add('voted', 'liked');
                this.style.color = '#3b82f6';
                
                // Add animation
                this.style.animation = 'bounce-soft 0.3s ease';
                setTimeout(() => {
                    this.style.animation = '';
                }, 300);
            }
        });
    });
}

// ============================================
// NOTIFICATION TOAST
// ============================================
function initializeNotifications() {
    // Show any existing notifications with animation
    const alerts = document.querySelectorAll('.alert, .notification, .toast');
    
    alerts.forEach((alert, index) => {
        setTimeout(() => {
            alert.style.animation = 'slideInDown 0.4s ease-out';
        }, index * 100);
        
        // Auto-dismiss after 5 seconds
        const closeBtn = alert.querySelector('.close, [data-dismiss]');
        if (!closeBtn) {
            setTimeout(() => {
                alert.style.animation = 'slideInDown 0.4s ease-out reverse';
                setTimeout(() => alert.remove(), 400);
            }, 5000);
        }
    });
}

// ============================================
// LOADING STATES
// ============================================
function initializeLoadingStates() {
    // Store original button text
    const buttons = document.querySelectorAll('button[type="submit"]');
    buttons.forEach(btn => {
        btn.dataset.originalText = btn.innerHTML;
    });
}

// ============================================
// UTILITY FUNCTION: SHOW TOAST MESSAGE
// ============================================
window.showToast = function(message, type = 'info', duration = 3000) {
    const toast = document.createElement('div');
    toast.className = `notification alert alert-${type}`;
    toast.innerHTML = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 16px 20px;
        border-radius: 8px;
        animation: slideInDown 0.4s ease-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    `;
    
    if (type === 'success') {
        toast.style.backgroundColor = '#d1fae5';
        toast.style.color = '#065f46';
        toast.style.borderLeft = '4px solid #10b981';
    } else if (type === 'error') {
        toast.style.backgroundColor = '#fee2e2';
        toast.style.color = '#7f1d1d';
        toast.style.borderLeft = '4px solid #ef4444';
    } else if (type === 'warning') {
        toast.style.backgroundColor = '#fef3c7';
        toast.style.color = '#78350f';
        toast.style.borderLeft = '4px solid #f59e0b';
    } else {
        toast.style.backgroundColor = '#dbeafe';
        toast.style.color = '#1e3a8a';
        toast.style.borderLeft = '4px solid #3b82f6';
    }
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideInDown 0.4s ease-out reverse';
        setTimeout(() => toast.remove(), 400);
    }, duration);
};

// ============================================
// KEYBOARD SHORTCUTS
// ============================================
document.addEventListener('keydown', function(e) {
    // Cmd/Ctrl + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('[placeholder*="Cari"], [placeholder*="Search"]');
        if (searchInput) {
            searchInput.focus();
            searchInput.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.3)';
        }
    }
});

// ============================================
// LAZY LOAD IMAGES
// ============================================
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

console.log('✅ Laporin Aja - Semua fitur interaktif aktif!');