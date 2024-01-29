<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\Remark;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InquiryPolicy
{
    use HandlesAuthorization;

    public function add(User $user ,Inquiry $inquiry){
        return $inquiry->remarks()->count() == 1;
    }
}
