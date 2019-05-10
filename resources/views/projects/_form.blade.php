@csrf


<div class="field">
    <label for="title" class="label">Title</label>

    <div class="control">
        <input type="text" name="title" id=""
            class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
            placeholder="My next awesome project" value="{{$project->title}}">
    </div>
</div>

<div class="field">
    <label for="description" class="label">Description</label>

    <div class="control">
        <textarea name="description" id="" class="textarea" placeholder="I should start learning piano." required>
        {{$project->description}}
        </textarea>
    </div>

</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link">{{ $buttonText }}</button>
        <a href="{{ $project->path() }}">Cancel</a>
    </div>
</div>

@if ($errors->any())
<div class="field mt-6">
    @foreach ($errors->all() as $error)
    <li class="text-sm text-red">{{ $error }}</li>
    @endforeach
</div>
@endif
