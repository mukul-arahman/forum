@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>

                @foreach ($activities as $date => $activity)
                    <div class="pb-2 mt-4 mb-2 border-bottom">{{ $date }}</div>

                    @foreach ($activity as $record)
                        @if (view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @endforeach
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </div>
@endsection
