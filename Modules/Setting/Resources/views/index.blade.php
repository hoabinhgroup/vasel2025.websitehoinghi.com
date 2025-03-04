@extends('base::cmspanel.layout.dashboard')
@section('content')
   <style>
	   .max-width-1200 {
    max-width: 1200px;
    margin: 0 auto;
		}
		.flexbox-annotated-section {
    margin-bottom: 2rem;
}
.flexbox-annotated-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    max-width: 103.6rem;
    margin: 0 auto 2rem;
}
@media (min-width: 768px)
.flexbox-annotated-section-annotation, .flexbox-annotated-section-content {
    padding: 0 20px;
}
.flexbox-annotated-section-annotation {
    flex: 1 0 24rem;
}
.pd-all-20 {
    padding: 20px;
}
.flexbox-annotated-section-content {
    flex: 2 1 48rem;
    max-width: 100%;
    min-width: 0;
}
.wrapper-content {
    background: #fff;
    border-radius: 3px;
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
}
.text-title-field {
    margin-bottom: 5px;
    font-weight: 400;
    display: block;
    line-height: 15px;
}
.next-input, .next-input--stylized {
    min-width: 75px;
    vertical-align: baseline;
    height: auto;
    margin: 0;
    color: #000;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding: 5px 10px;
    border: 1px solid #c4cdd5;
    border-radius: 3px;
    font-weight: 400;
    line-height: 24px;
    text-transform: none;
    letter-spacing: normal;
    box-sizing: border-box;
    display: block;
    width: 100%;
    transition: all .2s ease-out;
    transition-property: box-shadow,color;
    box-shadow: inset 0 1px 0 0 rgba(63,63,68,.05);
    border-color: #c4cdd5;
    outline: none;
}
.p-none-t {
    padding-top: 0!important;
}
	</style> 
    {!! Form::open(['route' => ['setting.edit']]) !!}
        <div class="max-width-1200">
            <div class="flexbox-annotated-section">

                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>{{ __('Setting::setting.general.general_block') }}</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">{{ __('Setting::setting.general.description') }}</p>
                    </div>
                </div>

                <div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">
                        <div class="form-group">
                            <label class="text-title-field"
                                   for="admin_email">{{ trans('Setting::setting.general.admin_email') }}</label>
                            <input type="email" class="next-input" name="admin_email" id="admin_email"
                                   value="{{ setting('admin_email') }}">
                        </div>

                        <div class="form-group">
                            <label class="text-title-field"
                                   for="time_zone">{{ trans('Setting::setting.general.time_zone') }}
                            </label>
                            <div class="ui-select-wrapper">
                                <select name="time_zone" class="ui-select form-control select-search-full" id="time_zone">
                                    @foreach(DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $timezone)
                                        <option value="{{ $timezone }}" @if (setting('time_zone', 'UTC') === $timezone) selected @endif>{{ $timezone }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="enable_send_error_reporting_via_email" value="0">
                            <label>
                                <input type="checkbox" class="hrv-checkbox" value="1" @if (setting('enable_send_error_reporting_via_email')) checked @endif name="enable_send_error_reporting_via_email">
                                {{ trans('Setting::setting.general.enable_send_error_reporting_via_email') }}
                            </label>
                        </div>
                     

                    </div>
                </div>

            </div>

            <div class="flexbox-annotated-section">

                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>{{ trans('Setting::setting.general.languages') }}</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">{{ trans('Setting::setting.general.languages_description') }}</p>
                    </div>
                </div>

				<div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">
        
                        <div class="form-group">
                             <select name="main_language" class="ui-select form-control select-search-full" id="main_language">
                                   
                           <option value="vi" @if (setting('main_language') === 'vi') selected @endif>Vietnamese</option>
                           <option value="en" @if (setting('main_language') === 'en') selected @endif>English</option>
                             
                                </select>
                        </div>

                    </div>
                </div>
                
            </div>

            <div class="flexbox-annotated-section">

<div class="flexbox-annotated-section-annotation">
    <div class="annotated-section-title pd-all-20">
        <h2>{{ trans('Setting::setting.general.admin_appearance_title') }}</h2>
    </div>
    <div class="annotated-section-description pd-all-20 p-none-t">
        <p class="color-note">{{ trans('Setting::setting.general.admin_appearance_description') }}</p>
    </div>
</div>

<div class="flexbox-annotated-section-content">
    <div class="wrapper-content pd-all-20">
        <div class="form-group">
            <label class="text-title-field"
                   for="admin-logo">{{ trans('Setting::setting.general.admin_logo') }}
            </label>
            <div class="admin-logo-image-setting">
                {!! Form::singleImage('admin_logo', Storage::url(setting('admin_logo'))) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="text-title-field"
                   for="admin-favicon">{{ trans('Setting::setting.general.admin_favicon') }}
            </label>
            <div class="admin-favicon-image-setting">
                {!! Form::singleImage('admin_favicon', Storage::url(setting('admin_favicon'))) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="text-title-field"
                   for="admin-login-screen-background">{{ trans('Setting::setting.general.admin_login_screen_background') }}
            </label>
            <div class="admin-login-screen-background-setting">
                {!! Form::singleImage('admin_login_screen_background', Storage::url(setting('admin_login_screen_background'))) !!}
            </div>
        </div>

        <div class="form-group">
            <label class="text-title-field"
                   for="admin_title">{{ trans('Setting::setting.general.admin_title') }}</label>
            <input data-counter="120" type="text" class="next-input" name="admin_title" id="admin_title"
                   value="{{ setting('admin_title', config('app.name')) }}">
        </div>

    </div>
</div>
</div>

			
    

            {!! do_action(BASE_FILTER_AFTER_SETTING_CONTENT, null) !!}

            <div class="flexbox-annotated-section" style="border: none">
                <div class="flexbox-annotated-section-annotation">
                    &nbsp;
                </div>
                <div class="flexbox-annotated-section-content">
                    <button class="btn btn-info" type="submit">{{ trans('Setting::setting.save_settings') }}</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
    
    @include('media::partials.media')
    <script>
       "use strict";
       Louis.initMediaIntegrate();
    </script>
@endsection
