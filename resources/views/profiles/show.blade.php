@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach ($threads as $thread)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <span>
                                    <a href="{{ route('profile', $thread->creator)}}">{{ $thread->creator->name }}</a> posted:
                                    {{ $thread->title }}
                                </span>

                                <span>
                                    {{ $thread->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div><!-- /.card-header -->

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div><!-- /.card -->
                @endforeach

                {{ $threads->links() }}
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </div>
@endsection
