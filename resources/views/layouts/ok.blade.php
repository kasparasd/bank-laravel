@if (session('ok'))
    <div class="container mt-5 infoAlert" data-remove-after="5" data-removable>
        <div class="row">
            <div class="col-12 justify-content-center">
                <div class="alert alert-success" role="alert" style="border-radius: 0px">

                    <button class="btn btn-lg closeBtn" style="float: right; margin: 0; padding: 0; color: crimson;"
                        id="closeBtn">&times;</button>
                        {{ session('ok') }}
                </div>
            </div>
        </div>
    </div>
@endif
