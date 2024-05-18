<!--begin::Form-->
<form id="kt_modal_form" class="form" action="{{$route}}" method="post" data-method="{{isset($model)?'PUT':'POST'}}">
    @csrf
    @if(isset($model))
        @method('PUT')
    @endif
    <!--begin::Scroll-->
    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_scroll" data-kt-scroll="true"
         data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_header"
         data-kt-scroll-wrappers="#kt_modal_scroll" data-kt-scroll-offset="300px">
        <x-group-input-text label="name" value="{{isset($model)?$model->name:''}}" name="name" ></x-group-input-text>
        <input type="hidden" value="{{isset($model)?$model->id:''}}" name="id">
    </div>
    <!--end::Scroll-->
          <!--begin::Input group-->
          <div class="fv-row">
            <!--begin::Dropzone-->
            <div class="dropzone" id="dropzone">
                <!--begin::Message-->
                <div class="dz-message needsclick">
                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                            class="path2"></span></i>
    
                    <!--begin::Info-->
                    <div class="ms-4">
                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                        <span class="fs-7 fw-semibold text-gray-400">Upload up to 20 images</span>
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Dropzone-->
        </div>
    <!--end::Input group-->
  
    @if(isset($model))
    <div class="row">

        @foreach($model->getMedia() as $image)
            <div class="col-6 ">
                <div class="card h-100 m-1">
                    <a class="my-image-links" data-gall="gallery01"
                       href="{{asset('/storage/'.$image->id.'/'.$image->file_name)}}">
                        <img class="img-thumbnail img-fluid" src="{{asset('/storage/'.$image->id.'/'.$image->file_name)}}"></a>
                </div>
            </div>


        @endforeach
    </div>
@endif



    <!--begin::Actions-->
    <div class="text-center pt-10">
        <button type="reset" class="btn btn-light me-3 close" data-kt-users-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Actions-->
    <div id="image_inputs">

    </div>


</form>
<!--end::Form-->
{{--@push('scripts')--}}
{{--    <script src="{{asset("assets/js/custom/apps/user-management/users/list/add.js")}}"></script>--}}
{{--@endpush--}}
<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script>
    var myDropzone = new Dropzone("#dropzone", {
    url: "{{ route('upload-image') }}", // Set the url for your upload script location
    paramName: "image", // The name that will be used to transfer the file
    maxFiles: 10,
    maxFilesize: 10, // MB
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    addRemoveLinks: true,
    init: function () {
            this.on('success', function (file, response) {
                // Create a hidden input for each uploaded image
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'image[]';
                input.value = response.filename;
                document.getElementById('image_inputs').appendChild(input);
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr);
            console.error(status);
            console.error(error);
        }
});
</script>

