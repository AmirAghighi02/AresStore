<?php

namespace App\Enums;

use App\Contracts\EnumHelpersContract;
use App\Traits\HasEnumHelpers;

enum Permissions: string implements EnumHelpersContract
{
    use HasEnumHelpers;

    case ACCESS_MANAGE = 'access.*';
    case USER_MANAGE = 'user.*';
    case PRODUCT_MANAGE = 'product.*';
    case WALLET_MANAGE = 'wallet.*';
    case ORDER_MANAGE = 'order.*';
    case ADDRESS_MANAGE = 'address.*';
    case CART_MANAGE = 'cart.*';

    case USER_VIEW = 'user.view';
    case USER_ADD = 'user.add';
    case USER_DELETE = 'user.delete';
    case USER_EDIT = 'user.edit';
    case USER_CONFIRM = 'user.confirm';

    case PRODUCT_VIEW = 'product.view';
    case PRODUCT_CREATE = 'product.create';
    case PRODUCT_DELETE = 'product.delete';
    case PRODUCT_EDIT = 'product.edit';

    case WALLET_BLOCK = 'wallet.block';
    case WALLET_VIEW = 'wallet.view';

    case ORDER_CANCEL = 'order.cancel';
    case ORDER_DELETE = 'order.delete';
    case ORDER_VIEW = 'order.view';
    case ORDER_EDIT = 'order.edit';
    case ORDER_CREATE = 'order.create';

    case ADDRESS_VIEW = 'address.view';
    case ADDRESS_EDIT = 'address.edit';
    case ADDRESS_CREATE = 'address.create';
    case ADDRESS_DELETE = 'address.delete';

    case CART_VIEW = 'cart.view';
    case CART_VIEW_SELF = 'cart.view_self';
    case CART_DELETE = 'cart.delete';
    case CART_ADD_ITEM = 'cart.add_item';
    case CART_ADD_ITEM_SELF = 'cart.add_item_self';
    case CART_DELETE_ITEM = 'cart.delete_item';
    case CART_DELETE_ITEM_SELF = 'cart.delete_item_self';

    case USER_SELF_EDIT = 'user.self_edit';
    case USER_SELF_DELETE = 'user.self_delete';

    case PRODUCT_SELF_EDIT = 'product.self_edit';
    case PRODUCT_SELF_DELETE = 'product.self_delete';
    case PRODUCT_SELF_VIEW_ANY = 'product.self_view_any';

    case WALLET_SELF_WITHDRAW = 'wallet.self_withdraw';
    case WALLET_SELF_CHARGE = 'wallet.self_charge';

    case ORDER_SELF_EDIT = 'order.self_edit';
    case ORDER_SELF_DELETE = 'order.self_delete';
    case ORDER_SELF_CANCEL = 'order.self_cancel';

    case ADDRESS_SELF_EDIT = 'address.self_edit';
    case ADDRESS_SELF_DELETE = 'address.self_delete';

    /**
     * @return array<int, self>
     */
    public static function adminPermissions(): array
    {
        return [
            self::USER_MANAGE,
            self::PRODUCT_MANAGE,
            self::WALLET_MANAGE,
            self::ORDER_MANAGE,
            self::ADDRESS_MANAGE,
            self::CART_MANAGE,
        ];
    }

    /**
     * @return array<int, self>
     */
    public static function superAdminPermissions(): array
    {
        $admin_permissions = self::adminPermissions();

        return array_merge($admin_permissions, [
            self::ACCESS_MANAGE,
        ]);
    }

    /**
     * @return array<int, self>
     */
    public static function costumerPermissions(): array
    {
        return [
            self::PRODUCT_VIEW,
            self::ORDER_CREATE,
            self::WALLET_SELF_CHARGE,
            self::WALLET_SELF_WITHDRAW,
            self::ORDER_SELF_EDIT,
            self::ORDER_SELF_DELETE,
            self::USER_SELF_EDIT,
            self::USER_SELF_DELETE,
            self::ADDRESS_SELF_DELETE,
            self::ADDRESS_SELF_EDIT,
            self::ADDRESS_CREATE,
            self::CART_VIEW_SELF,
            self::CART_ADD_ITEM_SELF,
            self::CART_DELETE_ITEM_SELF,
        ];
    }

    /**
     * @return array<int, self>
     */
    public static function sellerPermissions(): array
    {
        $user_permissions = self::costumerPermissions();

        return array_merge($user_permissions, [
            self::PRODUCT_CREATE,
            self::PRODUCT_SELF_EDIT,
            self::PRODUCT_SELF_DELETE,
            self::PRODUCT_SELF_VIEW_ANY,
        ]);
    }
}
