<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class FormulaAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $formula;

    public function __construct($formula)
    {
        $this->formula = $formula; // Número actualizado de fórmulas
    }

    public function broadcastOn()
    {
        return new Channel('formulas'); // Canal al que se suscribirá React
    }

    public function broadcastAs()
    {
        return 'formula.added'; // Nombre del evento
    }
}
