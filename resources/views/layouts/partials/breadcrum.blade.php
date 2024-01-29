@isset($breadcrumb)
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3>{{$breadcrumb->title}}</h3>
                <ol class="breadcrumb">
                    @foreach($breadcrumb->items as $url => $item)
                        <li class="breadcrumb-item"><a href="{{$url}}">{{$item}}</a></li>
                    @endforeach
                    <li class="breadcrumb-item active">{{$breadcrumb->title}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endisset
