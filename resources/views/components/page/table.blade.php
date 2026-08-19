<div class="table-responsive">

    <table {{ $attributes->merge([
        'class' => 'table table-hover table-bordered table-striped mb-0 align-middle'
    ]) }}>

        {{ $slot }}

    </table>

</div>