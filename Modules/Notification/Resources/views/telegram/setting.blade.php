<div class="flexbox-annotated-section">

                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>Tùy chọn thông báo</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">Cấu hình thông báo qua telegram, email....</p>
                    </div>
                </div>

                <div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">
                        <div class="form-group">
                            <label class="text-title-field" for="admin_email">Telegram bot token</label>
                            <input type="text" class="next-input" name="telegram_bot_token" id="telegram_bot_token" value="{{ setting('telegram_bot_token') }}">
                        </div>
                        
                         <div class="form-group">
                            <label class="text-title-field" for="admin_email">Telegram Id</label>
                            <input type="text" class="next-input" name="telegram_id" id="telegram_id" value="{{ setting('telegram_id') }}">
                        </div>
                        
                                               
                        
                        <div class="form-group">
                            <input type="hidden" name="enable_send_error_reporting_via_telegram" value="0">
                            <label>
                                <input type="checkbox" class="hrv-checkbox" value="1" @if (setting('enable_send_error_reporting_via_telegram')) checked @endif name="enable_send_error_reporting_via_telegram">
                                Bật gửi thông báo lỗi qua Telegram
                            </label>
                        </div>

                    </div>
                </div>

            </div>
