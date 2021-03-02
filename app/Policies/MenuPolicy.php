<?php

namespace App\Policies;


use Infinety\MenuBuilder\Http\Models\Menu;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user, Menu $page)
    {
        return true;
    }

    /**
     * Determine whether the user can create pages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, Menu $page)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, Menu $page)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user, Menu $page)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the page.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $user, Menu $page)
    {

    }
}
