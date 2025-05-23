@extends('theme::layouts.master')
@section('content')
    <div id="wrap" class="container">
        <div class="contents" id="">
            <div class="sub-conbox inner-layer">
                <div class="sub-tit-wrap">
                    <h3 class="sub-tit text-center">
                        REGISTRATION SUCCESSFUL!
                    </h3>
                </div>

                <div align="center">
                    <table class="MsoTableGrid" border="0" cellspacing="0" cellpadding="0" width="100%"
                        style="border-collapse: collapse; width: 100%; border-color: initial; border-style: none;">
                        <tbody>
                            <tr style="height: 90.15pt;">
                                <td width="1047" style="width: 785.2pt; padding: 0cm 5.4pt; height: 90.15pt;">
                                    <p>Thank you for registering your presentation at the Vietnam Association for Surgery
                                        and Endolaparosurgery Scientific Conference 2025.<br />
                                        You may use the link below to edit your registration information until the
                                        registration deadline.

                                    </p>
                                    <p><a href="{{  route('invitee.registration') }}/?edit={{ $id }}">Edit registration
                                            information</a>
                                    </p>
                                    <p class="MsoNormal"><a href="{{  route('invitee.registration') }}">Submit new
                                            registration</a><b></b></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection