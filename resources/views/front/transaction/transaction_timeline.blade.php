<script>
    $(document).ready(function() {
        $('#btn-timeline').click(function() {
            $('#timeline-form').toggle();
        });

        @if (auth()->user()->id === $transaction->freelance_id)
        $('#create-timeline-form').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('create_transaction_timeline', ['id' => $transaction->id]) }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        fetch_timeline('refresh');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    toastr.error('An error occurred while creating the timeline.');
                }
            });
        });
        @endif
    });
</script>
@if (auth()->user()->id === $transaction->freelance_id)
<div class="d-flex justify-content-end">
    <button type="button" id="btn-timeline" class="btn btn-primary mb-3">Create Timeline</button>
</div>

<div id="timeline-form" class="mb-4" style="display: none;">
    <form id="create-timeline-form" method="POST">
        @csrf
        <div class="form-group">
            <label for="progress">Progress</label>
            <select name="progress" id="progress" class="form-control">
                <option value="PENDING">PENDING</option>
                <option value="IN_PROGRESS">IN_PROGRESS</option>
                <option value="COMPLETED">COMPLETED</option>
                <option value="CANCELED">CANCELED</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
</div>
@endif
<div class="timeline">
    @foreach ($timelines as $timeline)    
        <div class="timeline-item">
            <div class="timeline-icon 
                @if ($timeline->progress == 'PENDING')
                    bg-warning
                @elseif ($timeline->progress == 'IN_PROGRESS')
                    bg-info
                @elseif ($timeline->progress == 'COMPLETED')
                    bg-success
                @elseif ($timeline->progress == 'CANCELED')
                    bg-danger
                @else
                    bg-secondary
                @endif
            "></div>
            <div class="timeline-content">
                <div class="d-flex justify-content-between">
                    <div class="date">{{ $timeline->created_at->diffForHumans() }}</div>
                    <div class="date">By {{ $timeline->created_by }}</div>
                </div>
                <span class="badge rounded-pill px-3
                    @if ($timeline->progress == 'PENDING')
                        bg-warning
                    @elseif ($timeline->progress == 'IN_PROGRESS')
                        bg-info
                    @elseif ($timeline->progress == 'COMPLETED')
                        bg-success
                    @elseif ($timeline->progress == 'CANCELED')
                        bg-danger
                    @else
                        bg-secondary
                    @endif
                    small mb-2">{{ $timeline->progress }}</span>
                <p>{{ $timeline->description }}</p>
            </div>
        </div>
    @endforeach
</div>