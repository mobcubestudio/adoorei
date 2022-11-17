<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id= : Id do produto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para importar produtos da API pública';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Limpa Tabela
        //DB::statement("truncate products");

        $id = ($this->option('id')) ?: null;
        $respose = Http::get('https://fakestoreapi.com/products/' . $id);


        if ($respose->status() !== 200) {
            $this->error("Erro ao conectar a API.");
            return Command::FAILURE;
        }

        if ($id) {
            return $this->importaUnico($respose);
        }

        return $this->importaLote($respose);
    }

    /**
     * Importa produtos da API externa em Lote
     *
     * @param Response $respose
     * @return int
     */
    protected function importaLote(Response $respose): int
    {
        $this->warn("Importação em lote");

        foreach ($respose->json() as $body) {

            if (Product::query()->where('name', $body['title'])->count() > 0) {
                $this->error("Produto duplicado: " . $body['title']);
            } else {
                if (Product::query()->create([
                    "name" => $body['title'],
                    "price" => $body['price'],
                    "category" => $body['category'],
                    "description" => $body['description'],
                    "image_url" => $body['image'],
                ])) {
                    $this->info("Produto Salvo: " . $body['title']);
                } else {
                    $this->error("Erro ao salvar o produto: " . $body['title']);
                }
            }

        }

        $this->line("Importação Finalizada");
        return Command::SUCCESS;
    }

    /**
     * Importa produto único de API externa
     * @param Response $respose
     * @return int
     */
    protected function importaUnico(Response $respose): int
    {
        $this->warn("Importação única",);
        $body = $respose->json();

        if(!isset($body['title'])){
            $this->error("Produto inexistente na API externa");
            return Command::FAILURE;
        }

        if (Product::query()->where('name', $body['title'])->count() > 0) {
            $this->error("Produto duplicado: " . $body['title']);
            return Command::FAILURE;
        }

        $productAdd = Product::query()->create([
            "name" => $body['title'],
            "price" => $body['price'],
            "category" => $body['category'],
            "description" => $body['description'],
            "image_url" => $body['image'],
        ]);

        if ($productAdd) {
            $this->info("Produto Salvo: " . $body['title']);
        } else {
            $this->error("Erro ao salvar o produto: " . $body['title']);
        }

        $this->line("Importação Finalizada");
        return Command::SUCCESS;
    }
}
