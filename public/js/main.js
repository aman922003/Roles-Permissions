// Article Form Validation for Edit and Create
document.addEventListener('DOMContentLoaded', function() {
    // Handle both create and edit forms
    const articleForm = document.getElementById('articleForm') || document.getElementById('articleEditForm');
    
    if (articleForm) {
        // Add error message containers if they don't exist
        addErrorContainers();
        
        articleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Hide all error messages
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            
            let isValid = true;
            const title = document.getElementById('title')?.value.trim();
            const text = document.getElementById('text')?.value.trim();
            const auther = document.getElementById('auther')?.value.trim();
            
            // Validate Title
            if (!title) {
                showError('titleError', 'Title is required');
                isValid = false;
            } else if (title.length < 5) {
                showError('titleError', 'Title must be at least 5 characters');
                isValid = false;
            }
            
            // Validate Content
            if (!text) {
                showError('textError', 'Content is required');
                isValid = false;
            } else if (text.length < 10) {
                showError('textError', 'Content must be at least 10 characters');
                isValid = false;
            }
            
            // Validate Auther
            if (!auther) {
                showError('autherError', 'Auther is required');
                isValid = false;
            } else if (auther.length < 5) {
                showError('autherError', 'Auther must be at least 5 characters');
                isValid = false;
            }
            
            if (isValid) {
                articleForm.submit();
            }
        });

        // Add input event listeners for real-time validation
        ['title', 'text', 'auther'].forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', function() {
                    validateField(this.id, this.value.trim());
                });
            }
        });
    }

    function addErrorContainers() {
        // Add error containers if they don't exist
        ['title', 'text', 'auther'].forEach(field => {
            const inputGroup = document.getElementById(field)?.parentElement;
            const errorExists = document.getElementById(`${field}Error`);
            
            if (inputGroup && !errorExists) {
                const errorElement = document.createElement('p');
                errorElement.id = `${field}Error`;
                errorElement.className = 'text-red-400 font-medium hidden';
                inputGroup.appendChild(errorElement);
            }
        });
    }

    function validateField(fieldId, value) {
        const errorId = `${fieldId}Error`;
        
        if (!value) {
            showError(errorId, `${fieldId === 'auther' ? 'Auther' : fieldId.charAt(0).toUpperCase() + fieldId.slice(1)} is required`);
        } else if (
            (fieldId === 'title' && value.length < 5) ||
            (fieldId === 'text' && value.length < 10) ||
            (fieldId === 'auther' && value.length < 5)
        ) {
            showError(errorId, getErrorMessage(fieldId));
        } else {
            hideError(errorId);
        }
    }

    function showError(errorId, message) {
        const errorElement = document.getElementById(errorId);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
    }

    function hideError(errorId) {
        const errorElement = document.getElementById(errorId);
        if (errorElement) {
            errorElement.classList.add('hidden');
            errorElement.textContent = '';
        }
    }

    function getErrorMessage(field) {
        const fieldName = field === 'auther' ? 'Auther' : field.charAt(0).toUpperCase() + field.slice(1);
        const minLength = field === 'title' ? 5 : field === 'text' ? 10 : 5;
        return `${fieldName} must be at least ${minLength} characters`;
    }
});

// Validation for User Form Edit and Create
document.addEventListener('DOMContentLoaded', function () {
    const userForm = document.querySelector('form[action*="users"]');

    if (!userForm) return;

    // Inject error containers below each input if not already added by Blade
    const fields = ['name', 'email', 'password', 'age', 'gender', 'roles'];
    fields.forEach(field => {
        const input = document.getElementById(field) || document.querySelector(`[name="${field}[]"]`)?.closest('div');
        if (input && !document.getElementById(`${field}Error`)) {
            const error = document.createElement('p');
            error.id = `${field}Error`;
            error.className = 'text-red-500 text-sm mt-1 hidden';
            input.parentElement.appendChild(error);
        }
    });

    // Submit validation
    userForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearAllErrors();

        let valid = true;

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const age = document.getElementById('age').value.trim();
        const gender = document.getElementById('gender').value;
        const roles = document.querySelectorAll('input[name="roles[]"]:checked');

        if (!name || name.length < 3) {
            showError('nameError', 'Name must be at least 3 characters.');
            valid = false;
        }

        if (!email) {
            showError('emailError', 'Email is required.');
            valid = false;
        } else if (!/^\S+@\S+\.\S+$/.test(email)) {
            showError('emailError', 'Invalid email format.');
            valid = false;
        }

        if (!password || password.length < 6) {
            showError('passwordError', 'Password must be at least 6 characters.');
            valid = false;
        }

        if (!age || isNaN(age) || Number(age) < 0) {
            showError('ageError', 'Enter a valid non-negative age.');
            valid = false;
        }

        if (!gender) {
            showError('genderError', 'Please select a gender.');
            valid = false;
        }

        if (!roles.length) {
            showError('rolesError', 'Select at least one role.');
            valid = false;
        }

        if (valid) {
            userForm.submit();
        }
    });

    // Real-time input validation
    ['name', 'email', 'password', 'age', 'gender'].forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.addEventListener('input', () => validateField(field));
            if (input.tagName === 'SELECT') {
                input.addEventListener('change', () => validateField(field));
            }
        }
    });

    document.querySelectorAll('input[name="roles[]"]').forEach(role => {
        role.addEventListener('change', () => validateField('roles'));
    });

    // Utility functions
    function showError(id, message) {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = message;
            el.classList.remove('hidden');
        }
    }

    function hideError(id) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.textContent = '';
        }
    }

    function clearAllErrors() {
        fields.forEach(field => hideError(`${field}Error`));
    }

    function validateField(field) {
        const value = document.getElementById(field)?.value.trim();
        const errorId = `${field}Error`;

        switch (field) {
            case 'name':
                if (!value || value.length < 3) {
                    showError(errorId, 'Name must be at least 3 characters.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'email':
                if (!value) {
                    showError(errorId, 'Email is required.');
                } else if (!/^\S+@\S+\.\S+$/.test(value)) {
                    showError(errorId, 'Invalid email format.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'password':
                if (!value || value.length < 6) {
                    showError(errorId, 'Password must be at least 6 characters.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'age':
                const ageNum = Number(value);
                if (!value || isNaN(ageNum) || ageNum < 0 || ageNum > 120) {
                    showError(errorId, 'Age must be between 0 and 120.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'gender':
                if (!value) {
                    showError(errorId, 'Please select a gender.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'roles':
                const rolesChecked = document.querySelectorAll('input[name="roles[]"]:checked');
                if (!rolesChecked.length) {
                    showError(errorId, 'Select at least one role.');
                } else {
                    hideError(errorId);
                }
                break;
        }
    }
});

// Register and Login Frontend Validations
document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.querySelector('form[action*="register"]');
    const loginForm = document.querySelector('form[action*="login"]');

    const fields = {
        register: ['name', 'email', 'password', 'password_confirmation', 'age', 'gender'],
        login: ['email', 'password']
    };

    const createErrorContainer = (field) => {
        const input = document.getElementById(field);
        if (input && !document.getElementById(`${field}Error`)) {
            const error = document.createElement('p');
            error.id = `${field}Error`;
            error.className = 'text-red-500 text-sm mt-1 hidden';
            input.insertAdjacentElement('afterend', error);
        }
    };

    const showError = (id, message) => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = message;
            el.classList.remove('hidden');
        }
    };

    const hideError = (id) => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.textContent = '';
        }
    };

    const clearAllErrors = (formType) => {
        fields[formType].forEach(field => hideError(`${field}Error`));
    };

    const validateField = (field) => {
        const value = document.getElementById(field)?.value.trim();
        const errorId = `${field}Error`;

        switch (field) {
            case 'name':
                if (!value) {
                    showError(errorId, 'Name is required.');
                }
                else if (!value || value.length < 3) {
                    showError(errorId, 'Name must be at least 3 characters.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'email':   
                if (!value) {
                    showError(errorId, 'Email is required.');
                } else if (!/^\S+@\S+\.\S+$/.test(value)) {
                    showError(errorId, 'Invalid email format.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'password':
                if (!value || value.length < 6) {
                    showError(errorId, 'Password must be at least 6 characters.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'password_confirmation':
                const password = document.getElementById('password')?.value.trim();
                if (value !== password) {
                    showError(errorId, 'Passwords do not match.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'age':
                if (!value || isNaN(value) || Number(value) < 0 || Number(value) > 100) {
                    showError(errorId, 'Enter a valid age between 0 and 100.');
                } else {
                    hideError(errorId);
                }
                break;
            case 'gender':
                if (!value) {
                    showError(errorId, 'Please select a gender.');
                } else {
                    hideError(errorId);
                }
                break;
        }
    };

    const attachRealTimeValidation = (formType) => {
        fields[formType].forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', () => validateField(field));
                if (input.tagName === 'SELECT') {
                    input.addEventListener('change', () => validateField(field));
                }
            }
        });
    };

    if (registerForm) {
        fields.register.forEach(createErrorContainer);
        attachRealTimeValidation('register');

        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            clearAllErrors('register');
            let valid = true;

            fields.register.forEach(field => {
                validateField(field);
                const errorEl = document.getElementById(`${field}Error`);
                if (errorEl && !errorEl.classList.contains('hidden')) {
                    valid = false;
                }
            });

            if (valid) registerForm.submit();
        });
    }

    if (loginForm) {
        fields.login.forEach(createErrorContainer);
        attachRealTimeValidation('login');

        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            clearAllErrors('login');
            let valid = true;

            fields.login.forEach(field => {
                validateField(field);
                const errorEl = document.getElementById(`${field}Error`);
                if (errorEl && !errorEl.classList.contains('hidden')) {
                    valid = false;
                }
            });

            if (valid) loginForm.submit();
        });
    }
});

// Roles Craete and Edit form Validation
document.addEventListener('DOMContentLoaded', function () {
    const roleForm = document.querySelector('form[action*="roles"]');

    if (!roleForm) return;

    const nameInput = document.getElementById('name');

    // Create error container
    if (nameInput && !document.getElementById('nameError')) {
        const error = document.createElement('p');
        error.id = 'nameError';
        error.className = 'text-red-500 text-sm mt-1 hidden';
        nameInput.insertAdjacentElement('afterend', error);
    }

    const showError = (id, message) => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = message;
            el.classList.remove('hidden');
        }
    };

    const hideError = (id) => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = '';
            el.classList.add('hidden');
        }
    };

    const validateName = () => {
        const value = nameInput?.value.trim();
        const errorId = 'nameError';

        if (!value) {
            showError(errorId, 'Name is required.');
            return false;
        }

        if (value.length < 3) {
            showError(errorId, 'Name must be at least 3 characters.');
            return false;
        }

        hideError(errorId);
        return true;
    };

    nameInput?.addEventListener('input', validateName);

    roleForm.addEventListener('submit', function (e) {
        const valid = validateName();

        if (!valid) {
            e.preventDefault();
        }
    });
});


// Roles Search Javascript
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('permissionSearch');
    const permissionItems = document.querySelectorAll('.permission-item');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();

        permissionItems.forEach(item => {
            const label = item.querySelector('label').innerText
                .toLowerCase();
            item.style.display = label.includes(query) ?
                'flex' : 'none';
        });
    });
});

// Form Permission Validation Create and Edit
document.addEventListener('DOMContentLoaded', function () {
    const permissionForm = document.querySelector('form[action*="permissions"]');

    if (!permissionForm) return;

    const nameInput = document.getElementById('name');

    // Create error message element
    if (nameInput && !document.getElementById('nameError')) {
        const error = document.createElement('p');
        error.id = 'nameError';
        error.className = 'text-red-500 text-sm mt-1 hidden';
        nameInput.insertAdjacentElement('afterend', error);
    }

    const showError = (id, message) => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = message;
            el.classList.remove('hidden');
        }
    };

    const hideError = (id) => {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = '';
            el.classList.add('hidden');
        }
    };

    const validateName = () => {
        const value = nameInput?.value.trim();
        const errorId = 'nameError';

        if (!value) {
            showError(errorId, 'Name is required.');
            return false;
        }

        if (value.length < 3) {
            showError(errorId, 'Name must be at least 3 characters.');
            return false;
        }

        hideError(errorId);
        return true;
    };

    nameInput?.addEventListener('input', validateName);

    permissionForm.addEventListener('submit', function (e) {
        const valid = validateName();

        if (!valid) {
            e.preventDefault();
        }
    });
});


// Profile Update New Password form validation
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('updatePasswordForm');

    if (!form) return;

    const fields = {
        currentPassword: document.getElementById('update_password_current_password'),
        newPassword: document.getElementById('update_password_password'),
        confirmPassword: document.getElementById('update_password_password_confirmation')
    };

    const showError = (fieldId, message) => {
        const errorSpan = document.getElementById(`${fieldId}_error`);
        if (errorSpan) {
            errorSpan.textContent = message;
        }
    };

    const clearError = (fieldId) => {
        const errorSpan = document.getElementById(`${fieldId}_error`);
        if (errorSpan) {
            errorSpan.textContent = '';
        }
    };

    const validateField = (field, fieldId) => {
        const value = field.value.trim();
        let valid = true;

        if (fieldId === 'update_password_current_password' && value === '') {
            showError(fieldId, 'Current password is required.');
            valid = false;
        } else if (fieldId === 'update_password_password') {
            if (value === '') {
                showError(fieldId, 'New password is required.');
                valid = false;
            } else if (value.length < 6) {
                showError(fieldId, 'Password must be at least 6 characters.');
                valid = false;
            } else {
                clearError(fieldId);
            }
        } else if (fieldId === 'update_password_password_confirmation') {
            if (value === '') {
                showError(fieldId, 'Confirm your new password.');
                valid = false;
            } else if (value !== fields.newPassword.value.trim()) {
                showError(fieldId, 'Passwords do not match.');
                valid = false;
            } else {
                clearError(fieldId);
            }
        } else {
            clearError(fieldId);
        }

        return valid;
    };

    Object.entries(fields).forEach(([key, field]) => {
        field.addEventListener('input', () => {
            validateField(field, field.id);
        });
    });

    form.addEventListener('submit', function (e) {
        let allValid = true;

        Object.entries(fields).forEach(([key, field]) => {
            if (!validateField(field, field.id)) {
                allValid = false;
            }
        });

        if (!allValid) {
            e.preventDefault();
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.querySelector('form[action*="profile.update"]');

    if (!profileForm) return;

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');

    const showError = (id, message) => {
        const errorSpan = document.getElementById(`${id}_error`);
        if (errorSpan) {
            errorSpan.textContent = message;
        }
    };

    const clearError = (id) => {
        const errorSpan = document.getElementById(`${id}_error`);
        if (errorSpan) {
            errorSpan.textContent = '';
        }
    };

    const validateName = () => {
        const value = nameInput.value.trim();
        if (value === '') {
            showError('name', 'Name is required.');
            return false;
        }
        clearError('name');
        return true;
    };

    const validateEmail = () => {
        const value = emailInput.value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (value === '') {
            showError('email', 'Email is required.');
            return false;
        } else if (!emailPattern.test(value)) {
            showError('email', 'Enter a valid email address.');
            return false;
        }
        clearError('email');
        return true;
    };

    nameInput.addEventListener('input', validateName);
    emailInput.addEventListener('input', validateEmail);

    profileForm.addEventListener('submit', function (e) {
        const isNameValid = validateName();
        const isEmailValid = validateEmail();

        if (!isNameValid || !isEmailValid) {
            e.preventDefault(); // block form submit if errors
        }
    });
});


// Product Image Upload while create Update product script
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Quantity increase and decrease and update its cartTotal according
document.addEventListener("DOMContentLoaded", function() {
    
    document.querySelectorAll(".increase").forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.dataset.id;
            const input = document.querySelector(`.quantity[data-id="${id}"]`);
            const price = document.querySelector(`.item-price[data-id="${id}"]`);
            const total = document.querySelector(`.item-total[data-id="${id}"]`);

            let qty = parseInt(input.value);
            if (!isNaN(qty)) {
                qty++;
                input.value = qty;
                total.textContent = `₹ ${(qty * parseFloat(price.value)).toFixed(2)}`;
                updateCartTotal();
            }
        });
    });

    document.querySelectorAll(".decrease").forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.dataset.id;
            const input = document.querySelector(`.quantity[data-id="${id}"]`);
            const price = document.querySelector(`.item-price[data-id="${id}"]`);
            const total = document.querySelector(`.item-total[data-id="${id}"]`);

            let qty = parseInt(input.value);
            if (!isNaN(qty) && qty > 1) {
                qty--;
                input.value = qty;
                total.textContent = `₹ ${(qty * parseFloat(price.value)).toFixed(2)}`;
                updateCartTotal();
            }
        });
    });

    function updateCartTotal() {
        let subtotal = 0;

        document.querySelectorAll(".quantity").forEach(input => {
            const id = input.dataset.id;
            const price = document.querySelector(`.item-price[data-id="${id}"]`);
            subtotal += parseInt(input.value) * parseFloat(price.value);
        });

        const shipping = document.getElementById("shipping").value;
        const shippingFee = shipping === "express" ? 100 : 50;
        document.getElementById("subtotal").textContent = `₹ ${subtotal.toFixed(2)}`;
        document.getElementById("cart-total").textContent = `₹ ${(subtotal + shippingFee).toFixed(2)}`;
    }

    const shippingSelect = document.getElementById("shipping");
    if (shippingSelect) {
        shippingSelect.addEventListener("change", updateCartTotal);
    }
});

//this for quick change while update image
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image-input');
    const preview = document.getElementById('image-preview');
    const removeBtn = document.getElementById('remove-image');

    // Show image preview
    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (removeBtn) removeBtn.style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove current preview (quick delete from preview only, not DB)
    if (removeBtn) {
        removeBtn.addEventListener('click', function () {
            preview.src = '';
            preview.style.display = 'none';
            imageInput.value = '';
            removeBtn.style.display = 'none';
        });
    }
});

//Category image Uploadation js
    const imageInput = document.getElementById('image');
    const previewContainer = document.createElement('div');
    previewContainer.classList.add('mt-2');

    imageInput.insertAdjacentElement('afterend', previewContainer);

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        previewContainer.innerHTML = ''; // Clear previous preview

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('mt-2', 'max-w-xs', 'rounded');
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

