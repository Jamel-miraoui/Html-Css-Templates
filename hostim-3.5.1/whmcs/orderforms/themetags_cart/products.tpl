{include file="orderforms/themetags_cart/common.tpl"}

<div id="order-standard_cart">
    <div class="row">
        <div class="cart-sidebar sidebar">
            {include file="orderforms/themetags_cart/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-22">
                    {if $productGroup.headline}
                        {$productGroup.headline}
                    {else}
                        {$productGroup.name}
                    {/if}
                </h2>
                {if $productGroup.tagline}
                    <p>{$productGroup.tagline}</p>
                {/if}
            </div>
            {if $errormessage}
                <div class="alert alert-danger">
                    {$errormessage}
                </div>
            {elseif !$productGroup}
                <div class="alert alert-info">
                    {lang key='orderForm.selectCategory'}
                </div>
            {/if}

            {include file="orderforms/themetags_cart/sidebar-categories-collapsed.tpl"}

            <div class="products" id="products">
                <div class="row row-eq-height">
                    {foreach $products as $key => $product}
                        {$idPrefix = ($product.bid) ? ("bundle"|cat:$product.bid) : ("product"|cat:$product.pid)}
                    <div class="col-md-6 col-lg-4">
                        <div class="tt-single-product text-center px-3 py-5 my-3 tt-custom-radius clearfix" id="{$idPrefix}">
                            {if $product.isFeatured}
                                <div class="tt-featured-badge">
                                    <span class="badge">{$LANG.featuredProduct|upper}</span>
                                </div>
                            {/if}
                            <div class="tt-product-name">
                                <h5 id="{$idPrefix}-name">{$product.name}</h5>
                            </div>
                            <div class="product-pricing tt-product-price mt-3" id="{$idPrefix}-price">
                                <span class="tt-cycle d-block text-muted">
                                    {if $product.bid}
                                        {$LANG.bundledeal}<br />
                                        {if $product.displayprice}
                                            <span class="price">{$product.displayprice}</span>
                                        {/if}
                                    {else}
                                    {if $product.pricing.hasconfigoptions}
                                        {$LANG.startingfrom}
                                        <br />
                                    {/if}
                                </span>
                                    <span class="price">{$product.pricing.minprice.price}</span>
                                    <br />
                                    <span class="text-muted mb-0 tt-cycle">
                                        {if $product.paytype eq "free"}
                                            {$LANG.freeText}
                                        {elseif $product.paytype eq "onetime"}
                                            {$LANG.oneTimeText}
                                        {else}
                                            {if $product.pricing.minprice.cycle eq "monthly"}
                                                {$LANG.orderpaymenttermmonthly}
                                            {elseif $product.pricing.minprice.cycle eq "quarterly"}
                                                {$LANG.orderpaymenttermquarterly}
                                            {elseif $product.pricing.minprice.cycle eq "semiannually"}
                                                {$LANG.orderpaymenttermsemiannually}
                                            {elseif $product.pricing.minprice.cycle eq "annually"}
                                                {$LANG.orderpaymenttermannually}
                                            {elseif $product.pricing.minprice.cycle eq "biennially"}
                                                {$LANG.orderpaymenttermbiennially}
                                            {elseif $product.pricing.minprice.cycle eq "triennially"}
                                                {$LANG.orderpaymenttermtriennially}
                                            {/if}
                                        {/if}
                                    </span>
                                    <br>
                                    {if $product.pricing.minprice.setupFee}
                                        <small class="text-muted d-inline-block bg-primary-light px-2 rounded mt-2"><strong>{$product.pricing.minprice.setupFee->toPrefixed()}</strong> {$LANG.ordersetupfee}</small>
                                    {/if}
                                {/if}
                            </div>
                            <div>
                                {if $product.stockControlEnabled}
                                    <span class="qty text-muted small">
                                        {$product.qty} {$LANG.orderavailable}
                                    </span>
                                {/if}
                            </div>
                            <div class="product-desc py-3 tt-product-desc">
                                {if $product.featuresdesc}
                                    <div id="{$idPrefix}-description">
                                        {$product.featuresdesc}
                                    </div>
                                {/if}
                                <ul class="mb-0">
                                    {foreach $product.features as $feature => $value}
                                        <li id="{$idPrefix}-feature{$value@iteration}">
                                            <span class="feature-value">{$value}</span>
                                            {$feature}
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                            <a href="{$product.productUrl}" class="btn btn-primary btn-order-now" id="{$idPrefix}-order-button"{if $product.hasRecommendations} data-has-recommendations="1"{/if}>
                                {$LANG.ordernowbutton}
                            </a>
                        </div>
                    </div>
                    {if $product@iteration % 3 == 0}
                </div>
                <div class="row row-eq-height">
                    {/if}
                    {/foreach}
                </div>
            </div>

            {*product group featured start*}
            {if count($productGroup.features) > 0}
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="tt-group-featured-wrap tt-custom-radius mt-4">
                            <h6 class="tt-group-head">
                                {$LANG.orderForm.includedWithPlans}
                            </h6>
                            <ul class="tt-group-features-list list-unstyled mb-0">
                                {foreach $productGroup.features as $features}
                                    <li><i class="fad fa-check"></i>{$features.feature}</li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
            {/if}
            {*product group featured end*}

            {if $group_product_feature_link}
                {include file="orderforms/themetags_cart/{$group_product_feature_link}"}
            {/if}

        </div>
    </div>
</div>

{include file="orderforms/themetags_cart/recommendations-modal.tpl"}
