<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Permission::query()->insert([

            /*
            Category Permissions
            */

            [
                'title' => 'view-category',
                'path' => 'دیدن دسته بندی'
            ] ,

            [
                'title' => 'create-category',
                'path' => 'ایجاد دسته بندی'
            ] ,

            [
                'title' => 'update-category',
                'path' => 'ویرایش دسته بندی'
            ] ,

            [
                'title' => 'delete-category',
                'path' => 'حذف دسته بندی'
            ] ,


            /*
            blog Permissions
            */

            [
                'title' => 'view-blog',
                'path' => 'دیدن بلاگ'
            ] ,

            [
                'title' => 'create-blog',
                'path' => 'ایجاد بلاگ'
            ] ,

            [
                'title' => 'update-blog',
                'path' => 'ویرایش بلاگ'
            ] ,

            [
                'title' => 'delete-blog',
                'path' => 'حذف بلاگ'
            ] ,

            /*
            comment Permissions
            */

            [
                'title' => 'view-comment',
                'path' => 'دیدن کامنت'
            ] ,

            [
                'title' => 'create-comment',
                'path' => 'ایجاد کامنت'
            ] ,

            [
                'title' => 'update-comment',
                'path' => 'ویرایش کامنت'
            ] ,

            [
                'title' => 'delete-comment',
                'path' => 'حذف کامنت'
            ] ,

            /*
            coupon Permissions
            */

            [
                'title' => 'view-coupon',
                'path' => 'دیدن کد تخفیف'
            ] ,

            [
                'title' => 'create-coupon',
                'path' => 'ایجاد کد تخفیف'
            ] ,

            [
                'title' => 'update-coupon',
                'path' => 'ویرایش کد تخفیف'
            ] ,

            [
                'title' => 'delete-coupon',
                'path' => 'حذف کد تخفیف'
            ] ,

            /*
            discount Permissions
            */

            [
                'title' => 'view-discount',
                'path' => 'دیدن تخفیف'
            ] ,

            [
                'title' => 'create-discount',
                'path' => 'ایجاد تخفیف'
            ] ,

            [
                'title' => 'update-discount',
                'path' => 'ویرایش تخفیف'
            ] ,

            [
                'title' => 'delete-discount',
                'path' => 'حذف تخفیف'
            ] ,

            /*
            gallery Permissions
            */

            [
                'title' => 'view-gallery',
                'path' => 'دیدن گالری'
            ] ,

            [
                'title' => 'create-gallery',
                'path' => 'ایجاد گالری'
            ] ,

            [
                'title' => 'update-gallery',
                'path' => 'ویرایش گالری'
            ] ,

            [
                'title' => 'delete-gallery',
                'path' => 'حذف گالری'
            ] ,

            /*
            ip Permissions
            */

            [
                'title' => 'create-ip',
                'path' => 'ایجاد ای پی'
            ] ,

            [
                'title' => 'update-ip',
                'path' => 'ویرایش ای پی'
            ] ,

            [
                'title' => 'delete-ip',
                'path' => 'حذف ای پی'
            ] ,

            /*
            order Permissions
            */

            [
                'title' => 'view-order',
                'path' => 'دیدن سفارشات'
            ] ,

            [
                'title' => 'create-order',
                'path' => 'ایجاد سفارش'
            ] ,

            [
                'title' => 'update-order',
                'path' => 'ویرایش سفارشات'
            ] ,

            [
                'title' => 'delete-order',
                'path' => 'حذف سفارشات'
            ] ,

            /*
            product Permissions
            */

            [
                'title' => 'view-product',
                'path' => 'دیدن محصول'
            ] ,

            [
                'title' => 'create-product',
                'path' => 'ایجاد محصول'
            ] ,

            [
                'title' => 'update-product',
                'path' => 'ویرایش محصول'
            ] ,

            [
                'title' => 'delete-product',
                'path' => 'حذف محصول'
            ] ,

            /*
            project Permissions
            */

            [
                'title' => 'view-project',
                'path' => 'دیدن پروژه'
            ] ,

            [
                'title' => 'create-project',
                'path' => 'ایجاد پروژه'
            ] ,

            [
                'title' => 'update-project',
                'path' => 'ویرایش پروژه'
            ] ,

            [
                'title' => 'delete-project',
                'path' => 'حذف پروژه'
            ] ,

            /*
            recruitment Permissions
            */

            [
                'title' => 'view-recruitment',
                'path' => 'دیدن استخدامی ها'
            ] ,

            [
                'title' => 'update-recruitment',
                'path' => 'ویرایش استخدامی ها'
            ] ,

            [
                'title' => 'delete-recruitment',
                'path' => 'حذف استخدامی ها'
            ] ,

            /*
            report Permissions
            */

            [
                'title' => 'view-report',
                'path' => 'دیدن گزارش کار'
            ] ,

            [
                'title' => 'create-report',
                'path' => 'ایجاد گزارش کار'
            ] ,

            [
                'title' => 'update-report',
                'path' => 'ویرایش گزارش کار'
            ] ,

            [
                'title' => 'delete-report',
                'path' => 'حذف گزارش کار'
            ] ,

            /*
            seller Permissions
            */

            [
                'title' => 'view-seller',
                'path' => 'دیدن فروشنده'
            ] ,

            [
                'title' => 'create-seller',
                'path' => 'ایجاد فروشنده'
            ] ,

            [
                'title' => 'update-seller',
                'path' => 'ویرایش فروشنده'
            ] ,

            [
                'title' => 'delete-seller',
                'path' => 'حذف فروشنده'
            ] ,

            /*
            service Permissions
            */

            [
                'title' => 'view-service',
                'path' => 'دیدن خدمات'
            ] ,

            [
                'title' => 'create-service',
                'path' => 'ایجاد خدمات'
            ] ,

            [
                'title' => 'update-service',
                'path' => 'ویرایش خدمات'
            ] ,

            [
                'title' => 'delete-service',
                'path' => 'حذف خدمات'
            ] ,

            /*
            service-group Permissions
            */

            [
                'title' => 'view-service-group',
                'path' => 'دیدن گروه خدمات'
            ] ,

            [
                'title' => 'create-service-group',
                'path' => 'ایجاد گروه خدمات'
            ] ,

            [
                'title' => 'update-service-group',
                'path' => 'ویرایش گروه خدمات'
            ] ,

            [
                'title' => 'delete-service-group',
                'path' => 'حذف گروه خدمات'
            ] ,

            /*
            ticket Permissions
            */

            [
                'title' => 'view-ticket',
                'path' => 'دیدن تیکت'
            ] ,

            [
                'title' => 'create-ticket',
                'path' => 'ایجاد تیکت'
            ] ,

            [
                'title' => 'update-ticket',
                'path' => 'ویرایش تیکت'
            ] ,

            [
                'title' => 'delete-ticket',
                'path' => 'حذف تیکت'
            ] ,

            /*
            user Permissions
            */

            [
                'title' => 'view-user',
                'path' => 'دیدن کاربر'
            ] ,

            [
                'title' => 'create-user',
                'path' => 'ایجاد کاربر'
            ] ,

            [
                'title' => 'update-user',
                'path' => 'ویرایش کاربر'
            ] ,

            [
                'title' => 'delete-user',
                'path' => 'حذف کاربر'
            ] ,

            /*
            work-sample Permissions
            */

            [
                'title' => 'view-work-sample',
                'path' => 'دیدن نمونه کار'
            ] ,

            [
                'title' => 'create-work-sample',
                'path' => 'ایجاد نمونه کار'
            ] ,

            [
                'title' => 'update-work-sample',
                'path' => 'ویرایش نمونه کار'
            ] ,

            [
                'title' => 'delete-work-sample',
                'path' => 'حذف نمونه کار'
            ] ,


        ]);
    }
}
