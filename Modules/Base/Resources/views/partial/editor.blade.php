@if (isset($attr['shortcode']) && $attr['shortcode'] == true && function_exists('shortcode'))
<style>
.half-circle-spinner {
    width: 30px;
    height: 30px;
    margin: 20px auto;
    border-radius: 100%;
    position: relative;
}
.half-circle-spinner .circle.circle-1 {
    border-top-color: #36c6d3;
    -webkit-animation: half-circle-spinner-animation 1s infinite;
    animation: half-circle-spinner-animation 1s infinite;
}
.half-circle-spinner .circle {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 100%;
    border: 2px solid transparent;
}
.half-circle-spinner .circle.circle-2 {
    border-bottom-color: #36c6d3;
    -webkit-animation: half-circle-spinner-animation 1s infinite alternate;
    animation: half-circle-spinner-animation 1s infinite alternate;
}

</style>
<div style="height: 35px;">
@php $result = !empty($id) ? $id : $name; @endphp
    <span class="editor-action-item list-shortcode-items">
       
                    <button type="button" class="btn btn-primary dropdown-toggle add_shortcode_btn_trigger" data-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false" data-result="{{ $result }}">
                            <i class="fa fa-code"></i> Shortcode
                          </button>
                     <div class="dropdown-menu arrow">
                        @foreach ($shortcodes = shortcode()->getAll() as $key => $item)
                            <li class="dropdown-item" type="button">
                                <a href="{{ route('short-codes.ajax-get-admin-config', $key) }}" data-has-admin-config="{{ Arr::has($item, 'admin_config') }}" data-key="{{ $key }}" data-description="{{ $item['description'] }}">{{ $item['name'] }}</a>
                            </li>
                        @endforeach
                    </div>



     </span>


                @push('footer')
                    <div class="modal fade short_code_modal" tabindex="-1"  aria-labelledby="ajaxModal" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h4 class="modal-title"><i class="til_img"></i><strong>Thêm Shortcode</strong></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>

                                <div class="modal-body with-padding">
                                    <form class="form-horizontal short-code-data-form">
                                        <input type="hidden" class="short_code_input_key">

                                        <div class="half-circle-spinner">
                                            <div class="circle circle-1"></div>
                                            <div class="circle circle-2"></div>
                                        </div>

                                        <div class="short-code-admin-config">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="float-left btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                                    <button class="float-right btn btn-primary add_short_code_btn">Thêm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end Modal -->


                @endpush



{!! apply_filters(BASE_FILTER_FORM_EDITOR_BUTTONS, null) !!}
</div>
@endif



<div class="clearfix"></div>
