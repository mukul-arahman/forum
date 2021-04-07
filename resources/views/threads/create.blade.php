@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create a New Thread') }}</div>

                <div class="card-body">
                    <form method="POST" action="/threads">
                        @csrf

                        <div class="form-group">
                            <label for="channel_id">Choose a Channel:</label>
                            <select name="channel_id" class="form-control">
                                <option value="">Choose One..</option>
                                @foreach (App\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>{{ $channel->name }}</option>
                                @endforeach
                            </select>

                            @error('channel_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="@error('title') is-invalid @enderror form-control" />

                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" class="@error('body') is-invalid @enderror form-control" rows="8">{{ old('body') }}</textarea>

                            @error('body')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
