<?php

namespace App\Support\Sidebar;

use App\Support\Sidebar\Components\SidebarGenerator;
use App\Support\Sidebar\Components\SidebarLink;
use App\Support\Sidebar\Components\SidebarMenu;
use function route;

class Sidebar
{
    public function dashboard()
    {

        return [
            SidebarLink::to(
                t_('dashboard'),
                route('dashboard.home'),
                'las la-tachometer-alt  text-secondary',
                'line-awesome'
            ),
        ];
    }

    public function core()
    {
        $adminList = [
            SidebarLink::to(t_('admins'), route('dashboard.core.administration.admins.index')),
            SidebarLink::to(t_('roles'), route('dashboard.core.administration.roles.index')),
        ];

        return [
            SidebarMenu::create(t_('administration'), 'las la-users text-secondary', permission: '')
                ->push($adminList),
            SidebarLink::to(
                t_('Pages'),
                route('dashboard.core.pages.index'),
                'las la-file-alt text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('Faqs'),
                route('dashboard.core.faqs.index'),
                'las la-file-alt text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('Areas'),
                route('dashboard.core.areas.index'),
                'las la-globe text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('translation'),
                route('modules.translation.dashboard.index'),
                'las la-language text-secondary',
                'line-awesome'
            ),

            SidebarLink::to(
                t_('Photo Gallery'),
                route('dashboard.core.galleries.index'),
                'las la-images text-secondary',
                'line-awesome'
            ),
            SidebarLink::to(
                t_('Contacts'),
                route('dashboard.core.contacts.index'),
                'las la-phone text-secondary',
                'line-awesome'
            ),

            SidebarLink::to(
                t_('Setting'),
                route('dashboard.setting.index'),
                'las la-cogs text-secondary',
                'line-awesome'
            ),


        ];
    }

    public function categories()
    {

        $productList = [

            SidebarLink::to(t_('categories'), route('dashboard.core.categories.index')),
        ];

        return [

            SidebarMenu::create(t_('categories'), 'las  la-boxes text-secondary', permission: '')
                ->push($productList),

        ];
    }
    public function posts()
    {

        $productList = [

            SidebarLink::to(t_('posts'), route('dashboard.post.posts.index')),
        ];

        return [

            SidebarMenu::create(t_('posts'), 'las  la-boxes text-secondary', permission: '')
                ->push($productList),

        ];
    }

    public function user()
    {
        $adminList = [
            SidebarLink::to(t_('users'), route('dashboard.user.users.index')),
        ];

        return [
            SidebarMenu::create(t_('users'), 'las la-users text-secondary', permission: '')
                ->push($adminList),
        ];
    }
    public function __invoke()
    {
        $generator = SidebarGenerator::create();

        if (activeGuard('dashboard')) {
            $generator->addModule(t_('dashboard'), 'icon-home', false)->push($this->dashboard());
            $generator->addModule(t_('core'), 'icon-home')->push($this->core());
            $generator->addModule(t_('users'), 'icon-home')->push($this->user());
            $generator->addModule(t_('categories'), 'icon-home')->push($this->categories());
            $generator->addModule(t_('posts'), 'icon-home')->push($this->posts());
         }



        return $generator->toArray();
    }
}
