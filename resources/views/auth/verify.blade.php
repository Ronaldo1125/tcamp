@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card card-danger">
                <div class="card-header"><strong>{{ __('Verify Your Email Address') }}</strong></div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email, we will be gladly send you another.') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <p>
                        <button type="submit" class="btn btn-primary mt-3">{{ __('Resend Verification Email') }}</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
