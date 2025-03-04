<?php

namespace Modules\Registration\Listeners;

use Modules\Member\Entities\MemberRegistration;

class MemberRegistrationListener
{
    public function handle($data)
    {

         return MemberRegistration::updateOrCreate(
                [
                 'member_id' => getMemberSignedIn()->id,
                 'reference_id' => $data->id,
                 'reference_type' => get_class($data)
                 ]
            );
        
    }
}
