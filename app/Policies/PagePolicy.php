<?php

namespace App\Policies;

use App\Models\About;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any pages.
     *
     * @param  \App\User  $user
     * @return mixed
     */


    /**
     * Determine whether the user can view the page.
     *
     * @param  \App\User  $user
     * @param  \App\ModelsAbout  $page
     * @return mixed
     */
    public function view(User $user, About $page)
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
        //
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  \App\User  $user
     * @param  \App\Models\About  $page
     * @return mixed
     */
    public function update(User $user, About $page)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param  \App\User  $user
     * @param  \App\Models\About  $page
     * @return mixed
     */
    public function delete(User $user, About $page)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the page.
     *
     * @param  \App\User  $user
     * @param  \App\Models\About  $page
     * @return mixed
     */
    public function restore(User $user, About $page)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the page.
     *
     * @param  \App\User  $user
     * @param  \App\Models\About  $page
     * @return mixed
     */
    public function forceDelete(User $user, About $page)
    {

    }
}
