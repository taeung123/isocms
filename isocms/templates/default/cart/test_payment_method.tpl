<div class="" id="test_payment_method">
	<div class="container">
        <div class="row">
            <div class="col-6 offset-3 border mt-5 p-3" id="form_payment">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="payment_no">Mã giao dịch</label>
                        <input type="text" class="form-control" name="invoice_no" value="{$invoiceNo}" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Số tiền</label>
                        <input type="text" name="amount" class="form-control" value="{$amount}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <input type="text" name="description" class="form-control" value="{$description}" placeholder="Mô tả giao dich" required>
                    </div>

                    <div class="action text-center">
                        <button type="submit" class="btn btn-success">Thanh toán</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>