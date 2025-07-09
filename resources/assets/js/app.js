import $ from 'jquery';
import 'bootstrap';

$(function (){
    $(document).on('click', '#logout-btn', function(e){
        e.preventDefault();
        $('#logout-form').submit();
    });
});


$(document).ready(function() {
    $('#image_count').on('input', function() {
        const imageCount = parseInt($(this).val());
        const additionalImageFieldsContainer = $('#additionalImageFields');

        additionalImageFieldsContainer.empty();

        for (let i = 1; i <= imageCount; i++) {
            const imageField = $(`
                <div>
                    <label for="image${i}" class="form-label">${i} dienos programa</label>
                    <input id="image${i}" type="file" class="form-control" name="images[]" accept="image/*" required>
                </div>
            `);
            additionalImageFieldsContainer.append(imageField);
        }
    });
});


$(document).ready(function() {
    $('#togglePassword').click(function() {
        const passwordInput = $("#password");
        const eyeIcon = $('#togglePassword');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye');

        } else {
            passwordInput.attr('type', 'password');
            eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
        }
    });
});

$(document).ready(function() {
    $('#togglePasswordConfirm').click(function() {

        const passwordConfirmInput = $("#password-confirm");
        const eyeConfirmIcon = $('#togglePasswordConfirm');

        if (passwordConfirmInput.attr('type') === 'password') {
            passwordConfirmInput.attr('type', 'text');
            eyeConfirmIcon.removeClass('bi-eye-slash').addClass('bi-eye');

        } else {
            passwordConfirmInput.attr('type', 'password');
            eyeConfirmIcon.removeClass('bi-eye').addClass('bi-eye-slash');
        }
    });
});

$(document).ready(function() {
    $('#new_password').on('input', function() {
        var password = $(this).val();
        var strength = checkPasswordStrength(password);
        updatePasswordStrengthIndicator(strength);
        checkPasswordMatch(); // Check match when new password changes
    });

    $('#new_password_confirmation').on('input', function() {
        checkPasswordMatch(); // Check match when confirmation changes
    });

    function checkPasswordMatch() {
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#new_password_confirmation').val();
        var matchElement = $('#matchText');
        
        // Only show feedback if confirmation field has content
        if (confirmPassword.length > 0) {
            matchElement.show();
            matchElement.removeClass('text-match text-no-match');
            
            if (newPassword === confirmPassword) {
                matchElement.text('Slaptažodžiai sutampa').addClass('text-match');
            } else {
                matchElement.text('Slaptažodžiai nesutampa').addClass('text-no-match');
            }
        } else {
            matchElement.hide();
        }
    }

    function checkPasswordStrength(password) {
        var score = 0;
        var feedback = '';

        if (password.length === 0) {
            return { score: 0, feedback: 'Įveskite slaptažodį' };
        }

        // Length check
        if (password.length >= 8) score += 1;
        if (password.length >= 12) score += 1;

        // Character variety checks
        if (/[a-z]/.test(password)) score += 1; // lowercase
        if (/[A-Z]/.test(password)) score += 1; // uppercase
        if (/[0-9]/.test(password)) score += 1; // numbers
        if (/[^A-Za-z0-9]/.test(password)) score += 1; // special characters

        // Determine strength
        if (score < 3) {
            feedback = 'Silpnas slaptažodis';
            return { score: 1, feedback: feedback, class: 'weak' };
        } else if (score < 5) {
            feedback = 'Vidutinis slaptažodis';
            return { score: 2, feedback: feedback, class: 'medium' };
        } else {
            feedback = 'Stiprus slaptažodis';
            return { score: 3, feedback: feedback, class: 'strong' };
        }
    }

    function updatePasswordStrengthIndicator(strength) {
        var fillElement = $('#strengthFill');
        var textElement = $('#strengthText');
        
        // Remove all previous classes
        fillElement.removeClass('strength-weak strength-medium strength-strong');
        textElement.removeClass('text-weak text-medium text-strong');
        
        // Update based on strength
        if (strength.score === 0) {
            fillElement.css('width', '0%');
            textElement.text(strength.feedback);
        } else if (strength.class === 'weak') {
            fillElement.css('width', '33%').addClass('strength-weak');
            textElement.text(strength.feedback).addClass('text-weak');
        } else if (strength.class === 'medium') {
            fillElement.css('width', '66%').addClass('strength-medium');
            textElement.text(strength.feedback).addClass('text-medium');
        } else if (strength.class === 'strong') {
            fillElement.css('width', '100%').addClass('strength-strong');
            textElement.text(strength.feedback).addClass('text-strong');
        }
    }
});
/*
$(document).ready(function() {

    $('.dropdown-menu').hide();

    $('#user-dropdown').click(function(e) {
        e.preventDefault();
        $('.dropdown-menu').toggle();

    });
    // Close the dropdown menu if clicked outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').hide();
        }
    });
});
*/

$(document).ready(function () {
    $('#user-dropdown').on('click', function () {
        $('#chevron-icon').toggleClass('rotated');
    });
});

$(document).ready(function () {
    $('#navbarDropdown1').on('click', function () {
        $('#chevron-icon2').toggleClass('rotated');
    });
});

$(document).ready(function () {
    $('#navbarDropdown2').on('click', function () {
        $('#chevron-icon3').toggleClass('rotated');
    });
});


$(document).ready(function() {
    $('#password').on('input', function() {
        let password = $('#password').val();
        let strengthItems = $('.strength-item');

        let requirements = [
            /[a-z]/, // Lowercase letter
            /[A-Z]/, // Uppercase letter
            /\d/,    // Digit
            /[^A-Za-z0-9]/ // Special character
        ];

        strengthItems.each(function(index) {
            let isFilled = requirements[index].test(password);
            $(this).toggleClass('valid', isFilled);
            $(this).find('.bi').toggleClass('bi-circle', !isFilled).toggleClass('bi-check-circle', isFilled);
        });
    });

    $('#password-confirm').on('input', function() {
        let password = $('#password').val();
        let confirmPassword = $('#password-confirm').val();

        let passwordFilled = password === confirmPassword && password !== '';
        let mismatchText = 'Slaptažodžiai nesutampa';
        let matchText = passwordFilled ? 'Slaptažodžiai sutampa' : mismatchText;
        $('#mismatch-text').text(matchText); // Update mismatch text

        $('.strength-item.match').toggleClass('valid', passwordFilled)
            .find('.bi').toggleClass('bi-circle', !passwordFilled).toggleClass('bi-check-circle', passwordFilled);
    });
});

$(document).ready(function(){
    $('#searchInput').on('input', function(){
        let filter = $(this).val().toUpperCase();
        let noResults = true;

        $('#searchResults tr').each(function(){
            let tdText = $(this).find('td:eq(0)').text().toUpperCase();
            if(tdText.indexOf(filter) > -1){
                $(this).show();
                noResults = false;
            } else {
                $(this).hide();
            }
        });

        if (noResults) {
            $('#noResultsMessage').css('display', 'block');
        } else {
            $('#noResultsMessage').css('display', 'none');
        }
    });
});

$(document).ready(function(){
    $('#searchInput').on('input', function(){
        let filter = $(this).val().toUpperCase();
        let noResults = true;

        $('.searchCamp').each(function(){
            let cardText = $(this).text().toUpperCase();
            if(cardText.indexOf(filter) > -1){
                $(this).show();
                noResults = false;
            } else {
                $(this).hide();
            }
        });

        // Show/hide no results message based on flag value
        if (noResults) {
            $('#noResultsMessage').css('display', 'block');
        } else {
            $('#noResultsMessage').css('display', 'none');
        }
    });
});




$(document).ready(function() {

    $('.preview-image').click(function() {
        $('.image-preview').show();
        $('.image-preview img').attr('src', $(this).attr('src'));
    });

    $('.close-preview').click(function() {
        $('.image-preview').hide();
    });

    $('.image-preview').click(function(e) {
        if ($(e.target).is('.image-preview')) {
            $(this).hide();
        }
    });
});



$(document).ready(function() {
    $('#camp_id').change(function() {
        let selectedCampId = $(this).val();

        if (selectedCampId) {
            $.ajax({
                url: '/admin/camps/' + selectedCampId +'/data',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#title').val(data.title);
                    $('#description').val(data.description);

                    $('#camp-info').show();
                    $('#camp-description').show();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#camp-info').hide();
            $('#camp-description').hide();
        }
    });
});

document.querySelectorAll('.expand-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const dataAttribute = this.getAttribute('data-attribute');
        const dataId = this.getAttribute('data-id');
        const expandedRow = document.querySelector(`.expanded-row[data-${dataAttribute}="${dataId}"]`);

        if (expandedRow) {
            if (expandedRow.style.display === 'none') {
                expandedRow.style.display = '';
                this.innerHTML = 'Paslėpti <i class="bi bi-chevron-up"></i>';
            } else {
                expandedRow.style.display = 'none';
                this.innerHTML = 'Plačiau <i class="bi bi-chevron-down"></i>';
            }
        }
    });
});

$(document).ready(function() {
    $('#status').change(function() {
        $('#statusForm').submit();
    });
});

$(document).ready(function() {
    // Function to set background color based on selected value
    function setSelectBackground() {
        let selectedValue = $('.feedbackStatus').val();
        if (selectedValue === 'confirmed') {
            $('.feedbackStatus').css('color', 'rgb(56,201,0)');
            $('.feedbackStatus').css('background-color', 'rgb(255,255,255)');
        } else if (selectedValue === 'unconfirmed') {
            $('.feedbackStatus').css('color', 'rgb(218,0,0)');
            $('.feedbackStatus').css('background-color', 'rgb(255,255,255)');
        }
    }

    // Set background color initially
    setSelectBackground();

    // Change background color when select value changes
    $('.feedbackStatus').change(function() {
        setSelectBackground();
    });
});

$(document).ready(function() {
    // Handle navigation selection
    $('#navUsersSecond .nav-link').click(function(event) {
        event.preventDefault();
        const sectionId = $(this).attr('data-section');

        // Hide all subsections except the one with the corresponding ID
        $('.camps-section, .membership-section, .profile-info-section').not('#' + sectionId).hide();

        // Show the selected subsection
        $('#' + sectionId).show();

        // Update active class
        $('#navUsersSecond .nav-link').removeClass('active');
        $(this).addClass('active');
    });

    // Hide all sections except the first one on page load
    $('.camps-section, .membership-section, .profile-info-section').hide();
    $('.camps-section').show(); // Show default section (adjust as needed)
    $('#navUsersSecond .nav-link').first().addClass('active');
});

$('.form-check #select-all-images-checkbox').on('change', function() {
    $('.delete-image-checkbox').prop('checked', $(this).prop('checked'));
});

document.addEventListener("DOMContentLoaded", function() {
    const loadingContainer = document.querySelector(".loading-container");
    loadingContainer.style.display = "flex";

    window.addEventListener("load", function() {
        loadingContainer.style.display = "none";
    });
});

$(document).ready(function() {
    $('#searchInput').on('input', function() {
        let query = $(this).val().toLowerCase().trim();
        $('.card').each(function() {
            let cardContent = $(this).text().toLowerCase();
            if (cardContent.includes(query)) {
                $(this).parent().show(); // Show the parent container
                $(this).show(); // Show the card
            } else {
                $(this).parent().hide(); // Hide the parent container
            }
        });

        // Show or hide the "No results" message based on the number of visible articles
        if ($('.card:visible').length === 0) {
            $('#noResultsMessage').css('display', 'block');
        } else {
            $('#noResultsMessage').css('display', 'none');
        }
    });
});


$(document).ready(function() {

    $('#status').change(function() {
        let status = $(this).val();
        if (status === '0') {
            $('.new-camps').show();
            $('.old-camps').hide();
        } else if (status === '1') {
            $('.new-camps').hide();
            $('.old-camps').show();
        }
    });
});

$(document).ready(function() {
    // Function to toggle fields based on status
    function toggleFieldsBasedOnStatus() {
        var statusValue = $('#status').val();
        
        // Fields to hide when status is 1 (Pasibaigusi)
        var fieldsToToggle = [
            '.accomodation',
            '.clothing', 
            '.audience',
            '.worth',
            '.foodChoice',
            '.form-right'
        ];
        
        if (statusValue == '1') {
            // Hide fields when status is "Pasibaigusi" (1)
            fieldsToToggle.forEach(function(field) {
                $(field).hide();
            });
            
            // Change form-left from col-md-6 to col-md-12
            $('.form-left').removeClass('col-md-6').addClass('col-md-12');
            $('.form-left').addClass('mb-3');
        } else {
            // Show fields when status is "Vyksianti" (0)
            fieldsToToggle.forEach(function(field) {
                $(field).show();
            });
            
            // Change form-left back from col-md-12 to col-md-6
            $('.form-left').removeClass('col-md-12').addClass('col-md-6');
        }
    }
    
    // Run on page load to set initial state
    toggleFieldsBasedOnStatus();
    
    // Run when status changes
    $('#status').on('change', function() {
        toggleFieldsBasedOnStatus();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const selectBox = document.getElementById('customSelect');
    const optionsContainer = selectBox.nextElementSibling;
    const options = document.querySelectorAll('.custom-option');
    const hiddenSelect = document.getElementById('categorySelect');

    selectBox.addEventListener('click', function(e) {
        e.stopPropagation(); // prevent document click from closing it immediately
        selectBox.classList.toggle('open');
        optionsContainer.style.display = optionsContainer.style.display === 'flex' ? 'none' : 'flex';
    });

    options.forEach(function(optionElement) {
        optionElement.addEventListener('click', function(e) {
            e.stopPropagation();
            const selectedText = this.innerText;
            const selectedValue = this.getAttribute('data-value');

            selectBox.querySelector('.selected').innerText = selectedText;
            selectBox.classList.remove('open');
            optionsContainer.style.display = 'none';

            // Update hidden select if it exists
            if (hiddenSelect) {
                hiddenSelect.value = selectedValue;
                hiddenSelect.dispatchEvent(new Event('change'));
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (!selectBox.contains(e.target)) {
            selectBox.classList.remove('open');
            optionsContainer.style.display = 'none';
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let track = document.getElementById("testimonials_inner");
    let wrapper = document.querySelector(".testimonials-wrapper");

    // Duplicate content for a smooth loop
    let clone = wrapper.cloneNode(true);
    track.appendChild(clone);
});

$(document).ready(function () {

    // Check if #stats-section exists
    const $statsSection = $('#stats-section');
    if ($statsSection.length === 0) {
        return; // Exit if the section doesn't exist
    }
    function animateCounters() {
        $('.counter').each(function () {
            const $this = $(this);
            const target = parseInt($this.attr('data-target'), 10);
            const duration = 2000; // Animation duration in milliseconds
            const increment = Math.ceil(target / (duration / 50)); // Increment per frame
            const hasSuffix = $this.is('#projects-count'); // Check if this counter needs a suffix
            const hasPlus = $this.is('#camps-count'); // Check if this counter needs a "+" sign

            let current = 0;
            const interval = setInterval(function () {
                current += increment;
                if (current >= target) {
                    current = target; // Ensure it doesn't exceed the target
                    clearInterval(interval);
                }
                $this.text(hasPlus ? current + '+' : hasSuffix ? current + 'm.' : current);

            }, 50); // Frame interval in milliseconds
        });
    }

    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
        );
    }

    $(window).on('scroll', function () {
        const $statsSection = $('#stats-section');
        if (isInViewport($statsSection[0])) {
            animateCounters();
            $(window).off('scroll'); // Ensure animation runs only once
        }
    });
});

