<div class="" id="test_payment_method">
	<div class="container">
        <div class="row">
            <div class="col-6 offset-3 border mt-5 p-3" id="form_payment">
                {if $payment}
                <h3 class="text-center text-{$statusLabel.class}">{$statusLabel.label}</h3>
                <hr>
                <h3 class="text-center">Chi tiết giao dịch</h3>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td width="30%">Payment No</td>
                            <td>{$payment_no}</td>
                        </tr>
                        <tr>
                            <td width="30%">Invoice No</td>
                            <td>{$invoice_no}</td>
                        </tr>
                        <tr>
                            <td width="30%">Amount</td>
                            <td>{$clsISO->formatPrice($amount)} {$currency}</td>
                        </tr>
                        <tr>
                            <td width="30%">Method</td>
                            <td>{$method}</td>
                        </tr>
                        {if $card_brand}
                        <tr>
                            <td width="30%">Bank</td>
                            <td>{$card_brand}</td>
                        </tr>
                        {/if}
                        {if $card_name}
                        <tr>
                            <td width="30%">Card Name</td>
                            <td>{$card_name}</td>
                        </tr>
                        {/if}
                        {if $card_number}
                        <tr>
                            <td width="30%">Card Number</td>
                            <td>{$card_number}</td>
                        </tr>
                        {/if}
                        {if $failure_reason}
                            <tr>
                                <td width="30%">Failure Reason</td>
                                <td>{$failure_reason}</td>
                            </tr>
                        {/if}
                    </tbody>
                </table>
                {else}
                <p class="text-center text-danger">Không tìm thấy thông tin giao dịch</p>
                {/if}

                <div class="text-center">
                    <a href="{$DOMAIN_NAME}" class="btn btn-primary">Trở về trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</div>