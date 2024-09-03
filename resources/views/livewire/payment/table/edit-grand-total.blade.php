<div class="row">
    <div class="col-auto">
        <label for="" class="col-form-label fw-bold text-black">Grand Total</label>
    </div>
    <div class="col-auto">
        <input type="text" id="grandTotal" value="Rp {{ number_format($total, 0, '.', '.') }}" class="form-control"
            aria-describedby="passwordHelpInline" readonly>
    </div>
</div>
