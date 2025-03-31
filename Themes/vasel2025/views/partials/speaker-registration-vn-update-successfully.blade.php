@extends('theme::layouts.master')
@section('content')
    <div id="wrap" class="container">
        <div class="contents" id="">
            <div class="sub-conbox inner-layer">
                <div class="sub-tit-wrap">
                    <h3 class="sub-tit text-center">
                        CHỈNH SỬA THÀNH CÔNG
                    </h3>
                </div>

                <div align="center">
                    <table class="MsoTableGrid" border="0" cellspacing="0" cellpadding="0" width="100%"
                        style="border-collapse: collapse; width: 100%; border-color: initial; border-style: none;">
                        <tbody>
                            <tr>
                                <td width="1047">
                                    <p align="center"><span lang="EN-US">BANNER WEB 1439 x 330px</span><span lang="EN-US">
                                            <o:p></o:p>
                                        </span></p>
                                </td>
                            </tr>
                            <tr style="height: 90.15pt;">
                                <td width="1047" style="width: 785.2pt; padding: 0cm 5.4pt; height: 90.15pt;">
                                    <p><strong>CHỈNH SỬA THÀNH CÔNG</strong></p>
                                    <p><span lang="VI">Thông tin đăng ký của Quý đại biểu đã được chỉnh sửa thành công.<o:p>
                                            </o:p></span></p>
                                    <p><span lang="VI">Vui lòng sử dụng liên kết bên dưới để chỉnh sửa thông tin đăng ký cho
                                            đến ngày kết thúc đăng ký.<o:p></o:p></span></p>
                                    <p><a href="{{  route('speaker.registration.vn') }}/?edit={{ $id }}">Chỉnh sửa thông tin
                                            đăng ký</a>
                                    </p>
                                    <p class="MsoNormal"><a href="{{  route('speaker.registration.vn') }}">Gửi đăng ký
                                            mới</a><b></b></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection