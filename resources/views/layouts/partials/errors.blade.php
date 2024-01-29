@if ($errors->any())
    <div class="col-12 p-l-10 p-r-10">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    </div>
@endif
@if(session('error'))
<div class="col-12 p-l-10 p-r-10">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            {{session('error')}}
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif
