@extends('layouts.app')

@section('content')
{{-- <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Dashboard
            </div>

            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->id == 1)
                    @forelse($notifications as $notification)
                        <div class="alert alert-success" role="alert">
                            [{{ $notification->created_at }}] User {{ $notification->data['name'] }} ({{ $notification->data['email'] }}) has just registered.
                            <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                Mark as read
                            </a>
                        </div>

                        @if($loop->last)
                            <a href="#" id="mark-all">
                                Mark all as read
                            </a>
                        @endif
                    @empty
                        There are no new notifications
                    @endforelse
                @else
                    You are logged in!
                @endif
            </div>
        </div>
    </div>
</div> --}}

<div class="m-4 text-blue font-weight-bold">
    <h4><i class="fas fa-plane"></i> Welcome, {{ Auth::user()->name }}!</h4>
</div>

<div class="container mt-4">
    
    {{-- <div class="row justify-content-center">
        <div class="col-sm-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Daily Travel Expenses</h3>
                </div>
                <div class="card-body">
                    <p class="card-text text-center h3">PhP 30,400.00</p>
                    <p class="text-end pt-4"><a href="#" class="btn btn-primary">Go Daily Report</a></p>
                </div>
                
                <div class="card-footer">
                    The footer of the card
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Weekly Travel Expenses</h3>
                </div>
                <div class="card-body">
                    <p class="card-text text-center h3">PhP 100,750.00</p>
                    <p class="text-end pt-4"><a href="#" class="btn btn-primary">Go weekly Report</a></p>
                </div>
                <div class="card-footer">
                    The footer of the card
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Monthly Travel Expenses</h3>
                </div>
                <div class="card-body">
                    <p class="card-text text-center h3">PhP 259,430.00</p>
                    <p class="text-end pt-4"><a href="#" class="btn btn-primary">Go Monthly Report</a></p>
                    
                </div>
                <div class="card-footer">
                    The footer of the card
                </div>
            </div>
        </div> --}}
        <div class="row text-center">
            <div class="col-sm">
                <h3>Page is under construction!!!</h3>
                <p class="pt-4"><img src="images/under_construction2.jpg" alt="Home (Under Construction)"></p>
               
            </div>

        </div>
</div>
@endsection
{{-- @section('scripts')
@parent
@if(auth()->user()->id == 1)
    <script>
    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('home.markNotification') }}", {
            method: 'POST',
            data: {
                _token,
                id
            }
        });
    }

    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));

            request.done(() => {
                $(this).parents('div.alert').remove();
            });
        });

        $('#mark-all').click(function() {
            let request = sendMarkRequest();

            request.done(() => {
                $('div.alert').remove();
            })
        });
    });
    </script>
@endif
@endsection --}}
