<div class="container-fluid mt-1" style="width: 100%;">
    <div class="row">
        @foreach($mods as $mod)
            <div class="col-md-4 col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $mod['name'] }}</h5>
                        <span>{{ $mod['status'] }}</span>
                        <a href="{{ route('mod.selected', $mod['path']) }}" class="btn btn-primary">Editer</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
