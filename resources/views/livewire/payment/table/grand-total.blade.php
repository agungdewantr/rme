<div>
    @php
        $grandTotal = 0;
        $grandTotal = array_reduce(
            $laborates,
            fn($a, $b) => $a + str_replace('.', '', $b['price']) * $b['qty'] - $b['discount'],
            0,
        );
        $grandTotal += array_reduce(
            $actions,
            fn($a, $b) => $a +
                str_replace('.', '', $b['price']) * $b['qty'] -
                str_replace('Rp', '', str_replace('.', '', $b['discount'])),
            0,
        );
        $grandTotal += array_reduce(
            $drugMedDevs,
            fn($a, $b) => $a +
                str_replace('.', '', $b['price']) * $b['qty'] -
                str_replace('Rp', '', str_replace('.', '', $b['discount'])),
            0,
        );
    @endphp
    <label for="" class="fw-bold text-black">Grand Total</label>
    <input type="text" id="grandTotal" value="Rp {{ number_format($grandTotal, 0, '.', '.') }}"
        class="form-control w-100" aria-describedby="passwordHelpInline" readonly>
</div>
