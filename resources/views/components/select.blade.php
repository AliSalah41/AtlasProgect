<!--begin::Input group-->
<div class="fv-row col-12">
    <!--begin::Label-->
    <label class="required fw-semibold fs-6 mb-2">{{$label}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <select class="form-select form-select-solid mb-3 mb-lg-0"  name="{{$name}}" aria-label="">
        @if(isset($old))
            @foreach($options as $option=>$key)
                <option value="{{$key}}" {{$old==$key?'selected':''}} >{{$option}}</option>
            @endforeach
        @else
            @foreach($options as $option=>$key)
                <option value="{{$key}}" >{{$option}}</option>
            @endforeach
        @endif


    </select>
    <!--end::Input-->
</div>
<!--end::Input group-->
