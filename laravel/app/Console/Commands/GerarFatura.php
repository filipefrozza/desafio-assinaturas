<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assinatura;
use App\Models\Fatura;

class GerarFatura extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatura:gerar-fatura';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar faturas a partir de assinaturas.';

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
        $endDate = now()->addDays(10);

        $assinaturas = Assinatura::where('data_vencimento', '<=', $endDate)
                                    ->where('data_vencimento', '>=', now())
                                    ->where('ativo', true)->get();
                                    
        foreach ($assinaturas as $assinatura) {
            $qtd_faturas = Fatura::where('assinatura_id', $assinatura->id)->where('data_vencimento', ">=", now())->count();
            
            if ($qtd_faturas == 0) {
                $this->info('Gerando fatura para a assinatura ' . $assinatura->id . ' - ' . $assinatura->descricao);
                $this->info('Vencimento ' . $assinatura->data_vencimento);
                $this->generateFatura($assinatura);
                $this->info('------------------');
            }
        }
        
        $this->info('Comando "Gerar Faturas" executado com sucesso.');
    }
    
    private function generateFatura($assinatura)
    {
        $fatura = new Fatura();
        $fatura->user_id = $assinatura->user_id;
        $fatura->assinatura_id = $assinatura->id;
        $fatura->data_vencimento = $assinatura->data_vencimento;
        $fatura->descricao = $assinatura->descricao;
        $fatura->codigo_barra = now()->format('YmdHis') . $assinatura->id;
        $fatura->valor = $assinatura->valor;
        // $fatura->save();
        
        $this->info('Fatura ' . $fatura->id . ' gerada para a assinatura ' . $assinatura->id . ' - ' . $assinatura->descricao);
        
        return $fatura;
    }
}
