@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Material</h2>
    <form action="{{ route('materials.update', $material->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $material->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $material->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Material File (optional)</label>
            <input type="file" name="file" id="file" class="form-control">
            @if($material->file)
                <p>Current file: <a href="{{ asset('storage/' . $material->file) }}" target="_blank">Download</a></p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update Material</button>
        <a href="{{ route('materials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection