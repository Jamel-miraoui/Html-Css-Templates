{include file="orderforms/themetags_cart/common.tpl"}

<div id="order-standard_cart">

    <div class="row">
        <div class="cart-sidebar">

            {include file="orderforms/themetags_cart/sidebar-categories.tpl"}

        </div>
        <div class="cart-body">

            <div class="header-lined">
                <h2 class="font-size-22">{$LANG.cartproductaddons}</h2>
            </div>
            {include file="orderforms/themetags_cart/sidebar-categories-collapsed.tpl"}

            {if count($addons) == 0}
                <div id="noAddons" class="alert alert-warning text-center" role="alert">
                    {$LANG.cartproductaddonsnone}
                </div>
                <p class="text-center">
                    <a href="{$WEB_ROOT}/clientarea.php" class="btn btn-default">
                        <i class="fas fa-arrow-circle-left"></i>
                        {$LANG.orderForm.returnToClientArea}
                    </a>
                </p>
            {/if}

            <div class="products">
                <div class="row row-eq-height">
                    {foreach $addons as $num => $addon}
                    <div class="col-md-6">
                        <div class="product tt-rounded tt-product-addons" id="product{$num}">
                            <form method="post" action="{$smarty.server.PHP_SELF}?a=add" class="form-inline">
                                <input type="hidden" name="aid" value="{$addon.id}" />
                                <h6 class="mb-3 w-100">{$addon.name}</h6>
                                <div class="product-desc product-desc-full-width w-100 mb-2">
                                    <p>{$addon.description|nl2br}</p>
                                </div>

                                <div class="mt-auto w-100">
                                    <div class="form-group mb-3">
                                        <select name="productid" id="inputProductId{$num}" class="field form-control">
                                            {foreach $addon.productids as $product}
                                                <option value="{$product.id}">
                                                    {$product.product}{if $product.domain} - {$product.domain}{/if}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                   <div class="d-flex align-items-center justify-content-between">
                                       <div class="product-pricing">
                                           {if $addon.free}
                                               {$LANG.orderfree}
                                           {else}
                                               <span class="price">{$addon.recurringamount} <small>{$addon.billingcycle}</small></span>
                                               {if $addon.setupfee}<br />+ {$addon.setupfee} {$LANG.ordersetupfee}{/if}
                                           {/if}
                                       </div>
                                       <button type="submit" class="btn btn-primary">
                                           {$LANG.ordernowbutton}
                                       </button>
                                   </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {if $num % 2 != 0}
                </div>
                <div class="row row-eq-height">
                    {/if}
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
