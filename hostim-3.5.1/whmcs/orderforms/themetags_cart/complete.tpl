{include file="orderforms/themetags_cart/common.tpl"}

<div id="order-standard_cart">

    <div class="row">
        <div class="cart-sidebar">
            {include file="orderforms/themetags_cart/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-22">{$LANG.orderconfirmation}</h2>
            </div>
            {include file="orderforms/themetags_cart/sidebar-categories-collapsed.tpl"}

            <p>{$LANG.orderreceived}</p>

            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info text-left order-confirmation">
                        {$LANG.ordernumberis} <strong>{$ordernumber}</strong>
                    </div>
                </div>
            </div>

            <p>{$LANG.orderfinalinstructions}</p>

            {if $expressCheckoutInfo}
                <div class="alert alert-info">
                    {$expressCheckoutInfo}
                </div>
            {elseif $expressCheckoutError}
                <div class="alert alert-danger">
                    {$expressCheckoutError}
                </div>
            {elseif $invoiceid && !$ispaid}
                <div class="alert alert-warning">
                    {$LANG.ordercompletebutnotpaid}
                    <br /><br />
                    <a href="{$WEB_ROOT}/viewinvoice.php?id={$invoiceid}" target="_blank" class="alert-link">
                        {$LANG.invoicenumber}{$invoiceid}
                    </a>
                </div>
            {/if}

            {foreach $addons_html as $addon_html}
                <div class="order-confirmation-addon-output">
                    {$addon_html}
                </div>
            {/foreach}

            {if $ispaid}
                <!-- Enter any HTML code which should be displayed when a user has completed checkout here -->
                <!-- Common uses of this include conversion and affiliate tracking scripts -->
            {/if}

            <div class="text-left mt-4">
                <a href="{$WEB_ROOT}/clientarea.php" class="btn btn-default">
                    {$LANG.orderForm.continueToClientArea}
                    &nbsp;<i class="fad fa-long-arrow-right"></i>
                </a>
            </div>

            {if $hasRecommendations}
                {include file="orderforms/themetags_cart/includes/product-recommendations.tpl"}
            {/if}
        </div>
    </div>
</div>
