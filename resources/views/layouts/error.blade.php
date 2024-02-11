@if ($errors->any())
    <div class="container mt-5 infoAlert" data-remove-after="5" data-removable>
        <div class="row">
            <div class="col-12 justify-content-center">
                <div class="alert alert-danger" role="alert" style="border-radius: 0px">

                    <button class="btn btn-lg closeBtn" style="float: right; margin: 0; padding: 0; color: crimson;"
                        id="closeBtn">&times;</button>
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="text-center">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
