<?php namespace LukeTowers\MenuChangerExample;

use Event;
use Backend;
use BackendMenu;
use Backend\Controllers\Users as UsersController;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * UserMenu Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Menu Changer Example',
            'description' => "Example plugin to demonstrate how to change a controller's backend menu location",
            'author'      => 'LukeTowers',
            'icon'        => 'icon-user'
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'users' => [
                'label'       => 'backend::lang.user.menu_label',
                'url'         => Backend::url('backend/users'),
                'icon'        => 'icon-user',
                'permissions' => ['backend.manage_users'],
            ],
        ];
    }

    public function boot()
    {
        Event::listen('backend.page.beforeDisplay', function ($controller, $action, $params) {
            if (!($controller instanceof UsersController)) {
                return;
            }

            BackendMenu::setContext('LukeTowers.MenuChangerExample', 'users');
        });

        SettingsManager::instance()->registerCallback(function ($manager) {
            $manager->removeSettingItem('October.System', 'administrators');
        });
    }
}
