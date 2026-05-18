{{-- resources/views/travel/partials/step.blade.php --}}
<div class="d-flex mb-4 position-relative">
    {{-- Vertical Line Connector --}}
    @if(!$loop->last)
        <div class="position-absolute" style="left: 15px; top: 35px; bottom: -25px; width: 2px; background-color: #e9ecef;"></div>
    @endif

    <div class="me-3" style="z-index: 1;">
        @if($date)
            {{-- Completed Step --}}
            <span class="badge rounded-circle bg-success p-2">
                <i class="bi bi-check-lg fs-6"></i>
            </span>
        @elseif($active)
            {{-- Current Step --}}
            <span class="badge rounded-circle bg-primary p-2 shadow">
                <i class="bi bi-arrow-right-short fs-6"></i>
            </span>
        @else
            {{-- Future Step --}}
            <span class="badge rounded-circle bg-light text-muted border p-2">
                <i class="bi bi-circle fs-6"></i>
            </span>
        @endif
    </div>
    
    <div class="flex-grow-1">
        <h6 class="mb-0 {{ $active ? 'fw-bold text-primary' : ($date ? 'text-dark' : 'text-muted') }}">
            {{ $title }}
        </h6>
        <div class="small {{ $active ? 'text-dark fw-semibold' : 'text-muted' }}">
            {{ $name }}
        </div>
        
        @if($date)
            <small class="text-success d-block">
                <i class="bi bi-calendar-check me-1"></i>{{ $date }}
            </small>
        @elseif($active)
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle mt-1" style="font-size: 0.7rem;">
                AWAITING DECISION
            </span>
        @endif
    </div>
</div>