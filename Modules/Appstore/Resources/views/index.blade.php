@extends('base::cmspanel.layout.dashboard')

@section('content')
     <div id="plugin-list" class="clearfix app-grid--blank-slate row">
        @foreach ($list as $plugin)
     
            <div class="app-card-item col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="app-item app-{{ $plugin->path }}">
                    <div class="app-icon">
                        @if ($plugin->image)
                            <img src="data:image/png;base64,{{ $plugin->image }}">
                        @endif
                    </div>
                    <div class="app-details">
                        <h4 class="app-name">{{ $plugin->name }}</h4>
                    </div>
                    <div class="app-footer">
                        <div class="app-description" title="{{ $plugin->description }}">{{ $plugin->description }}</div>
                        <div class="app-author">{{ (isset($plugin->author)) ? 'Tác giả: '. $plugin->author : '' }}</div>
                        <div class="app-version">{{ (isset($plugin->version)) ? 'Phiên bản: '. $plugin->version : '' }}</div>
                        <div class="app-actions">
                        @if(!in_array($plugin->name, $core_plugin))
                            <button class="btn @if ($plugin->status) btn-warning @else btn-info @endif btn-trigger-change-status" data-plugin="{{ $plugin->path }}" data-status="{{ $plugin->status }}">@if ($plugin->status) {{ trans('appstore::common.deactivate') }} @else {{ trans('appstore::common.activate') }} @endif</button>
                          

                            <button class="btn btn-danger btn-trigger-remove-plugin" data-plugin="{{ $plugin->path }}">{{ trans('appstore::common.remove') }}</button>
                            @endif  
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div id="remove-plugin-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog    modal-xs  ">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title"><i class="til_img"></i><strong>Xoá gói mở rộng</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body with-padding">
                Bạn có chắc chắn muốn xoá plugin này?
            </div>

            <div class="modal-footer">
                <button class="float-left btn btn-warning" data-dismiss="modal">Hủy bỏ</button>
                <a class="float-right btn btn-danger" id="confirm-remove-plugin-button" href="#">Có, xoá!</a>
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->
    
@endsection

