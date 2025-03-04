<div class="louis-media-container">
    <div class="louis-media-wrapper">
        <input type="checkbox" id="media_aside_collapse" class="fake-click-event hidden">
        <input type="checkbox" id="media_details_collapse" class="fake-click-event hidden">
        <aside class="louis-media-aside @if (config('media.sidebar_display') != 'vertical') louis-media-aside-hide-desktop @endif">
            <label for="media_aside_collapse" class="collapse-sidebar">
                <i class="fa fa-sign-out"></i>
            </label>
            <div class="louis-media-block louis-media-filters">
                <div class="louis-media-block-title">
                    {{ trans('Media::media.filter') }}
                </div>
                <div class="louis-media-block-content">
                    <ul class="louis-media-aside-list">
                        <li>
                            <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="everything">
                                <i class="fa fa-recycle"></i> {{ trans('Media::media.everything') }}
                            </a>
                        </li>
                        @if (array_key_exists('image', config('media.mime_types', [])))
                            <li>
                                <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="image">
                                    <i class="fa fa-file-image"></i> {{ trans('Media::media.image') }}
                                </a>
                            </li>
                        @endif
                        @if (array_key_exists('video', config('media.mime_types', [])))
                            <li>
                                <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="video">
                                    <i class="fa fa-file-video"></i> {{ trans('Media::media.video') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="document">
                                <i class="fa fa-file"></i> {{ trans('Media::media.document') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="louis-media-block louis-media-view-in">
                <div class="louis-media-block-title">
                    {{ trans('Media::media.view_in') }}
                </div>
                <div class="louis-media-block-content">
                    <ul class="louis-media-aside-list">
                        <li>
                            <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="all_media">
                                <i class="fa fa-globe"></i> {{ trans('Media::media.all_media') }}
                            </a>
                        </li>
                        @if (LouisMedia::hasAnyPermission(['folders.destroy', 'files.destroy']))
                            <li>
                                <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="trash">
                                    <i class="fa fa-trash"></i> {{ trans('Media::media.trash') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="recent">
                                <i class="fa fa-clock"></i> {{ trans('Media::media.recent') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="favorites">
                                <i class="fa fa-star"></i> {{ trans('Media::media.favorites') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <div class="louis-media-main-wrapper">
            <header class="louis-media-header">
                <div class="louis-media-top-header">
                    <div class="louis-media-actions">
                        <label for="media_aside_collapse" class="btn btn-danger collapse-sidebar">
                            <i class="fa fa-bars"></i>
                        </label>
                        @if (LouisMedia::hasPermission('files.create'))
                            <button class="btn btn-success js-dropzone-upload">
                                <i class="fas fa-cloud-upload-alt"></i> {{ trans('Media::media.upload') }}
                            </button>
                        @endif
                        @if (LouisMedia::hasPermission('folders.create'))
                            <button class="btn btn-success" data-toggle="modal" data-target="#modal_add_folder">
                                <i class="fa fa-folder"></i> {{ trans('Media::media.create_folder') }}
                            </button>
                        @endif
                        <button class="btn btn-success js-change-action" data-type="refresh">
                            <i class="fas fa-sync"></i> {{ trans('Media::media.refresh') }}
                        </button>

                        @if (config('media.sidebar_display') != 'vertical')
                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle js-louis-media-change-filter-group" type="button" data-toggle="dropdown">
                                        <i class="fa fa-filter"></i> {{ trans('Media::media.filter') }} <span class="js-louis-media-filter-current"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="everything">
                                                <i class="fa fa-recycle"></i> {{ trans('Media::media.everything') }}
                                            </a>
                                        </li>
                                        @if (array_key_exists('image', config('media.mime_types', [])))
                                            <li>
                                                <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="image">
                                                    <i class="fa fa-file-image"></i> {{ trans('Media::media.image') }}
                                                </a>
                                            </li>
                                        @endif
                                        @if (array_key_exists('video', config('media.mime_types', [])))
                                            <li>
                                                <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="video">
                                                    <i class="fa fa-file-video"></i> {{ trans('Media::media.video') }}
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="#" class="js-louis-media-change-filter" data-type="filter" data-value="document">
                                                <i class="fa fa-file"></i> {{ trans('Media::media.document') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="btn-group" role="group">
                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle js-louis-media-change-filter-group" type="button" data-toggle="dropdown">
                                        <i class="fa fa-eye"></i> {{ trans('Media::media.view_in') }} <span class="js-louis-media-filter-current"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="all_media">
                                                <i class="fa fa-globe"></i> {{ trans('Media::media.all_media') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="trash">
                                                <i class="fa fa-trash"></i> {{ trans('Media::media.trash') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="recent">
                                                <i class="fa fa-clock"></i> {{ trans('Media::media.recent') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="js-louis-media-change-filter" data-type="view_in" data-value="favorites">
                                                <i class="fa fa-star"></i> {{ trans('Media::media.favorites') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if (LouisMedia::hasAnyPermission(['folders.destroy', 'files.destroy']))
                            <button class="btn btn-danger js-files-action hidden" data-action="empty_trash">
                                <i class="fa fa-trash"></i> {{ trans('Media::media.empty_trash') }}
                            </button>
                        @endif

                    </div>
                    <div class="louis-media-search">
                        <form class="input-search-wrapper" action="" method="GET">
                            <input type="text" class="form-control" placeholder="{{ trans('Media::media.search_file_and_folder') }}">
                            <button class="btn btn-link" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="louis-media-bottom-header">
                    <div class="louis-media-breadcrumb">
                        <ul class="breadcrumb"></ul>
                    </div>
                    <div class="louis-media-tools">
                        <div class="btn-group" role="group">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    {{ trans('Media::media.sort') }} <i class="fa fa-sort-alpha-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="name-asc">
                                            <i class="fas fa-sort-alpha-up"></i> {{ trans('Media::media.file_name_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="name-desc">
                                            <i class="fas fa-sort-alpha-down"></i> {{ trans('Media::media.file_name_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-asc">
                                            <i class="fas fa-sort-numeric-up"></i> {{ trans('Media::media.created_date_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="created_at-desc">
                                            <i class="fas fa-sort-numeric-down"></i> {{ trans('Media::media.created_date_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="updated_at-asc">
                                            <i class="fas fa-sort-numeric-up"></i> {{ trans('Media::media.uploaded_date_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="updated_at-desc">
                                            <i class="fas fa-sort-numeric-down"></i> {{ trans('Media::media.uploaded_date_desc') }}
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="size-asc">
                                            <i class="fas fa-sort-numeric-up"></i> {{ trans('Media::media.size_asc') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="js-louis-media-change-filter"
                                           data-type="sort_by"
                                           data-value="size-desc">
                                            <i class="fas fa-sort-numeric-down"></i> {{ trans('Media::media.size_desc') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown louis-dropdown-actions disabled">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button" data-toggle="dropdown">
                                    {{ trans('Media::media.actions') }} &nbsp;<i class="fa fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu"></ul>
                            </div>
                        </div>
                        <div class="btn-group js-louis-media-change-view-type" role="group">
                            <button class="btn btn-secondary" type="button" data-type="tiles">
                                <i class="fa fa-th-large"></i>
                            </button>
                            <button class="btn btn-secondary" type="button" data-type="list">
                                <i class="fa fa-th-list"></i>
                            </button>
                        </div>
                        <label for="media_details_collapse" class="btn btn-link collapse-panel">
                            <i class="fa fa-sign-out"></i>
                        </label>
                    </div>
                </div>
            </header>

            <main class="louis-media-main">
                <div class="louis-media-items"></div>
                <div class="louis-media-details hidden">
                    <div class="louis-media-thumbnail">
                        <i class="far fa-image"></i>
                    </div>
                    <div class="louis-media-description">
                        <div class="louis-media-name">
                            <p>{{ trans('Media::media.nothing_is_selected') }}</p>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="louis-media-footer hidden">
                <button type="button" class="btn btn-danger btn-lg js-insert-to-editor">{{ trans('Media::media.insert') }}</button>
            </footer>
        </div>
        <div class="louis-upload-progress hide-the-pane">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ trans('Media::media.upload_progress') }}</h3>
                    <a href="javascript:void(0);" class="close-pane">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="panel-body">
                    <ul class="louis-upload-progress-table"></ul>
                </div>
            </div>
        </div>
    </div>

    <div class="louis-modals">
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_coming_soon">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fab fa-windows"></i> {{ trans('Media::media.coming_soon') }}
                        </h4>
                        <button type="button" class="close" data-dismiss-modal="#modal_coming_soon" aria-label="{{ trans('Media::media.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>These features are on development</p>
                        <div class="modal-notice"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_add_folder">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fab fa-windows"></i> {{ trans('Media::media.create_folder') }}
                        </h4>
                        <button type="button" class="close" data-dismiss-modal="#modal_add_folder" aria-label="{{ trans('Media::media.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="louis-form form-add-folder">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ trans('Media::media.folder_name') }}">
                                <div class="input-group-prepend">
                                    <button class="btn btn-success louis-btn-add-folder" type="submit">{{ trans('Media::media.create') }}</button>
                                </div>
                            </div>
                        </form>
                        <div class="modal-notice"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_rename_items">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="louis-form form-rename">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('Media::media.rename') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_rename_items" aria-label="{{ trans('Media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="rename-items"></div>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss-modal="#modal_rename_items">{{ trans('Media::media.close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ trans('Media::media.save_changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_trash_items">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="louis-form form-delete-items">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('Media::media.move_to_trash') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_trash_items" aria-label="{{ trans('Media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('Media::media.confirm_trash') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ trans('Media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary" data-dismiss-modal="#modal_trash_items">{{ trans('Media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_delete_items">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="louis-form form-delete-items">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('Media::media.confirm_delete') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_delete_items" aria-label="{{ trans('Media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('Media::media.confirm_delete_description') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ trans('Media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary" data-dismiss-modal="#modal_delete_items">{{ trans('Media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modal_empty_trash">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <form class="louis-form form-empty-trash">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fab fa-windows"></i> {{ trans('Media::media.empty_trash_title') }}
                            </h4>
                            <button type="button" class="close" data-dismiss-modal="#modal_empty_trash" aria-label="{{ trans('Media::media.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('Media::media.empty_trash_description') }}</p>
                            <div class="modal-notice"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ trans('Media::media.confirm') }}</button>
                            <button type="button" class="btn btn-primary" data-dismiss-modal="#modal_empty_trash">{{ trans('Media::media.close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <button class="hidden js-louis-clipboard-temp"></button>
</div>
<script type="text/x-custom-template" id="louis_media_loading">
    <div class="loading-wrapper">
        <div class="showbox">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                            stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
    </div>
</script>

<script type="text/x-custom-template" id="louis_action_item">
    <li>
        <a href="javascript:;" class="js-files-action" data-action="__action__">
            <i class="__icon__"></i> __name__
        </a>
    </li>
</script>

<script type="text/x-custom-template" id="louis_media_items_list">
    <div class="louis-media-list">
        <ul>
            <li class="no-items">
                <i class="fas fa-cloud-upload-alt"></i>
                <h3>Drop files and folders here</h3>
                <p>Or use the upload button above.</p>
            </li>
            <li class="louis-media-list-title up-one-level js-up-one-level" title="{{ trans('Media::media.up_level') }}">
                <div class="custom-checkbox"></div>
                <div class="louis-media-file-name">
                    <i class="fas fa-level-up-alt"></i>
                    <span>...</span>
                </div>
                <div class="louis-media-file-size"></div>
                <div class="louis-media-created-at"></div>
            </li>
        </ul>
    </div>
</script>

<script type="text/x-custom-template" id="louis_media_items_tiles" class="hidden">
    <div class="louis-media-grid">
        <ul>
            <li class="no-items">
                <i class="__noItemIcon__"></i>
                <h3>__noItemTitle__</h3>
                <p>__noItemMessage__</p>
            </li>
            <li class="louis-media-list-title up-one-level js-up-one-level">
                <div class="louis-media-item" data-context="__type__" title="{{ trans('Media::media.up_level') }}">
                    <div class="louis-media-thumbnail">
                        <i class="fas fa-level-up-alt"></i>
                    </div>
                    <div class="louis-media-description">
                        <div class="title">...</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</script>

<script type="text/x-custom-template" id="louis_media_items_list_element">
    <li class="louis-media-list-title js-media-list-title js-context-menu" data-context="__type__" title="__name__" data-id="__id__">
        <div class="custom-checkbox">
            <label>
                <input type="checkbox">
                <span></span>
            </label>
        </div>
        <div class="louis-media-file-name">
            __thumb__
            <span>__name__</span>
        </div>
        <div class="louis-media-file-size">__size__</div>
        <div class="louis-media-created-at">__date__</div>
    </li>
</script>

<script type="text/x-custom-template" id="louis_media_items_tiles_element">
    <li class="louis-media-list-title js-media-list-title js-context-menu" data-context="__type__" data-id="__id__">
        <input type="checkbox" class="hidden">
        <div class="louis-media-item" title="__name__">
            <span class="media-item-selected">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M186.301 339.893L96 249.461l-32 30.507L186.301 402 448 140.506 416 110z"></path>
                </svg>
            </span>
            <div class="louis-media-thumbnail">
                __thumb__
            </div>
            <div class="louis-media-description">
                <div class="title title{{Request::get('file_id')}}">__name__</div>
            </div>
        </div>
    </li>
</script>

<script type="text/x-custom-template" id="louis_media_upload_progress_item">
    <li>
        <div class="louis-table-col">
            <span class="file-name">__fileName__</span>
            <div class="file-error"></div>
        </div>
        <div class="louis-table-col">
            <span class="file-size">__fileSize__</span>
        </div>
        <div class="louis-table-col">
            <span class="label label-__status__">__message__</span>
        </div>
    </li>
</script>

<script type="text/x-custom-template" id="louis_media_breadcrumb_item">
    <li>
        <a href="#" data-folder="__folderId__" class="js-change-folder">__icon__ __name__</a>
    </li>
</script>

<script type="text/x-custom-template" id="louis_media_rename_item">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="__icon__"></i>
                </div>
            </div>
            <input class="form-control" placeholder="__placeholder__" value="__value__">
        </div>
    </div>
</script>
