<div class="modal modal-sticky modal-static overflow-hidden" id="modal-form" role="dialog" data-backdrop="false">
    <div class="modal-dialog h-100 d-flex justify-content-center align-items-center " role="document">
        <div class="modal-content ">
            <div class="d-flex flex-stack py-5 ps-8 pe-5 border-bottom">
                <h5 class="fw-bold m-0"></h5>
                <div class="d-flex ms-2">
                    <div class="btn btn-icon btn-sm btn-light-primary ms-2 close" data-bs-dismiss="modal">
                        <i class="fas fa-times"> </i>
                    </div>
                </div>
            </div>
            <div class="d-block  overflow-auto" style="max-height: 550px">
                <div id="load" class="load" style="display: none; height: 370px;">
                    <img src="{{ asset('images/gif/loading.gif') }}" height="370" width="100%">
                </div>
                <div class="append" id="content">
                </div>
{{--                <div class="card rounded-0 bg-light-dark ">--}}
{{--                </div>--}}

            </div>

        </div>
    </div>
</div>
