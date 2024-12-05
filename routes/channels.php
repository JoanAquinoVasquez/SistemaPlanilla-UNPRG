<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('formulas', function () {
    return true; // Permitir acceso público, ajustar según sea necesario
});
