<ul class="list-unstyled chat-history">
    
    @foreach ($messages->reverse() as $date => $messageGroup)
        <li class="d-flex justify-content-center">
            <span class="badge bg-danger align-items-center"><i class="ti ti-info-circle small"></i> Dilarang melakukan transaksi diluar Marketplace untuk menghindari terjadinya penipuan.</span>
        </li>
        <li class="divider divider-dashed">
            <div class="divider-text">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</div>
        </li>
        
        @foreach ($messageGroup->sortBy('created_at') as $message)
            <li class="chat-message {{ $message->from_id == auth()->user()->id ? 'chat-message-right' : '' }}">
                <div class="d-flex overflow-hidden">
                    <div class="chat-message-wrapper flex-grow-1">
                        <div class="chat-message-text">
                            <p class="mb-0">{{ $message->body }}</p>
                        </div>
                        <div class="text-muted mt-1">
                            <small>{{ \Carbon\Carbon::parse($message->created_at)->format('h:i A') }}</small>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    @endforeach
</ul>
