@extends('layouts.app')

@section('header')
    <link href="/css/vendor/jquery.atwho.css" rel="stylesheet">
@endsection

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card" style="margin-bottom: 15px;">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <img src="{{ $thread->creator->avatar_path }}" alt="" width="25"  class="mr-1">

                                    <span>
                                        <a href="{{ route('profile', $thread->creator )}}">
                                            {{ __($thread->creator->name) }}
                                        </a> posted:
                                        {{ __($thread->title) }}
                                    </span>
                                </div>

                                <span>
                                    @can ('update', $thread)
                                        <form action="{{ $thread->path() }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-link">Delete Thread</button>
                                        </form>
                                    @endcan
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div><!-- /.col-8 -->

                <div class="col-md-4">
                    <div class="card" style="margin-bottom: 15px;">
                        <div class="card-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a> and currently has
                                <span v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count) }}.
                            </p>

                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedto) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div><!-- /.col-4 -->
            </div><!-- /.row -->
        </div>
    </thread-view>
@endsection
