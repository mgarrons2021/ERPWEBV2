<?php

namespace App\Observers;

use App\Models\Inventario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class InventarioObserver
{
    /**
     * Handle the Inventario "created" event.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return void
     */
    public function created(Inventario $inventario)
    {
       
    }

    /**
     * Handle the Inventario "updated" event.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return void
     */
    public function updated(Inventario $inventario)
    {
        //
    }

    /**
     * Handle the Inventario "deleted" event.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return void
     */
    public function deleted(Inventario $inventario)
    {
        //
    }

    /**
     * Handle the Inventario "restored" event.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return void
     */
    public function restored(Inventario $inventario)
    {
        //
    }

    /**
     * Handle the Inventario "force deleted" event.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return void
     */
    public function forceDeleted(Inventario $inventario)
    {
        //
    }
}
