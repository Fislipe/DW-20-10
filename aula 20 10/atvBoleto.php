<?php

interface Pagavel {
    public function total();
}

class ProdutoFisico {
    protected float $precoBase;

    public function __construct(float $preco) {
        $this->precoBase = $preco;
    }

    public function total(): float {
        return $this->precoBase;
    }
}

class Boleto implements Pagavel {
    private float $valor;

    public function __construct(float $valor) {
        $this->valor = $valor;
    }

    public function gerarCodigoBarras(): string {
        return "34191.09008 63396.892004 03080.400000 5 850300000" . rand(1000, 9999);
    }

    public function total(): float {
        return $this->valor;
    }
}

class ProdutoComDesconto extends ProdutoFisico {
    private float $desconto;

    public function __construct(float $preco, float $desconto) {
        parent::__construct($preco);
        $this->desconto = $desconto;
    }

    public function total(): float {
        return $this->precoBase - $this->desconto;
    }
}


$boleto = new Boleto(150.50);
echo "Boleto código: " . $boleto->gerarCodigoBarras() . "\n";

$produtoNormal = new ProdutoFisico(100.00);
$produtoDesconto = new ProdutoComDesconto(100.00, 25.00);

$listaMista = [$boleto, $produtoNormal, $produtoDesconto];

echo "\n--- Totais dos Itens na Lista ---\n";
foreach ($listaMista as $indice => $item) {
    if (method_exists($item, 'total')) {
        echo "Item " . ($indice + 1) . " - Total: RS" . number_format($item->total(), 2) . "\n";
    }
}

?>