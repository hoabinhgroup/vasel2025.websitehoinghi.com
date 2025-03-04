<?php

return [
    [
        'name' => 'Registrations',
        'flag' => 'registration.index',
    ],
    // [
    //     'name' => 'Vsa Registrations',
    //     'flag' => 'vsa-registration.index',
    // ],
    // [
    //     'name' => 'Vsa Registrations Export',
    //     'flag' => 'vsa-registration.export',
    //     'parent_flag' => 'vsa-registration.index',
    // ],
    // [
    //     'name' => 'Vsa Registrations Delete',
    //     'flag' => 'vsa-registration.delete',
    //     'parent_flag' => 'vsa-registration.index',
    // ],
    // [
    //     'name' => 'Vsa Registrations Deletes',
    //     'flag' => 'vsa-registration.deletes',
    //     'parent_flag' => 'vsa-registration.index',
    // ],
    [
        'name' => 'Create',
        'flag' => 'registration.create',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'registration.edit',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'registration.restore',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'registration.delete',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Registrations Export',
        'flag' => 'registration.export',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Delete Many',
        'flag' => 'registration.deletes',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Speaker Submission Table',
        'flag' => 'speaker.registration.index',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Speaker Submission Delete',
        'flag' => 'speaker.registration.delete',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Speaker Submission Export',
        'flag' => 'speaker.registration.export',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Speaker Submission VN Table',
        'flag' => 'speakervn.registration.index',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Speaker Submission VN Delete',
        'flag' => 'speakervn.registration.delete',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Speaker Submission VN Export',
        'flag' => 'speakervn.registration.export',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Invitee Submission Table',
        'flag' => 'invitee.registration.index',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Invitee Submission Delete',
        'flag' => 'invitee.registration.delete',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Invitee Submission Export',
        'flag' => 'invitee.registration.export',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Invitee Submission Vn Table',
        'flag' => 'inviteevn.registration.index',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Invitee Submission Vn Delete',
        'flag' => 'inviteevn.registration.delete',
        'parent_flag' => 'registration.index',
    ],
    [
        'name' => 'Invitee Submission Vn Export',
        'flag' => 'inviteevn.registration.export',
        'parent_flag' => 'registration.index',
    ],



    // [
    //     'name' => 'Subscribe',
    //     'flag' => 'registration.subscribe',
    //     'parent_flag' => 'registration.subscribe',
    // ],
    // [
    //     'name' => 'Mời tính điểm Abstract',
    //     'flag' => 'registration.abstract.invite-calculate-score',
    //     'parent_flag' => 'registration.index',
    // ],


];
