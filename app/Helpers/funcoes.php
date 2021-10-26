<?php

function gravatar($email, $s = 180, $d = 'mm', $r = 'g', $img = false, $atts = array(), $classe) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' class="' . (isset($classe) ? $classe : '') . '" />';
    }
    return (string) $url;
}

function inteiroParaReal($valor) {
    return number_format($valor, 2, ',', '.');
}

function limpa_campo($valor){
    $valor = str_replace(['-', '.', '/',' ','(',')'], ['', '', '', '', '', ''], $valor);
    return $valor;
}

function valorBanco($valor) {
    $valor = str_replace([',', '.'], ['.', ''], $valor);
    return number_format($valor / 100, 2, '.', '');
}

function cpfEmNumero($cpf) {
    $cpf = str_replace(['-', '.', '/'], ['', '', ''], $cpf);
    return $cpf;
}

function data_para_banco($data) {
    return implode('-', array_reverse(explode('/', $data)));
}

function limitePontosCliente($pontos,$limite = null) {
    return ($pontos * 100);
}


function extensoreais($valor = 0, $maiusculas = false) {

    $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
        "quatrilhões");

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
        "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
        "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
        "dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
        "sete", "oito", "nove");

    $z = 0;
    $rt = "";

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for ($i = 0; $i < count($inteiro); $i++)
        for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
            $inteiro[$i] = "0" . $inteiro[$i];

    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];

        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000")
            $z++;
        elseif ($z > 0)
            $z--;
        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
            $r .= (($z > 1) ? " de " : "") . $plural[$t];
        if ($r)
            $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                    ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    if (!$maiusculas) {
        return($rt ? $rt : "zero");
    } else {

        if ($rt)
            $rt = prerg_replace(" E ", " e ", ucwords($rt));
        return (($rt) ? ($rt) : "Zero");
    }
}

function replace_palavras_chaves($conteudo, $pedido = null, $itens = null, $cliente = null, $dado_carne = null) {

   
    $palavras = [];

    $replace = [];

    return str_replace($palavras,$replace,$conteudo);
}

function mes_extenso($mes){
    $meses = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Março',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Setembro',
        'Sep' => 'Outubro',
        'Oct' => 'Novembro',
        'Dec' => 'Dezembro'
    );
    return $meses[$mes];
}

function mes_numero_nome($mes){
    $meses = array(
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro'
    );
    return $meses[$mes];
}

function soma_valores($valores) {
    $valor_total = 0;

    if($valores){
        foreach ($valores as $v):
            $valor_total += $v;
        endforeach;
    }

    return $valor_total;
}
