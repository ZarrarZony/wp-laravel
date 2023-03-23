<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'blog-list',
           'blog-create',
           'blog-edit',
           'blog-delete',
           'banner-list',
           'banner-create',
           'banner-edit',
           'banner-delete',
           'coupons-list',
           'coupons-create',
           'coupons-edit',
           'coupons-delete',
           'page-list',
           'page-create',
           'page-edit',
           'page-delete',
           'store-list',
           'store-create',
           'store-edit',
           'store-delete',
           'sites-list',
           'sites-create',
           'sites-edit',
           'sites-delete',
           'social-list',
           'social-create',
           'social-edit',
           'social-delete',
           'footer-list',
           'footer-create',
           'footer-edit',
           'footer-delete',
           'menu-list',
           'menu-create',
           'menu-edit',
           'menu-delete'
        ];


        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}