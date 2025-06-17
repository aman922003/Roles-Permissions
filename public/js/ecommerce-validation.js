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