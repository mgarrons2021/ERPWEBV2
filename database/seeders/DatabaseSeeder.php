<?php

namespace Database\Seeders;

use App\Models\DetalleInventario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(TipoUsuarioSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ContratoSeeder::class);
        $this->call(TurnoSeeder::class);
        $this->call(CategoriaSancion::class);
        $this->call(CargoSucursalSeeder::class);
        $this->call(HorarioSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(UnidadMedidaSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(TareaSeeder::class);
        $this->call(CategoriaCajaChicaSeeder::class);
        $this->call(DiasSeeder::class);
        $this->call(ComprasSeeder::class);
        $this->call(DetalleCompraSeeder::class);
        $this->call(InventarioSeeder::class);
        $this->call(DetalleInventarioSeeder::class);
        $this->call(PedidoSeeder::class);
        $this->call(DetallePedidoSeeder::class);
        $this->call(EliminacionSeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}
