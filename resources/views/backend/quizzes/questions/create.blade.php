<form id="create" action="{{ route('quizzes.questions.store', $quiz->id) }}" method="POST">
    @csrf
    <div class="row">
        <!-- Question -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                <textarea name="question" class="form-control" rows="3" required placeholder="Enter your question"></textarea>
            </div>
        </div>
        
        <!-- Marks -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="marks" class="form-label">Marks <span class="text-danger">*</span></label>
                <input value="1" name="marks" type="number" class="form-control" min="1" required>
            </div>
        </div>
        
        <!-- Options -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="options" class="form-label">Options <span class="text-danger">*</span></label>
                <div id="options-container">
                    @for ($i = 0; $i < 4; $i++)
                    <div class="option-row mb-2 d-flex align-items-center gap-2">
                        <input type="radio" name="correct_option" value="{{ $i }}" class="correct-option-radio">
                        <input type="text" name="options[{{ $i }}][option_text]" class="form-control flex-grow-1" required placeholder="Option {{ $i + 1 }}">
                        <button type="button" class="btn btn-danger btn-sm remove-option" {{ $i < 2 ? 'disabled' : '' }}>
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                    @endfor
                </div>
                <button type="button" class="btn btn-primary btn-sm mt-2" id="add-option">
                    <i class="ti ti-plus"></i> Add Option
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-sm-12">
            <div class="text-center mt-1">
                <button type="submit" class="btn btn-primary">Create Question</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    initValidate('#create');
    
    let optionCount = 4;

    // Add new option
    $('#add-option').click(function() {
        optionCount++;
        const html = `
            <div class="option-row mb-2 d-flex align-items-center gap-2">
                <input type="radio" name="correct_option" value="${optionCount - 1}" class="correct-option-radio">
                <input type="text" name="options[${optionCount - 1}][option_text]" class="form-control flex-grow-1" required placeholder="Option ${optionCount}">
                <button type="button" class="btn btn-danger btn-sm remove-option">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        `;
        $('#options-container').append(html);
        
        // Update remove button states
        updateRemoveButtonStates();
    });

    // Remove option
    $('#options-container').on('click', '.remove-option', function() {
        if ($('.option-row').length > 2) {
            $(this).parent().remove();
            updateRemoveButtonStates();
        }
    });

    // Update remove button states
    function updateRemoveButtonStates() {
        $('.remove-option').prop('disabled', $('.option-row').length <= 2);
    }

    // Convert radio buttons to checkboxes for multiple correct answers (if needed)
    // For now, it's single correct answer (radio buttons)

    $("#create").submit(function(e) {
        e.preventDefault();
        
        // Convert radio button value to options is_correct flag
        const correctIndex = parseInt($("input[name='correct_option']:checked").val());
        const options = [];
        
        $(".option-row").each(function(index) {
            const optionText = $(this).find("input[name^='options']").val();
            options.push({
                option_text: optionText,
                is_correct: index === correctIndex ? 1 : 0
            });
        });

        // Submit form using AJAX with proper data format
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                question: $("textarea[name='question']").val(),
                marks: $("input[name='marks']").val(),
                options: options
            },
            success: function(response) {
                if (response.status === true) {
                    // Show success notification
                    toastr.success(response.notification);
                    // Close the modal after 1.5 seconds
                    setTimeout(function() {
                        $(".modal").modal('hide');
                        // Refresh the page if needed
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.notification);
                }
            },
            error: function(xhr) {
                // Handle validation errors
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        toastr.error(messages[0]);
                    });
                } else {
                    toastr.error('An error occurred while processing your request.');
                }
            }
        });
    });

    const callbackCreateForm = function(response) {
        setTimeout(function() {
            location.reload();
        }, 1500);
    }
});
</script>
