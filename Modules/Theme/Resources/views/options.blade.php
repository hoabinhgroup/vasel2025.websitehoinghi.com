@extends('base::cmspanel.layout.dashboard')
@section('content')
  <style>
  .modal-dialog{
      max-width: 100%;
  }
  .preview_image{
      width: 300px;
  }
  </style>
    <div id="theme-option-header">
	     <div class="display_header">
            <h2>{{ trans('theme::theme.theme_options') }}</h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="theme-option-container">
        {!! Form::open([route('theme.options.update'), 'method' => 'POST']) !!}
            <div class="theme-option-sticky">
                <div class="info_bar">
                    <div class="float-left">
                        @if (ThemeOption::getArg('debug') == true) <span class="theme-option-dev-mode-notice">{{ __('theme::theme.developer_mode') }}</span>@endif
                    </div>
                    <div class="theme-option-action_bar">
                        {!! apply_filters(THEME_OPTIONS_ACTION_META_BOXES, null, THEME_OPTIONS_NAME) !!}
                        <button type="submit" class="btn btn-primary button-save-theme-options">{{ __('theme::theme.save_changes') }}</button>
                    </div>
                </div>
            </div>
            @php

            @endphp
            <div class="theme-option-sidebar">
                <ul class="nav nav-tabs tab-in-left">
                    @foreach (ThemeOption::constructSections() as $section)
                        <li class="nav-item">
                            <a href="#tab_{{ $section['id'] }}" class="nav-link @if ($loop->first) active @endif" data-toggle="tab">@if (!empty($section['icon']))<i class="{{ $section['icon'] }}"></i> @endif {{ __($section['title']) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="theme-option-main">
                <div class="tab-content tab-content-in-right">
                    @foreach(ThemeOption::constructSections() as $section)
                        <div class="tab-pane @if ($loop->first) active @endif" id="tab_{{ $section['id'] }}">
                            @foreach (ThemeOption::constructFields($section['id']) as $field)
                            @php

                            @endphp
                                <div class="form-group @if ($errors->has($field['attributes']['name'])) has-error @endif">
                                    {!! Form::label($field['attributes']['name'], __($field['label']), ['class' => 'control-label']) !!}
                                    {!! ThemeOption::renderField($field) !!}
                                    @if (array_key_exists('helper', $field))
                                        <span class="help-block">{!! __($field['helper']) !!}</span>
                                    @endif
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="theme-option-sticky">
                <div class="info_bar">
                    <div class="theme-option-action_bar">
                        {!! apply_filters(THEME_OPTIONS_ACTION_META_BOXES, null, THEME_OPTIONS_NAME) !!}
                        <button type="submit" class="btn btn-primary button-save-theme-options">{{ trans('theme::theme.save_changes') }}</button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    
    
    @include('media::partials.media')
    <script>
       "use strict";
       Louis.initMediaIntegrate();
    </script>

@stop
