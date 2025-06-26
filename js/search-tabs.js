jQuery(document).ready(function($) {
    // Initialize address autocomplete
    let addressInput = document.getElementById('location');
    let suggestionsContainer = document.getElementById('address-suggestions');
    let debounceTimer;
    const API_KEY = '7ca788ba53774169b2b29fcb7d87dc55';

    // New elements for street address and zip code
    let streetAddressInput = document.getElementById('street_address');
    let zipCodeInput = document.getElementById('zip_code');
    let addressDetailsRow = document.querySelector('.address-details-row');
    let zipCodeSuggestionsContainer = document.getElementById('zip-code-suggestions');

    // Function to search addresses using Geoapify API
    function searchAddress(query) {
        console.log('Searching address for query:', query);
        if (!query || query.length < 3) {
            suggestionsContainer.classList.remove('active');
            addressDetailsRow.style.display = 'none'; // Hide if query is too short
            console.log('Query too short or empty. Hiding suggestions.');
            return;
        }

        suggestionsContainer.classList.add('loading');
        suggestionsContainer.classList.add('active');

        // Make API call to Geoapify
        fetch(`https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(query)}&apiKey=${API_KEY}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Geoapify API response:', data);
                if (data.features && data.features.length > 0) {
                    const suggestions = data.features.map(feature => ({
                        mainText: feature.properties.address_line1 || feature.properties.formatted,
                        secondaryText: feature.properties.address_line2 || '',
                        fullAddress: feature.properties.formatted,
                        street: feature.properties.street || '',
                        housenumber: feature.properties.housenumber || '',
                        postcode: feature.properties.postcode || ''
                    }));
                    displaySuggestions(suggestions);
                    console.log('Displaying suggestions:', suggestions);
                } else {
                    suggestionsContainer.classList.remove('active');
                    addressDetailsRow.style.display = 'none'; // Hide if no suggestions
                    console.log('No suggestions found. Hiding suggestions.');
                }
            })
            .catch(error => {
                console.error('Error fetching address suggestions:', error);
                suggestionsContainer.classList.remove('active');
                addressDetailsRow.style.display = 'none'; // Hide on error
            });
    }

    // Function to search zip codes using Geoapify API
    function searchZipCode(query) {
        console.log('Searching zip code for query:', query);
        if (!query || query.length < 2) { // Zip codes are usually 5 digits, so start with 2 for suggestions
            zipCodeSuggestionsContainer.classList.remove('active');
            console.log('Zip code query too short or empty. Hiding suggestions.');
            return;
        }

        zipCodeSuggestionsContainer.classList.add('loading');
        zipCodeSuggestionsContainer.classList.add('active');

        fetch(`https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(query)}&type=postcode&apiKey=${API_KEY}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Geoapify Zip Code API response:', data);
                if (data.features && data.features.length > 0) {
                    const suggestions = data.features.map(feature => ({
                        postcode: feature.properties.postcode,
                        formatted: feature.properties.formatted
                    }));
                    displayZipCodeSuggestions(suggestions);
                    console.log('Displaying zip code suggestions:', suggestions);
                } else {
                    zipCodeSuggestionsContainer.classList.remove('active');
                    console.log('No zip code suggestions found. Hiding suggestions.');
                }
            })
            .catch(error => {
                console.error('Error fetching zip code suggestions:', error);
                zipCodeSuggestionsContainer.classList.remove('active');
            });
    }

    // Display address suggestions in the dropdown
    function displaySuggestions(suggestions) {
        suggestionsContainer.innerHTML = '';
        suggestionsContainer.classList.remove('loading');

        if (suggestions.length === 0) {
            suggestionsContainer.classList.remove('active');
            addressDetailsRow.style.display = 'none'; // Hide if no suggestions
            return;
        }

        suggestions.forEach(suggestion => {
            const div = document.createElement('div');
            div.className = 'address-suggestion-item';
            div.innerHTML = `
                <div class="main-text">${suggestion.mainText}</div>
                <div class="secondary-text">${suggestion.secondaryText}</div>
            `;
            div.addEventListener('click', () => {
                addressInput.value = suggestion.fullAddress;
                streetAddressInput.value = (suggestion.housenumber ? suggestion.housenumber + ' ' : '') + suggestion.street;
                zipCodeInput.value = suggestion.postcode;
                suggestionsContainer.classList.remove('active');
                addressDetailsRow.style.display = 'flex'; // Show new fields
            });
            suggestionsContainer.appendChild(div);
        });
        suggestionsContainer.classList.add('active');
    }

    // Display zip code suggestions in the dropdown
    function displayZipCodeSuggestions(suggestions) {
        zipCodeSuggestionsContainer.innerHTML = '';
        zipCodeSuggestionsContainer.classList.remove('loading');

        if (suggestions.length === 0) {
            zipCodeSuggestionsContainer.classList.remove('active');
            return;
        }

        suggestions.forEach(suggestion => {
            const div = document.createElement('div');
            div.className = 'address-suggestion-item'; // Reuse existing styling
            div.innerHTML = `
                <div class="main-text">${suggestion.postcode}</div>
                <div class="secondary-text">${suggestion.formatted}</div>
            `;
            div.addEventListener('click', () => {
                zipCodeInput.value = suggestion.postcode;
                zipCodeSuggestionsContainer.classList.remove('active');
            });
            zipCodeSuggestionsContainer.appendChild(div);
        });
        zipCodeSuggestionsContainer.classList.add('active');
    }

    // Handle address input changes with debounce
    addressInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            searchAddress(this.value);
        }, 300);
    });

    // Handle blur on address input to show fields if manually typed
    addressInput.addEventListener('blur', function() {
        // Only show if address input has a value and suggestions are not active (meaning no selection was made)
        if (this.value.length > 0 && !suggestionsContainer.classList.contains('active')) {
            addressDetailsRow.style.display = 'flex';
        }
    });

    // Handle zip code input changes with debounce
    zipCodeInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            searchZipCode(this.value);
        }, 300);
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!addressInput.contains(e.target) && !suggestionsContainer.contains(e.target) &&
            !zipCodeInput.contains(e.target) && !zipCodeSuggestionsContainer.contains(e.target)) {
            suggestionsContainer.classList.remove('active');
            zipCodeSuggestionsContainer.classList.remove('active');
            // Optionally hide address details if main address input is empty and no selection was made
            if (addressInput.value === '') {
                addressDetailsRow.style.display = 'none';
            }
        }
    });

    // Handle service tab switching
    $('.service-tabs .service-tab').on('click', function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var serviceType = $(this).data('service');

        // Hide all date/time fields by default and then show relevant ones
        $('#drop_off_field').hide();
        $('#pick_up_field').hide();

        if (serviceType === 'boarding' || serviceType === 'house-sitting') {
            // Show check-in/check-out for boarding and house sitting
            $('#drop_off_field').show();
            $('#pick_up_field').show();
            $('#drop_off').prev('label').text('Drop-off');
            $('#pick_up').prev('label').text('Pick-up');
        } else if (serviceType === 'doggy-day-care') {
            // Show drop-off and pick-up for doggy day care
            $('#drop_off_field').show();
            $('#pick_up_field').show();
            $('#drop_off').prev('label').text('Drop-off (day)');
            $('#pick_up').prev('label').text('Pick-up (day)');
        } else if (serviceType === 'dog-walking' || serviceType === 'drop-in-visits') {
            // Show single date for dog walking and drop-in visits
            $('#drop_off_field').show();
            $('#drop_off').prev('label').text('Date');
            // pick_up_field remains hidden
        }
    });

    // Activate the first tab in the service tabs on page load
    $('#all-services').find('.service-tab').first().trigger('click');

    // Handle pet type toggle (dog/cat)
    $('input[name="search_pet_type"]').on('change', function() {
        var petType = $(this).val();
        if (petType === 'cat') {
            $('.pet-size-row').hide(); // Cat doesn't have dog size
            $('.dog-training-promo').hide(); // Dog training only for dogs
            $('#all-services .service-tab[data-service="doggy-day-care"]').removeClass('active'); // Deactivate doggy day care
            $('#all-services .service-tab[data-service="dog-walking"]').addClass('active'); // Activate dog walking for cats
            $('#all-services .service-tab[data-service="dog-walking"]').trigger('click');
        } else {
            $('.pet-size-row').show();
            $('.dog-training-promo').show();
        }
    });

    // Trigger change on default pet type on page load
    $('input[name="search_pet_type"]:checked').trigger('change');

    // Handle pet photo uploads
    $('.pet-photo-upload-box').on('click', function() {
        const inputId = $(this).attr('id').replace('pet-photo-upload-', 'pet-photo-input-');
        $(`#${inputId}`).click();
    });

    $('input[type="file"]').on('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            const uploadBox = $(this).closest('.pet-photo-upload-box');
            const boxNumber = uploadBox.attr('id').split('-').pop();
            
            reader.onload = function(e) {
                const previewItem = $(`
                    <div class="pet-photo-preview-item" data-box="${boxNumber}">
                        <img src="${e.target.result}" alt="Pet photo">
                        <div class="remove-photo">&times;</div>
                    </div>
                `);
                
                // Remove any existing preview for this box
                $(`.pet-photo-preview-item[data-box="${boxNumber}"]`).remove();
                $('#pet-photo-preview').append(previewItem);
                
                // Hide the upload box after successful upload
                uploadBox.hide();
            };
            
            reader.readAsDataURL(file);
        }
    });

    // Handle photo removal
    $(document).on('click', '.remove-photo', function() {
        const boxNumber = $(this).parent().data('box');
        $(this).parent().remove();
        $(`#pet-photo-upload-${boxNumber}`).show();
    });
}); 