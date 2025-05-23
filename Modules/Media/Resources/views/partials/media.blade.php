<div class="modal fade media-modal"
     data-keyboard="false"
     tabindex="-1"
     role="dialog"
     id="louis_media_modal"
     aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-full">
        <div class="modal-content bb-loading">
            <div class="modal-header">
                <h4 class="modal-title"><i class="til_img"></i><strong>{{ trans('media::media.gallery') }}</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('media::media.close') }}"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body media-modal-body media-modal-loading" id="louis_media_body"></div>
            <div class="loading-wrapper">
                <div class="loader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                                stroke-miterlimit="10"/>
                    </svg>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('media::config')
<link href="{{ asset('vendor/core/modules/media/css/media.css?v=' . time()) }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('vendor/core/modules/media/js/integrate.js?v=' . time()) }}"></script>
