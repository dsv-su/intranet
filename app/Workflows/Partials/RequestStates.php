<?php

namespace App\Workflows\Partials;

class RequestStates
{
    const MANAGER = 'manager';
    const UNIT_HEAD = 'head';
    const FINACIAL_OFFICER = 'fo';
    const MANAGER_APPROVED = 'manager_approved';
    const MANAGER_RETURNED = 'manager_returned';
    const MANAGER_DENIED = 'manager_denied';
    const HEAD_APPROVED = 'head_approved';
    const HEAD_RETURNED = 'head_returned';
    const HEAD_DENIED = 'head_denied';
    const FO_APPROVED = 'fo_approved';
    const FO_RETURNED = 'fo_returned';
    const FO_DENIED = 'fo_denied';
}
