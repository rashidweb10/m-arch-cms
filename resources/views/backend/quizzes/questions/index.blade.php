<div class="d-flex align-items-center justify-content-between gap-2 mb-3">
    <div>
        <h4 class="fs-16 text-uppercase fw-bold mb-0">
            Quiz 2026 - Questions
        </h4>
    </div>

    <button
        onclick="smallModal('http://127.0.0.1:8000/backend/quizzes/1/questions/create', 'Add New Question')"
        class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0"
    >
        <i class="ti ti-plus"></i>
        <span>New Question</span>
    </button>
</div>

@include('backend.includes.alert-message')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <h5>Total Questions: <b>{{ $questions->count() }}</b></h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Marks</th>
                                <th>Options</th>
                                <th>Correct Answers</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $index => $question)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $question->question }}</td>
                                <td>{{ $question->marks }}</td>
                                <td>{{ $question->options->count() }}</td>
                                <td>{{ $question->options->where('is_correct', 1)->count() }}</td>
                                <td>{{ formatDatetime($question->created_at) }}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="smallModal('{{ route('quizzes.questions.edit', [$quiz->id, $question->id]) }}', 'Edit Question')" class="link-reset fs-20 p-1"> <i class="ti ti-pencil"></i></a>
                                    <a href="javascript:void(0);" onclick="confirmModal('{{ route('quizzes.questions.destroy', [$quiz->id, $question->id]) }}', callbackQuestions )" class="link-reset fs-20 p-1"> <i class="ti ti-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer>
const callbackQuestions = function(response) {
    setTimeout(function() {
        location.reload();
    }, 1500);
}

$(document).ready(function() {
    initSelect2('.select2');
});
</script>
