<?php

namespace Modules\Menu\Policies;

use Modules\Menu\Entities\Categories;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriesPolicy
{
    use HandlesAuthorization;

   public function view(User $user, Categories $categories)
    {
        //
    }

    public function create(User $user)
    {
        return $user->hasAccess(['menu.create']);
    }

    public function update(User $user, Categories $categories)
    {
        return $user->hasAccess(['menu.update']) or $userGroup->id == $categories->user_id;
    }

    public function delete(User $user, Categories $categories)
    {
        //
    }

    public function publish(User $user)
    {
        return $user->hasAccess(['menu.publish']);
    }

    public function draft(User $user)
    {
        return $user->inRole('editor');
    }
}
