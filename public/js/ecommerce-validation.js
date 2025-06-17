// Create Categories Validations 
        document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('categoryForm');
        const name = document.getElementById('name');
        const image = document.getElementById('image');
        const nameError = document.getElementById('name-error');
        const imageError = document.getElementById('image-error');

        function showError(element, errorBox, message) {
            element.classList.add('border-red-500');
            errorBox.textContent = message;
            errorBox.classList.remove('hidden');
        }

        function clearError(element, errorBox) {
            element.classList.remove('border-red-500');
            errorBox.textContent = '';
            errorBox.classList.add('hidden');
        }

        function validateName() {
            const value = name.value.trim();
            clearError(name, nameError);

            if (!value) {
                showError(name, nameError, 'Category name is required.');
                return false;
            }
            if (value.length < 2) {
                showError(name, nameError, 'Name must be at least 2 characters.');
                return false;
            }
            if (value.length > 50) {
                showError(name, nameError, 'Name must not exceed 50 characters.');
                return false;
            }
            return true;
        }

        function validateImage() {
            const file = image.files[0];
            clearError(image, imageError);

            if (!file) {
                showError(image, imageError, 'Image is required.');
                return false;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                showError(image, imageError, 'Only JPG, PNG, WEBP, or GIF images are allowed.');
                return false;
            }

            const maxSize = 2 * 1024 * 1024; // 2MB
            if (file.size > maxSize) {
                showError(image, imageError, 'Image must be less than 2MB.');
                return false;
            }

            return true;
        }

        form.addEventListener('submit', (e) => {
            const validName = validateName();
            const validImage = validateImage();

            if (!validName || !validImage) {
                e.preventDefault();
            }
        });

        name.addEventListener('input', validateName);
        image.addEventListener('change', validateImage);
    });

// Edit Category Validations
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('categoryEditForm');
    const nameInput = document.getElementById('name');
    const imageInput = document.getElementById('image');
    const nameError = document.getElementById('name-error');
    const imageError = document.getElementById('image-error');
    const imagePreview = document.getElementById('image-preview');

    function showError(element, errorBox, message) {
        element.classList.add('border-red-500');
        errorBox.textContent = message;
        errorBox.classList.remove('hidden');
    }

    function clearError(element, errorBox) {
        element.classList.remove('border-red-500');
        errorBox.textContent = '';
        errorBox.classList.add('hidden');
    }

    function validateName() {
        const value = nameInput.value.trim();
        clearError(nameInput, nameError);

        if (!value) {
            showError(nameInput, nameError, 'Category name is required.');
            return false;
        }
        if (value.length < 2) {
            showError(nameInput, nameError, 'Name must be at least 2 characters.');
            return false;
        }
        if (value.length > 50) {
            showError(nameInput, nameError, 'Name must not exceed 50 characters.');
            return false;
        }
        return true;
    }

    function validateImage() {
        const file = imageInput.files[0];
        clearError(imageInput, imageError);

        if (!file) return true; // image not required on edit

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showError(imageInput, imageError, 'Only JPG, PNG, WEBP, or GIF images are allowed.');
            return false;
        }

        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            showError(imageInput, imageError, 'Image must be less than 2MB.');
            return false;
        }

        return true;
    }

    function previewImage() {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    form.addEventListener('submit', (e) => {
        const isNameValid = validateName();
        const isImageValid = validateImage();

        if (!isNameValid || !isImageValid) {
            e.preventDefault();
        }
    });

    nameInput.addEventListener('input', validateName);
    imageInput.addEventListener('change', () => {
        validateImage();
        previewImage();
    });
});


//Create Admin Product Validations
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('productForm');

    const name = document.getElementById('name');
    const description = document.getElementById('description');
    const category = document.getElementById('category_id');
    const price = document.getElementById('price');
    const image = document.getElementById('image');
    const preview = document.getElementById('imagePreview');

    function showError(input, message) {
        let error = input.nextElementSibling;
        if (!error || !error.classList.contains('text-red-600')) {
            error = document.createElement('div');
            error.className = 'text-red-600 text-sm mt-1';
            input.parentNode.appendChild(error);
        }
        error.textContent = message;
        input.classList.add('border-red-500');
    }

    function clearError(input) {
        let error = input.nextElementSibling;
        if (error && error.classList.contains('text-red-600')) {
            error.textContent = '';
        }
        input.classList.remove('border-red-500');
    }

    function validateName() {
        clearError(name);
        const value = name.value.trim();
        if (!value) {
            showError(name, 'Name is required.');
            return false;
        }
        if (value.length < 3) {
            showError(name, 'Name must be at least 3 characters.');
            return false;
        }
        return true;
    }

    function validateDescription() {
        clearError(description);
        const value = description.value.trim();
        if (!value) {
            showError(description, 'Description is required.');
            return false;
        }
        if (value.length < 10) {
            showError(description, 'Description must be at least 10 characters.');
            return false;
        }
        return true;
    }

    function validateCategory() {
        clearError(category);
        if (!category.value) {
            showError(category, 'Please select a category.');
            return false;
        }
        return true;
    }

    function validatePrice() {
        clearError(price);
        const value = price.value.trim();
        if (!value) {
            showError(price, 'Price is required.');
            return false;
        }
        if (!/^\d+(\.\d{1,2})?$/.test(value)) {
            showError(price, 'Price must be a valid number (up to 2 decimals).');
            return false;
        }
        if (parseFloat(value) < 1) {
            showError(price, 'Price must be at least 1.');
            return false;
        }
        return true;
    }

    function validateImage() {
        clearError(image);
        const file = image.files[0];
        if (!file) {
            showError(image, 'Image is required.');
            return false;
        }
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showError(image, 'Only JPG, PNG, WEBP, or GIF allowed.');
            return false;
        }
        if (file.size > 2 * 1024 * 1024) {
            showError(image, 'Image must be less than 2MB.');
            return false;
        }
        return true;
    }

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }

    // Real-time validation listeners
    name.addEventListener('input', validateName);
    description.addEventListener('input', validateDescription);
    category.addEventListener('change', validateCategory);
    price.addEventListener('input', validatePrice);
    image.addEventListener('change', (e) => {
        validateImage();
        previewImage(e);
    });

    form.addEventListener('submit', (e) => {
        const valid = [
            validateName(),
            validateDescription(),
            validateCategory(),
            validatePrice(),
            validateImage()
        ].every(Boolean);

        if (!valid) {
            e.preventDefault();
        }
    });
});

// Edit Blade file Validation
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('categoryEditForm');

    const name = document.getElementById('name');
    const nameError = document.getElementById('name-error');

    const image = document.getElementById('image');
    const imageError = document.getElementById('image-error');
    const imagePreview = document.getElementById('image-preview');

    function showError(element, errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        element.classList.add('border-red-500');
    }

    function clearError(element, errorElement) {
        errorElement.textContent = '';
        errorElement.classList.add('hidden');
        element.classList.remove('border-red-500');
    }

    function validateName() {
        clearError(name, nameError);
        const value = name.value.trim();
        if (!value) {
            showError(name, nameError, 'Category name is required.');
            return false;
        }
        if (value.length < 3) {
            showError(name, nameError, 'Category name must be at least 3 characters.');
            return false;
        }
        return true;
    }

    function validateImage() {
        clearError(image, imageError);
        const file = image.files[0];
        if (!file) return true; // Optional

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showError(image, imageError, 'Only JPG, PNG, WEBP, or GIF allowed.');
            return false;
        }

        if (file.size > 2 * 1024 * 1024) {
            showError(image, imageError, 'Image must be less than 2MB.');
            return false;
        }

        return true;
    }

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('hidden');
        }
    }

    // Real-time validation
    name.addEventListener('input', validateName);
    image.addEventListener('change', (e) => {
        validateImage();
        previewImage(e);
    });

    // On submit
    form.addEventListener('submit', (e) => {
        const valid = [validateName(), validateImage()].every(Boolean);
        if (!valid) {
            e.preventDefault();
        }
    });
});

//Admin Order show and status validation
document.addEventListener('DOMContentLoaded', () => {
    const statusForm = document.querySelector('form[action*="updateStatus"]');
    const shippingForm = document.querySelector('form[action*="shipping"]');

    const shippingFields = ['address', 'region', 'city', 'phone', 'country', 'zip'];

    const getInput = (form, name) => form.querySelector(`[name="${name}"]`);

    const createOrGetError = (input) => {
        let error = input.nextElementSibling;
        if (!error || !error.classList.contains('text-red-600')) {
            error = document.createElement('div');
            error.className = 'text-red-600 text-sm mt-1';
            input.parentNode.appendChild(error);
        }
        return error;
    };

    const showError = (input, message) => {
        const error = createOrGetError(input);
        error.textContent = message;
        input.classList.add('border-red-500');
    };

    const clearError = (input) => {
        const error = input.nextElementSibling;
        if (error && error.classList.contains('text-red-600')) {
            error.textContent = '';
        }
        input.classList.remove('border-red-500');
    };

    const validateField = (input) => {
        clearError(input);
        const val = input.value.trim();
        const name = input.name;

        if (!val) {
            showError(input, `${name.charAt(0).toUpperCase() + name.slice(1)} is required.`);
            return false;
        }

        // Minimum length for text-based fields
        if (['address', 'region', 'city', 'country'].includes(name) && val.length < 3) {
            showError(input, `${name.charAt(0).toUpperCase() + name.slice(1)} must be at least 3 characters.`);
            return false;
        }

        // Only digits allowed for phone
        if (name === 'phone') {
            if (!/^\d{10}$/.test(val)) {
                showError(input, 'Phone must contain only digits (10 numbers).');
                return false;
            }
        }

        // Only digits allowed for zip
        if (name === 'zip') {
            if (!/^\d{4,10}$/.test(val)) {
                showError(input, 'ZIP must be numeric and 4-10 digits long.');
                return false;
            }
        }

        // Alphanumeric and common punctuation for address fields
        if (['address', 'region', 'city', 'country'].includes(name)) {
            if (!/^[A-Za-z0-9\s,.-]+$/.test(val)) {
                showError(input, `${name.charAt(0).toUpperCase() + name.slice(1)} contains invalid characters.`);
                return false;
            }
        }

        return true;
    };

    const validateShippingForm = () => {
        let valid = true;
        for (let field of shippingFields) {
            const input = getInput(shippingForm, field);
            if (!validateField(input)) valid = false;
        }
        return valid;
    };

    const validateStatus = () => {
        const select = statusForm.querySelector('select[name="status"]');
        clearError(select);
        if (!select.value) {
            showError(select, 'Status is required.');
            return false;
        }
        return true;
    };

    // Real-time validation
    shippingFields.forEach(field => {
        const input = getInput(shippingForm, field);
        input.addEventListener('input', () => validateField(input));
    });

    shippingForm.addEventListener('submit', e => {
        if (!validateShippingForm()) {
            e.preventDefault();
        }
    });

    statusForm.addEventListener('submit', e => {
        if (!validateStatus()) {
            e.preventDefault();
        }
    });
});


