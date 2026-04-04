/**
 * RRJournal Meta Box Admin JavaScript
 * Handles repeater fields and file uploads for CFS replacement
 */
(function($) {
    'use strict';

    $(document).ready(function() {

        // Initialize repeater fields
        initRepeaterFields();

        // Initialize file upload fields
        initFileUploads();

        // Initialize board member template (complex nested fields)
        initBoardMemberTemplate();

    });

    /**
     * Initialize repeater field functionality
     */
    function initRepeaterFields() {

        // Add row functionality
        $(document).on('click', '.rr-add-row', function(e) {
            e.preventDefault();

            var button = $(this);
            var targetId = button.data('target');
            var templateId = button.data('template');
            var container = $('#' + targetId);
            var template = $('#' + templateId).html();

            if (!template) {
                console.error('Template not found: ' + templateId);
                return;
            }

            // Get next index
            var currentRows = container.find('.rr-repeater-row');
            var nextIndex = currentRows.length;

            // Replace template placeholder with actual index
            var newRow = template.replace(/{{INDEX}}/g, nextIndex);

            // Add the new row
            container.append(newRow);

            // Focus first input in new row
            container.find('.rr-repeater-row').last().find('input, textarea').first().focus();
        });

        // Remove row functionality
        $(document).on('click', '.rr-remove-row', function(e) {
            e.preventDefault();

            var button = $(this);
            var row = button.closest('.rr-repeater-row');

            // Confirm deletion for complex rows
            if (row.hasClass('rr-complex-row')) {
                if (!confirm('Are you sure you want to remove this board member?')) {
                    return;
                }
            }

            row.fadeOut(300, function() {
                $(this).remove();
                reindexRepeaterRows();
            });
        });

    }

    /**
     * Initialize file upload functionality using WordPress media library
     */
    function initFileUploads() {

        var mediaUploader;

        $(document).on('click', '.rr-upload-file', function(e) {
            e.preventDefault();

            var button = $(this);
            var targetInput = button.data('target');
            var preview = button.siblings('.rr-file-preview');

            // Create media uploader if it doesn't exist
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: 'Choose File',
                button: {
                    text: 'Use this file'
                },
                multiple: false
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();

                // Set the file URL in hidden input
                $('#' + targetInput).val(attachment.url);

                // Update preview
                var fileName = attachment.filename || attachment.title;
                var removeButton = '<button type="button" class="button rr-remove-file" data-target="' + targetInput + '">Remove</button>';
                preview.html(fileName + ' ' + removeButton);
            });

            mediaUploader.open();
        });

        // Remove file functionality
        $(document).on('click', '.rr-remove-file', function(e) {
            e.preventDefault();

            var button = $(this);
            var targetInput = button.data('target');
            var preview = button.closest('.rr-file-preview');

            // Clear the hidden input
            $('#' + targetInput).val('');

            // Clear the preview
            preview.html('');
        });

    }

    /**
     * Initialize board member template for complex nested fields
     */
    function initBoardMemberTemplate() {

        // Add board member functionality (most complex case)
        $(document).on('click', '.rr-add-row[data-template="ebm-template"]', function(e) {
            e.preventDefault();

            var button = $(this);
            var container = $('#editorial-board-members-fields');
            var currentRows = container.find('.rr-repeater-row');
            var nextIndex = currentRows.length;

            // Create complex board member row via AJAX to get proper PHP rendering
            var data = {
                action: 'rr_get_board_member_template',
                index: nextIndex,
                nonce: $('#rr_meta_nonce').val()
            };

            $.post(ajaxurl, data, function(response) {
                if (response.success) {
                    container.append(response.data);
                    // Focus first input in new row
                    container.find('.rr-repeater-row').last().find('input').first().focus();
                }
            });
        });

        // Toggle board member details
        $(document).on('click', '.rr-row-header h5', function() {
            var content = $(this).closest('.rr-complex-row').find('.rr-row-content');
            content.slideToggle(300);
        });

    }

    /**
     * Reindex repeater rows to maintain proper array indices
     */
    function reindexRepeaterRows() {
        $('.rr-repeater-fields').each(function() {
            var container = $(this);
            var fieldName = container.data('field-name');

            container.find('.rr-repeater-row').each(function(index) {
                var row = $(this);
                row.attr('data-index', index);

                // Update input names
                row.find('input, textarea, select').each(function() {
                    var input = $(this);
                    var name = input.attr('name');

                    if (name && name.indexOf('[') !== -1) {
                        // Replace the index in field name
                        var newName = name.replace(/\[\d+\]/g, '[' + index + ']');
                        input.attr('name', newName);
                    }
                });

                // Update board member header numbering
                var header = row.find('.rr-row-header h5');
                if (header.length) {
                    var headerText = header.text().replace(/#\d+/, '#' + (index + 1));
                    header.text(headerText);
                }
            });
        });
    }

})(jQuery);

/**
 * AJAX handler for getting board member template
 * This needs to be added to functions.php as well
 */
// wp_ajax_rr_get_board_member_template action will be handled by PHP