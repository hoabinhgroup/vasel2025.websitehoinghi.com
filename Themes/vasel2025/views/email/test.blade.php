@extends('theme::layouts.master')
@section('content')
<p>Dear {title}. {fullname}</p>
<p> </p>
<p>Your registration has been received. Please save this email for future reference.</p>
<p>Event: <strong>The 19th Annual Scientific Meeting of Asia Pacific Society of Cardiovascular and Interventional Radiology (APSCVIR 2025)</strong></p>
<p>Date: <strong>April 25th – 27th, 2025</strong></p>
<p>Venue: <strong>Ariyana Convention Center, located at 107 Vo Nguyen Giap Str., Da Nang City, Vietnam</strong></p>
<p> </p>
<p><strong>Registration Details:</strong></p>
<p>Full name: {title}. {fullname}</p>
<p>Affiliation: {affiliation}     </p>
<p>Country: {country}      </p>
<p>Registration No.: {guest_code}       </p>
<p>Email: {email}      </p>
<p> </p>
<p><strong>Conference fee:</strong></p>
<p>Conference type: Plenary/Invited Speakers</p>
<p>Total amount: Full fee waiver</p>
<p> </p>
<p>If you need any further assistance, please feel free to contact us at <a href="mailto:vsir.radiology@gmail.com/apscvir2025.secretariat@gmail.com">vsir.radiology@gmail.com/apscvir2025.secretariat@gmail.com</a></p>
<p> </p>
<p>We look forward to seeing you in Da Nang City!</p>
<p> </p>
<p>Kind regards,</p>
<p>APSCVIR 2025 Secretariat Team</p>

@endsection