@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('threads._list')

            {{ $threads->render() }}
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Threading Threads
                </div>

                <div class="card-body">
                    Redis does not work on windows
                </div>
            </div><!-- /.card -->
        </div>
    </div>
</div>
@endsection
