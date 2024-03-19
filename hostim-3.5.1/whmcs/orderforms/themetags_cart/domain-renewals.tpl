{include file="orderforms/themetags_cart/common.tpl"}

<div id="order-standard_cart">
    <div class="row">
        <div class="cart-sidebar">
            {include file="orderforms/themetags_cart/sidebar-categories.tpl"}
        </div>
        <div class="cart-body">
            <div class="header-lined">
                <h2 class="font-size-22">
                    {if $totalResults > 1}{lang key='domainrenewals'}{else}{lang key='domainrenewal'}{/if}
                    {if $totalResults > 5}
                        <div class="pull-right float-right">
                            <input id="domainRenewalFilter" type="search" class="domain-renewals-filter form-control input-inline-100" placeholder="{lang key='searchenterdomain'}">
                        </div>
                    {/if}
                </h2>
            </div>
            {include file="orderforms/themetags_cart/sidebar-categories-collapsed.tpl"}

            {if $totalDomainCount == 0}
                <div id="no-domains" class="alert alert-warning text-center" role="alert">
                    {$LANG.domainRenewal.noDomains}
                </div>
                <p class="text-center">
                    <a href="{$WEB_ROOT}/clientarea.php" class="btn btn-default">
                        <i class="fas fa-arrow-circle-left"></i>
                        {$LANG.orderForm.returnToClientArea}
                    </a>
                </p>
            {else}
                <div class="row">

                    <div class="secondary-cart-body">
                        {if $totalResults < $totalDomainCount}
                            <div class="text-center">
                                {lang key='domainRenewal.showingDomains' showing=$totalResults totalCount=$totalDomainCount}
                                <a id="linkShowAll" href="{routePath('cart-domain-renewals')}">{lang key='domainRenewal.showAll'}</a>
                            </div>
                        {/if}

                        <div id="domainRenewals" class="domain-renewals tt-domain-renewals">
                            {foreach $renewalsData as $renewalData}
                                <div class="domain-renewal" data-domain="{$renewalData.domain}">
                                    <div class="pull-right float-right">
                                        {if !$renewalData.eligibleForRenewal}
                                            <span class="label label-info">
                                                {if $renewalData.freeDomainRenewal}
                                                    {lang key='domainRenewal.freeWithService'}
                                                {else}
                                                    {lang key='domainRenewal.unavailable'}
                                                {/if}
                                            </span>
                                        {elseif ($renewalData.pastGracePeriod && $renewalData.pastRedemptionGracePeriod)}
                                            <span class="label label-info">
                                                {lang key='domainrenewalspastgraceperiod'}
                                            </span>
                                        {elseif !$renewalData.beforeRenewLimit && $renewalData.daysUntilExpiry > 0}
                                            <span class="label label-{if $renewalData.daysUntilExpiry > 30}success{else}warning{/if}">
                                                {lang key='domainRenewal.expiringIn' days=$renewalData.daysUntilExpiry}
                                            </span>
                                        {elseif $renewalData.daysUntilExpiry === 0}
                                            <span class="label label-grey">
                                                {lang key='expiresToday'}
                                            </span>
                                        {elseif $renewalData.beforeRenewLimit}
                                            <span class="label label-info">
                                                {lang key='domainRenewal.maximumAdvanceRenewal' days=$renewalData.beforeRenewLimitDays}
                                            </span>
                                        {else}
                                            <span class="label label-danger">
                                                {lang key='domainRenewal.expiredDaysAgo' days=$renewalData.daysUntilExpiry*-1}
                                            </span>
                                        {/if}
                                    </div>

                                    <h3 class="font-size-18">{$renewalData.domain}</h3>

                                    <p class="text-muted small mb-1">{lang key='clientareadomainexpirydate'}: {$renewalData.expiryDate->format('j M Y')} ({$renewalData.expiryDate->diffForHumans()})</p>
                                    {if $renewalData.freeDomainRenewal}
                                        <p class="domain-renewal-desc">{lang key='domainRenewal.freeWithServiceDesc'}</p>
                                    {/if}

                                    {if ($renewalData.pastGracePeriod && $renewalData.pastRedemptionGracePeriod) || !count($renewalData.renewalOptions)}
                                    {else}
                                        <form class="form-horizontal tt-renewal-form">
                                            <div class="form-group mb-0">
                                                <label for="renewalPricing{$renewalData.id}" class="control-label">
                                                    {lang key='domainRenewal.availablePeriods'}
                                                    {if $renewalData.inGracePeriod || $renewalData.inRedemptionGracePeriod}
                                                        *
                                                    {/if}
                                                </label>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <select class="form-control select-renewal-pricing" id="renewalPricing{$renewalData.id}" data-domain-id="{$renewalData.id}">
                                                        {foreach $renewalData.renewalOptions as $renewalOption}
                                                            <option value="{$renewalOption.period}">
                                                                {$renewalOption.period} {lang key='orderyears'} @ {$renewalOption.rawRenewalPrice}
                                                                {if $renewalOption.gracePeriodFee && $renewalOption.gracePeriodFee->toNumeric() != 0.00}
                                                                    + {$renewalOption.gracePeriodFee} {lang key='domainRenewal.graceFee'}
                                                                {/if}
                                                                {if $renewalOption.redemptionGracePeriodFee && $renewalOption.redemptionGracePeriodFee->toNumeric() != 0.00}
                                                                    + {$renewalOption.redemptionGracePeriodFee} {lang key='domainRenewal.redemptionFee'}
                                                                {/if}
                                                            </option>
                                                        {/foreach}
                                                    </select>
                                                    <div class="tt-renewal-cart">
                                                        {if !$renewalData.eligibleForRenewal || $renewalData.beforeRenewLimit || ($renewalData.pastGracePeriod && $renewalData.pastRedemptionGracePeriod)}
                                                        {else}
                                                            <button id="renewDomain{$renewalData.id}" class="btn btn-default btn-sm btn-add-renewal-to-cart" data-domain-id="{$renewalData.id}">
                                                                <span class="to-add">
                                                                    <i class="fas fa-fw fa-spinner fa-spin"></i>
                                                                    {lang key='addtocart'}
                                                                </span>
                                                                <span class="added">{lang key='domaincheckeradded'}</span>
                                                            </button>
                                                        {/if}
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    {/if}
                                </div>
                            {/foreach}
                        </div>

                        <div class="text-center">
                            <small>
                                {if $hasDomainsInGracePeriod}
                                    * {lang key='domainRenewal.graceRenewalPeriodDescription'}
                                {/if}
                            </small>
                        </div>
                    </div>

                    <div class="secondary-cart-sidebar" id="scrollingPanelContainer">

                        <div id="orderSummary">
                            <div class="order-summary">
                                <div class="loader" id="orderSummaryLoader">
                                    <i class="fas fa-fw fa-sync fa-spin"></i>
                                </div>
                                <h2 class="font-size-30">{lang key='ordersummary'}</h2>

                                <div class="summary-container">
                                    <div id="producttotal"></div>
                                    <div class="text-center mt-3">
                                        <a id="btnGoToCart" class="btn btn-primary btn-block" href="{$WEB_ROOT}/cart.php?a=view">
                                            {lang key='viewcart'}
                                            <i class="fad fa-long-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            {/if}
        </div>
    </div>
    <form id="removeRenewalForm" method="post" action="{$WEB_ROOT}/cart.php">
        <input type="hidden" name="a" value="remove" />
        <input type="hidden" name="r" value="" id="inputRemoveItemType" />
        <input type="hidden" name="i" value="" id="inputRemoveItemRef" />
        <div class="modal fade modal-remove-item" id="modalRemoveItem" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="float-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="{lang key='orderForm.close'}">
                                <span aria-hidden="true"><i class="far fa-times-circle text-danger"></i></span>
                            </button>
                        </div>
                        <h5 class="modal-title margin-bottom my-3 text-danger">
                            <i class="fad fa-trash-alt fa-3x"></i>
                            <span>{lang key='orderForm.removeItem'}</span>
                        </h5>

                        {lang key='cartremoveitemconfirm'}
                    </div>
                    <div class="modal-footer d-block">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{lang key='no'}</button>
                        <button type="submit" class="btn btn-primary">{lang key='yes'}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>recalculateRenewalTotals();</script>
