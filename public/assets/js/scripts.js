BASE = $('meta[name="BASE"]').attr('content');

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let carregando = $('.carregando')
carregando.hide()

$('body').on('submit','form[name="excluir"]', function(){
    const confirma = confirm('Confirmar exclusão?')

    if(!confirma){
        return false
    }
})

$('.boxTotalEmprestimo').hide()
$('body').on('click', '.gerarParcelas', function(){
    carregando.show()
    $('.parcelas').html('')
    $('.boxTotalEmprestimo').fadeOut()
    const input_total = $('input[name="valor_total"]')
    input_total.val(0)

    let valor = parseFloat($('input[name="valor"]').val().replace('.','').replace(',','.'))
    const parcelas = $('select[name="parcela"]').val()
    let vencimento = $('input[name="vencimento"]').val()

    $.get(`${BASE}/painel/juros/taxas`, function(r) {
        if(r){
            let taxas = r
            let juros = taxas.find(t => parseFloat(valor) >= parseFloat(t.valor_inicial) && parseFloat(valor) <= parseFloat(t.valor_final))
            
            if(juros ===  'undefined'|| juros === null){
                alert('Não é possível realizar o emprestimo com o valor informado!')
                return false
            }

            valorTaxa = valor*(juros.taxa/100)
            valor +=  valorTaxa
            
            if(valor === '' || parseFloat(valor) === 0){
                alert('Digite o valor do emprestimo!')
                return false
            }else if(parcelas === ''){
                alert('Selecione a parcela!')
                return false
            }else if(vencimento === ''){
                alert('Digite a data de vencimento!')
                return false
            }

            venc = vencimento.split('-');
            var mes = parseInt(venc[1]);
            // vencimento = vencimento[2]+'-'+vencimento[1]+'-'+vencimento[0];

            let total_de_parcelas = 0
            let total_parcelado = 0
            for(var i = 1; i <= parcelas;i++){
                var dataPagamento = moment(vencimento);
                if(i != 1){
                    dataPagamento.set('month',mes);
                    mes = mes+1;
                }
                let parcela = valor/parcelas;

                parcelaAproximada =  Math.ceil(parcela);

                parcela = parcelaAproximada;

                if(i == parcelas){
                    parcela = valor-total_de_parcelas;
                }else{
                    total_de_parcelas += parcela;
                }

                var numeroparcela = '';
                if(i < 10){
                    numeroparcela = '0'+i;
                }else{
                    numeroparcela = i;
                }

                if(i == 1){
                    parcela_um = parcela;
                }

                total_parcelado += parcela;

                var conteudo =
                    `<div class="row py-1">
                        <div class="col-2 col-md-1">
                            <input type="hidden" name="guia[${i}][num_parcela]" value="${numeroparcela}">
                            <span class="form-control text-center" style="padding-left:2px;">${numeroparcela}</label>
                        </div>

                        <div class="col-5 col-md-5">
                            <input type="date" required name="guia[${i}][datavencimento]" class="form-control" value="${dataPagamento.format('DD/MM/YYYY')}">
                        </div>

                        <div class="col-5 col-md-5">
                            <input type="text" class="form-control moedaMask"  readonly name="guia[${i}][valor]" value="${parcela.toFixed(2)}">
                        </div>

                    </div>`

                $('.parcelas').append(conteudo)
                maskData()
                // data();
            }

            if(total_parcelado > 0){
                $('.boxTotalEmprestimo').fadeIn()
                $('.totalEmprestimo').text(total_parcelado.toFixed(2))
                input_total.val(total_parcelado.toFixed(2))
            }
        }
        carregando.hide()
    })
})

function carcula_jusros_venda(pedidovalor, taxa, parcelas){
    // UTILIZANDO A FÓRMULA
    var taxa_dividida = nanzero(taxa)/100;//DIVIDE A PORCENTAGEM POR CEM, RETORNANDO VALOR FRACIONÁRIO
    var taxa_dividida_mais_um = 1+taxa_dividida;//SOMA PORCENTAGEM DIVIDIDA + 1
    
    var taxa_multiplicada = Math.pow(taxa_dividida_mais_um, parcelas);//MULTIPLICA A TAXA DIVIDIDA POR ELA MESMO DE ACORDO A QUANTIDADE DE PARCELAS
   
    var taxa_multiplicada_vezes_taxa_dividida = (taxa_multiplicada*taxa_dividida);//MULTIPLICA A TAXA MULTIPLICADA POR ELA MESMA A PARDIR DAS PARCELAS E MULTIPLICA PELA TAXA DIVIDIDA POR 100

    var taxa_multiplicada_menos_um = taxa_multiplicada-1;//SUBTRAI A TAXA MULTIPLICADA POR ELE MESMO A PARTIR DAS PARCELAS POR 1

    var divide_taxa_multiplicada_vezes_taxa_dividida_portaxa_multiplicada_menos_um = taxa_multiplicada_vezes_taxa_dividida/taxa_multiplicada_menos_um;

    var valor_parcela = pedidovalor * divide_taxa_multiplicada_vezes_taxa_dividida_portaxa_multiplicada_menos_um;

    pedidovalor = valor_parcela*parcelas;

    return pedidovalor;
}

function nanzero(x){
    if(x==''){
        return eval(0);
    }else{
        return eval(x);
    }
    return eval(x);
}

$('body').on('submit', 'form[name="formEmprestimo"]',function(){
    if($('input[name="guia[1][num_parcela]"]').length === 0){
        alert('Necessário calcular as parcelas!')
        return false;
    }
})

maskData()
function maskData(){
    $('.data').mask('99/99/9999')
}

maskMoeda()
function maskMoeda(){
    $('.moeda').mask('000.000.000.000,00',{reverse:true})
}

porcentagem()
function porcentagem(){
    $('.pencent').mask('0000.00')
}

telefone()
function telefone(){
    $('.telefone').mask('(99) 99999-9999')
}
cpf()
function cpf(){
    $('.cpf').mask('999.999.999-99')
}